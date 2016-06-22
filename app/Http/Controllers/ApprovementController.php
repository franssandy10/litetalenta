<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ServiceController;
use Constant;
use App\Models\Approvement;
use App\Models\TimeOffRequest;
use App\Models\ReimbursementRequest;
use App\Models\Message;
use App\Models\User;
use App\Models\TimeOffTaken;
use App\Models\TimeOffQuota;
use Sentinel;
use Carbon\Carbon;
use MailService;
use App\Models\ReimbursementTaken;
class ApprovementController extends Controller
{
  /**
   * Create a new authentication controller instance.
   *
   * @return void
   */
  public function __construct()
  {
      $this->middleware('auth');
      $this->middleware('role');
  }
    public static function createApprovalList(Array $data){
      $list=$data['receivers'];
      foreach($list as $key=> $receiver){
        $model=new Approvement();
        $model->box_type=$data['type'];
        $model->fk_ref=$data['fk_ref'];
        $model->approved_by=$receiver->id;
        $model->approved_flag=0;
        $model->position=$key;
        $model->save();
      }
    }

    public static function approveData(Array $data){
      $model=Approvement::where('box_type',$data['type'])
        ->where('fk_ref',$data['fk_ref'])
        ->where('approved_by',Sentinel::getUser()->id)->first();
      if (!$model) return false;
      $model->approved_date=Carbon::now();
      $model->reason=$data['reason'];
      $model->insertData($data);
      return true;
    }

    public static function rejectRequest(Array $data){
      // type_approve 1 means approve
      // type_approve 2 means reject
      $data['approved_flag']=2;
      $data['type']=$data['msg_model']['box_type'];
      $data['fk_ref']=$data['msg_model']['fk_ref'];

      // // one of the approver rejected, then this request officially REJECTED and another approver doesnt have to give approvement
      // // put flag = disabled in all approvements for this request
      // put flag = rejected in this approvement
      if (!ApprovementController::approveData($data)) return false; //return if user doesnt have authorization to approve

      // prepare to send reject notification message
      if($data['type']==Constant::BOX_TYPE_TIMEOFF){
        $timeoff = TimeOffRequest::find($data['fk_ref']);
        $timeoff->approved_flag = 2;
        $timeoff->save();
        $dateText = date('D, F jS', strtotime($timeoff->start_date)).
                    ' until '.
                    date('D, F jS',strtotime($timeoff->end_date));
        $var = array();
        $var[1]= $dateText;
        $var[2] = 'Rejected';
        $var[3] = $data['reason'];
        $data['sender_name']=Sentinel::getUser()->name;
        $data['subject'] = 'Time Off Request Rejected';
        $data['reason'] = 'Your Time Off Request for '.$dateText.' has been <strong>rejected. Reason: '.$data['reason'];
        // $data['reason'] = 'Your Time Off Request for '.$dateText.' was rejected. Reason: '.$data['reason'];
        $data['receivers']=User::where('id',$data['msg_model']['sender_id_fk'])->get(); //sengaja pake get agar jadi array
        $data['template_name']='emails.timeoff-approval';
      }
      else if($data['type']==Constant::BOX_TYPE_REIMBURSEMENT){
        $tempModel = ReimbursementRequest::find($data['fk_ref']);
        // $tempModel->approved_flag = 2;
        // $tempModel->save();
        $var = array();
        $var[0] = 'Rp.'.number_format($tempModel->amount,2,'.',',');
        $var[2] = 'Rejected';
        $var[3] = $data['reason'];
        $data['sender_name']=Sentinel::getUser()->name;
        $data['subject'] = 'Reimbursement Request Rejected';
        $data['reason'] = 'Your Reimbursement Request for Rp.'.number_format($tempModel->amount,2,'.',',').' was rejected. Reason: '.$data['reason'];
        $data['receivers']=User::where('id',$data['msg_model']['sender_id_fk'])->get(); //sengaja pake get agar jadi array
        $data['template_name']='emails.reimbursement-approval';

      }
      $data['fk_ref']=0; //bikin jd 0 biar dianggep kayak message biasa
      MessageController::createCustomMessage($data);
      $data['datedesc']=''; //dummy
      $data['ess_type']=''; //dummy
      MailService::emailRequestWithCode($data,$var);
      return true;
    }

    public static function approveRequest(Array $data){
      // type_approve 1 means approve
      // type_approve 2 means reject
      $data['approved_flag']=1;
      $data['type']=$data['msg_model']['box_type'];
      $data['fk_ref']=$data['msg_model']['fk_ref'];

      // put flag = approved in this approvement
      if (!ApprovementController::approveData($data)) return false; //return if user doesnt have authorization to approve

      // this approval become valid when ALL approver have approved this request
      if (ApprovementController::checkOtherApproval($data['type'],$data['fk_ref']) ) {
        // prepare to send approve notification message
        if($data['type']==Constant::BOX_TYPE_TIMEOFF){
          $timeoff = TimeOffRequest::find($data['fk_ref']);
          $timeoff->approved_flag = 1;
          $timeoff->save();
          $dateText = date('D, F jS', strtotime($timeoff->start_date)).
                      ' until '.
                      date('D, F jS',strtotime($timeoff->end_date));
          $var = array();
          $var[1] = $dateText;
          $var[2] = 'Approved';
          $var[3] = $data['reason'];
          $data['sender_name']=Sentinel::getUser()->name;
          $data['subject'] = 'Time Off Request Approved';
          $data['reason'] = 'Your Time Off Request for '.$dateText.' was approved. Reason: '.$data['reason'];
          $data['receivers']=User::where('id',$data['msg_model']['sender_id_fk'])->get(); //sengaja pake get agar jadi array
          $data['template_name']='emails.timeoff-approval';

          // make TimeOffTaken
          if ($timeoff->half_day==1) {
            $dateincrement = $timeoff->start_date;
            $taken = new TimeOffTaken;
            $taken->fk_ref = $timeoff->id;
            $taken->employee_id_fk = $timeoff->employee_id_fk;
            $taken->policy_id_fk = $timeoff->policy_id_fk;
            $taken->day_amount = 0.5;
            $taken->has_approver= Sentinel::getUser()->id; //by request
            $taken->date = $dateincrement;
            $taken->save();
          }
          else {
            $dayOff = ServiceController::getDayOff();
          
            $MyDateNow = Carbon::parse($timeoff->start_date);
            $MyDateEnd = Carbon::parse($timeoff->end_date);
            for($date=$MyDateNow;$date<=$MyDateEnd;$date=$date->addDay()) {
              if(!in_array(strtolower($date->format('l')),$dayOff)){
                $taken = new TimeOffTaken;
                $taken->fk_ref = $timeoff->id;
                $taken->employee_id_fk = $timeoff->employee_id_fk;
                $taken->policy_id_fk = $timeoff->policy_id_fk;
                $taken->day_amount = 1;
                $taken->has_approver= Sentinel::getUser()->id; //by request
                $taken->date = $date;
                $taken->save();
              }
            }
          }
                 
        }
        else if($data['type']==Constant::BOX_TYPE_REIMBURSEMENT){
          $tempModel = ReimbursementRequest::find($data['fk_ref']);
          $tempModel->approved_flag = 1;
          $tempModel->save();
          $var = array();
          $var[0] = 'Rp.'.number_format($tempModel->amount,2,'.',',');
          $var[2] = 'Approved';
          $var[3] = $data['reason'];
          $data['sender_name']=Sentinel::getUser()->name;
          $data['subject'] = 'Reimbursement Request Approved';
          $data['reason'] = 'Your Reimbursement Request for Rp.'.number_format($tempModel->amount,2,'.',',').' was approved. Reason: '.$data['reason'];
          $data['receivers']=User::where('id',$data['msg_model']['sender_id_fk'])->get(); //sengaja pake get agar jadi array
          $data['template_name']='emails.reimbursement-approval';
          // save ke taken
          $taken=new ReimbursementTaken;
          $taken->employee_id_fk=$tempModel->employee_id_fk;
          $taken->request_id_fk=$data['fk_ref'];
          $taken->date_reimburse=Carbon::now();
          $taken->amount=$tempModel->amount;
          $taken->has_approver=Sentinel::getUser()->id; //by request
          $taken->save();


        }
        $data['fk_ref']=0; //bikin jd 0 biar dianggep kayak message biasa
        MessageController::createCustomMessage($data);
        $data['datedesc']='';//dummy
        $data['ess_type']='';//dummy
        MailService::emailRequestWithCode($data,$var);
      }
      return true;
    }

    /**
     * Function fired when user click a link in approvement email
     * @param int $type_ref = same as box_type (2: timeoff; 3: reimbursement)
     * @param id $fk_ref = id at request table
     * @param id $receiver = receiver's user_access_id as approver
     * @param int $status = if user's ESS setting enabled, they can {1: approve || 2: reject} request from email
     * @return redirect to message, display the request message
     */
    public static function approveFromEmail($type_ref,$fk_ref,$receiver,$status=''){
        if($status!=''){ //depends on user's personal ESS settings

          // check is this approval has been approved?
          $check = Approvement::where('box_type',$type_ref)
                              ->where('fk_ref',$fk_ref)
                              ->where('approved_by',$receiver)->first();
          if($check->approved_flag==0){
            $data=[];

            // accept or reject approval
            $data['msg_model'] = Message::where('box_type',$type_ref)->where('fk_ref',$fk_ref)->first();
            if($status==1){
              $data['reason']='Approved from e-mail, reason not recorded';
              ApprovementController::approveRequest($data);
            }else if($status==2){
              $data['reason']='Rejected from e-mail, reason not recorded';
              ApprovementController::rejectRequest($data);
            }
          }
        }
        $message=Message::where('box_type',$type_ref)->where('fk_ref',$fk_ref)->where('receiver_id_fk',$receiver)->first();
        return redirect()->route('message',['id'=>$message->id]);
    }

    /**
     * check approvals for request
     * @return boolean (is the request already approved by all approver?)
     */
    public static function checkOtherApproval($boxType,$fk_ref){
      // check: is there any approver who have not approved this request?
      $count = Approvement::where('fk_ref',$fk_ref)
                         ->where('box_type',$boxType)
                         ->where('approved_flag','!=',1) // 1 = approved
                         ->count();
      if($count==0) return true; // all flag==1, request approved by all approver
      else return false; // request still pending or already rejected
    }

    /**
     * disable all approval for request
     */
    public static function disableApproval($boxType, $fk_ref){
      Approvement::where('fk_ref',$fk_ref)
                  ->where('box_type',$boxType)
                  ->update(['approved_flag' => 3]);
    }
}
