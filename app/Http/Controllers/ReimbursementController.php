<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ApprovementController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\ServiceController;
use App\Models\UserAccessConnection;
use App\Models\ReimbursementPolicies;
use App\Models\ReimbursementRequest;
use App\Models\ReimbursementTaken;
use App\Models\ReimbursementQuota;
use App\Models\ReimbursementAssign;
use App\Models\Message;
use App\Models\Employee;
use Carbon\Carbon;
use App\Models\ApproverList;
use Sentinel;
use Constant;
use Storage;
use App\Models\User;
use MailService;
use App\Models\Approvement;
use App\Http\Requests\CancelReimbursementPolicyRequest;
use DB;
use Config;
use UserService;
use App\Http\Requests\ReimbursementPoliciesRequest;
class ReimbursementController extends Controller
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
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index($month=NULL,$year=NULL)
  {
    // 1. list policies
    $policylist=ReimbursementPolicies::withTrashed()->get();
    $listApprove=ReimbursementRequest::all()->toArray();
    // list user_access

    if(UserService::isSuperAdmin()) {
      $users= Sentinel::getUser()->getData();
      $listPending = $this->getRequestList();
      $takenlist = ReimbursementTaken::all();
      return view('reimbursement/index'
          ,['title_page'=>'Reimbursement'
            ,'list'=>$policylist
            ,'list_pending'=>$listPending
            ,'taken_list'=>$takenlist
            ,'users'=>$users
            ,'month'=>$month
            ,'year'=>$year]);
    }
    if (UserService::getUserEmployee() == true) {
      $availableReimbursement= ReimbursementAssign::with(['policy'=>function($q) {
        $q->where('deleted_at',null)->where('effective_date','<=',Carbon::now());
      }])->where('employee_id_fk', Sentinel::getUser()->userAccessConnection->employee_id_fk)
          ->get();
          //dd($availableReimbursement);
      return view('reimbursement/index-employee'
        ,['title_page'=>'Reimbursement'
          ,'myReimbursementList'=>$this->getAllReimbursementRequest()
          ,'availableReimbursement'=>$availableReimbursement
          ,'month'=>$month
          ,'year'=>$year
          ,'generalHeaderTitle1'=>'Reimbursement History']);
    }
  }
    
  /**
   *  get list of employee who assigned to this policy
   *  fired when admin click "edit policy" icon
   *  @param int policy_id
   *  @return list of employees
   */
  protected function getReimbursementAssign($id){
    // return response()->json($id);
    $employees = ReimbursementAssign::where('policy_id_fk',$id)->lists('employee_id_fk');
    $policy = ReimbursementPolicies::find($id);
    if ($policy->default_flag==1) $default=true;
    else $default=false;
    return response()->json(['employees'=>$employees,'default'=>$default]);
  }


  /**
   *  change time off assign (adding or removing auto-assign)
   *  @param $request = list of employees
   */
  protected function editReimbursementAssign(Request $request){
    $inputs=$request->all();
    $lists=explode(',',$request->approver_list);
    $listDeleted = ApproverList::where('policy_type', Constant::BOX_TYPE_REIMBURSEMENT)->where('policy_id_fk',$inputs['modalEP-id'])->whereNotIn('approver_id_fk',$lists)->get();
    foreach ($listDeleted as $deleteApprover) {
      $deleteApprover->delete();
    }
    foreach($lists as $list){
       if($list != null && ApproverList::where('approver_id_fk',$list)->where('policy_id_fk', $inputs['modalEP-id'])->get()->count() == 0){
         $approver = new ApproverList;
         $approver->policy_type = Constant::BOX_TYPE_REIMBURSEMENT; // 3 for REIMBURSEMENT
         $approver->policy_id_fk = $inputs['modalEP-id'];
         $approver->approver_id_fk = $list;
         $approver->save();
      }
    }

    if(isset($inputs['default_flag'])){
      ReimbursementPolicies::find($inputs['modalEP-id'])->update(['default_flag'=>1]);
    }
    else{
      ReimbursementPolicies::find($inputs['modalEP-id'])->update(['default_flag'=>0]);
    }

    ReimbursementAssign::where('policy_id_fk',$inputs['modalEP-id'])
          ->delete();
    // make new assignments
    if(isset($inputs['employees'])){
      $reimbursement_policies = ReimbursementPolicies::find($inputs['modalEP-id']);
      $assign_date=Carbon::now();
      $expired_date=$assign_date->copy()->addYear()->subDay(); // set expired date to 1 year after
      foreach ($inputs['employees'] as $employee) {
        

        $oldAssign = ReimbursementAssign::where('employee_id_fk', $employee)
                      ->where('policy_id_fk',$inputs['modalEP-id'])
                      ->get();
        $insertQuota = $oldAssign->count()==0 && $reimbursement_policies->effective_date <= Carbon::now();
        $assign = new ReimbursementAssign;
        $assign->policy_id_fk = $inputs['modalEP-id'];
        $assign->employee_id_fk = $employee;
        $assign->assign_date='1-1';
        $assign->expired_date='31-12';
        $assign->save();

        if($insertQuota) {
          $quota = new ReimbursementQuota;
          $quota->policy_id_fk = $inputs['modalEP-id'];
          $quota->employee_id_fk = $employee;
          $quota->amount = $reimbursement_policies->limit;
          $quota->effective_date = $assign_date;
          $quota->expired_date = $expired_date;
          $quota->created_by = 0;
          $quota->unlimited_flag=$reimbursement_policies->unlimited_flag;
          $quota->save();
        }
      }
    }

    
    return response()->json(['status'=>'success','url'=>route('reimbursement.index').'#policy']);
  }

  public function getReimbursementBalance($policy_id_fk) {
    if (isset($policy_id_fk)==null ) {
      return response()->json(['status'=>'failed','message'=>'policy not found!']);;
    }
    //dd(ReimbursementPolicies::find($policy_id_fk));
    $userAccess = ReimbursementAssign::where('policy_id_fk',$policy_id_fk)->where('deleted_at',null)->get(['employee_id_fk'])->toArray();
    //dd($userAccess);
    $list = Employee::whereIn('id',$userAccess)->get();
    //dd($list);
    $return = array();
    foreach($list as $employee) {
      $employee['employee_id'] = $employee->employee_id;
      $employee['name'] = $employee->first_name.' '.$employee->last_name;

      $lastAssignedQuota = ReimbursementQuota::where('policy_id_fk',$policy_id_fk)
                                             ->where('employee_id_fk',$employee->id)
                                             ->orderBy('created_date','DESC')->first();
      $employee['isunlimited'] = false;
      if($lastAssignedQuota) {
        if($lastAssignedQuota->unlimited_flag) {
          $employee['isunlimited'] = true;
          $employee['quota'] = $employee['balance'] = '&infin;';
        }
        else {
          $employee['quota'] = number_format($lastAssignedQuota['amount'],0,'.',',');
          $employee['balance'] = number_format(ReimbursementQuota::getMyBalancePerPolicy($policy_id_fk, $employee->id),0,'.',',');
        }
      }
      else {
        $employee['quota'] = $employee['balance'] = 0;
      }
      $employee['taken'] = ReimbursementTaken::totalMyApprovedMountPerPolicy($policy_id_fk, $employee->id);
      $return[] = $employee;


    }
    return $return;
  }

  protected function getAllReimbursementRequest() {
      $user = Sentinel::getUser();
      $reimbursementlist = ReimbursementRequest::with(['policy','employee'])
                             ->where(function($q) use ($user) {
                                 $q->Where('employee_id_fk',$user->userAccessConnection->employee_id_fk);
                              })
                             ->where('deleted_at',null)
                             ->orderBy('created_date', 'DESC')->get();

      $return = array();
      foreach ($reimbursementlist as $reimbursement){
          $reimbursement['created_date']=ServiceController::parseDate($reimbursement->created_date);

          if($reimbursement->approved_flag == 1 || $reimbursement->approved_flag == 2)  {
            $approvement = Approvement::where('fk_ref', $reimbursement->id)->where('box_type', Constant::BOX_TYPE_REIMBURSEMENT)->where('approved_flag',$reimbursement->approved_flag)->first();
            if($approvement) {
              $type = $reimbursement->approved_flag == 1 ? 'Approved' : 'Rejected';
              $reimbursement['approvement'] = $type.' Date: '.$approvement->approved_date;

              if($approvement->reason) $reimbursement['approvement'] .= ' | '.$type. ' Reason: '.$approvement->reason;
            }

          }
          $return[] = $reimbursement;


      }
      return $return;
    }
  /**
   * Get request list that are waiting for approval
   */
  protected function getRequestList(){

    $user = Sentinel::getUser();
    $id = Approvement::where('box_type',Constant::BOX_TYPE_REIMBURSEMENT)
                     ->where('approved_flag',0) // 0 = PENDING
                     // ->where('approved_flag','!=',2) // 2 = REJECTED
                     ->where('approved_by',$user->id)
                     ->get(['fk_ref'])->toArray();

    $query = ReimbursementRequest::with(['policy','employee'])
                           ->where(function($q) use ($id,$user) {
                               $q->whereIn('id',$id);
                               $q->orWhere('employee_id_fk',$user->userAccessConnection->employee_id_fk);
                            })
                           ->where('approved_flag',0)
                           ->where('deleted_at',null);
    return $query->get();
  }

 /**
  * [doCreate create ReimbursementPolicies]
  * @param  Request $request [description]
  * @return [type]           [description]
  */
  public function doCreate(ReimbursementPoliciesRequest $request){
    $model=new ReimbursementPolicies;
     $inputs=$request->all();

    if(isset($inputs['unlimited_flag'])){
      $inputs['unlimited_flag']=1;
    }
    else{
      $inputs['unlimited_flag']=0;
    }
    //dd($inputs['unlimited_flag']);
    $model->insertData($inputs);
     $lists=explode(',',$request->approver_list);
      foreach($lists as $list){
        if($list != null){
          $approver = new ApproverList;
          $approver->policy_type = Constant::BOX_TYPE_REIMBURSEMENT; // 3 for reimbursement
          $approver->policy_id_fk = $model->id;
          $approver->approver_id_fk = $list;
          $approver->save();
        }
     }

      // === create reimbursement_assign for auto assign this reimbursement policy each period ===
      if(isset($inputs['allEmployee'])) $inputs['employees'] = Employee::lists('id')->toArray();
      $today=Carbon::today();

      
      if(isset($inputs['employees'])) {
        foreach ($inputs['employees'] as $employee) {
          $assign = new ReimbursementAssign;
          $assign->policy_id_fk = $model->id;
          $assign->employee_id_fk = $employee;
          $assign->assign_date= '01-01';
          $assign->expired_date= '31-12';
          $assign->save();

          if ($inputs['effective_date']<=$today){ // && $assign_date<=$today && $expired_date>=$today){
            $quota = new ReimbursementQuota;
            $quota->policy_id_fk = $model->id;
            $quota->employee_id_fk = $employee;
            if($inputs['unlimited_flag'] == 1) {
              $quota->amount = 0;
              $quota->unlimited_flag=1;
            } else $quota->amount = $model->limit;
            $quota->effective_date = $inputs['effective_date'];
            $quota->expired_date = '31-12-'.$today->year;
            $quota->created_by = Sentinel::getUser()->id;
            $quota->save();
          }
        }
        
      }

     return response()->json(['status'=>'success','url'=>route('reimbursement.index').'#policy']);
  }

  public function doRequest(Request $request){
    // step
    // 1. create reimbursement request
    // 2. create message to employeer
    // 3. send email to employeer
    $model=new ReimbursementRequest();
    $inputs=$request->all();
     // example
    //  $inputs['policy_id_fk']=3;
    //  $inputs['reason']='testing';
    //  $inputs['start_date']=Carbon::now();
    //  $inputs['end_date']=Carbon::now();
   
     $user = Sentinel::getUser(); // we will use Sentinel::getUser() many times

     // requester should be an employee, and should have an employee_id.
     // store this id in timeoff_request table
     $model->employee_id_fk=$user->userAccessConnection->employee_id_fk;

     if($model->employee_id_fk==null){
        return response()->json(['status'=>'not employee']);
     }
     if (!$model->validate($inputs)) {
       return response()->json($model->errors());
     }

    $ReimbursementPolicy = ReimbursementPolicies::find($inputs['policy_id_fk']);
    if(!$ReimbursementPolicy->unlimited_flag) {
      //validate days amount to balance i have
       $myBalance = ReimbursementQuota::getMyBalancePerPolicy($inputs['policy_id_fk'], $user->userAccessConnection->employee_id_fk);
       if($inputs['amount'] > $myBalance) {
          return response()->json(['amount'=>['Your balance is not enough']]);
       }
     }
     $inputs['attachment'] = $this->uploadFile($request,'reimbursement');

     $model->insertData($inputs);
     if($model->save()){
       $data=[];
       $data['sender_email']=$user->email;
       $data['sender_name']=$user->name;
       $data['type']=Constant::BOX_TYPE_REIMBURSEMENT;
       $data['reason']=$inputs['reason'];
       $data['subject']='Reimbursement Request';
       $data['fk_ref']=$model->id;

       // request will be sent to receivers (approver_lists) for selected policy
       $id_list=ApproverList::where('policy_id_fk',$inputs['policy_id_fk'])
             ->where('policy_type',Constant::BOX_TYPE_REIMBURSEMENT)
             ->get(['approver_id_fk'])
             ->pluck('approver_id_fk'); //id as array [1,3,6, ... etc]
       $data['receivers']=User::whereIn('id',$id_list)->get();

       //make approvement, message, and email request
       ApprovementController::createApprovalList($data);
       MessageController::createCustomMessage($data);
       $data['datedesc']=$inputs['amount'];
       $data['template_name']='emails.request-reimbursement';
       $data['ess_type']='reimbursement';
       MailService::emailRequestWithCode($data);
     }
     return response()->json(['status'=>'success','url'=>route('reimbursement.index')]);
  }



  protected function editQuota(Request $request){
    $inputs=$request->all();
    $quota = new ReimbursementQuota;
    //validate
    if (!$quota->validate($inputs)) {
      return response()->json($quota->errors());
    }

    $assign_date=Carbon::now();
    $expired_date=$assign_date->copy()->addYear()->subDay(); // set expired date to 1 year after
    $quota->amount=$inputs['balance']; 
    $quota->policy_id_fk = $inputs['policy_id'];
    $quota->employee_id_fk = $inputs['employee_id'];
    $quota->effective_date = $assign_date;
    $quota->expired_date = $expired_date;
    $quota->created_by = Sentinel::getUser()->id;
    $quota->save();

    $newbalance = number_format(ReimbursementQuota::getMyBalancePerPolicy($inputs['policy_id'], $inputs['employee_id']),0,'.',',');
    return response()->json(['status'=>'success', 'newbalance' => $newbalance]);
  }

    /**
     * upload file
     * @param  Request $request, $foldername="avatar"
     * @return [type]           [description]
     */
    protected function uploadFile(Request $request, $folderName){

      // if($request->image_data==null) return;
      $data = explode(',', $request->attachment);
      $randomString = str_random(40);
      $fileName= $randomString.$request->fileExt;
      $fullpath= $folderName."/".$fileName;
      $contentFile=base64_decode($data[1]);
      $storage = Storage::disk('s3')->getDriver()->put(
                $fullpath,
                $contentFile,
                [ 'StorageClass' => 'REDUCED_REDUNDANCY',
                  'ContentType' => 'application/force-download']
            );
      // $modelUser->avatar=$fileName;
      // $modelUser->save();
      return $fileName;//response()->json(['status'=>'success']);
    }

  /**
    * redirect to download link
    * @param
    */
  //// TODO: jangan dipake lagi, pake function getAttachmentURL dari model ReimbursementRequest aja
  protected function downloadAttachment($filename){
    $bucketName = 'https://s3-ap-southeast-1.amazonaws.com/talenta-lite/reimbursement/';
    $pathToFile = $bucketName.$filename;
    return \Redirect::away($pathToFile);
  }
  protected function doExpire (Request $request){
    $model=ReimbursementPolicies::destroy($request->id);
    return response()->json(['status'=>'success','url'=>route('reimbursement.index')."#policy"]);
  }

  protected function getRequestDetail(Request $request){
    $detail=ReimbursementRequest::find($request->id);
    $detail->policyName = $detail->policyName();
    $detail->employeeName = $detail->employeeName();
    $detail->created_date = ServiceController::parseDate($detail->created_date);
    $detail->attachment = $detail->attachmentURL();
    $detail->approver = $detail->getPendingApproverName();
    return response()->json($detail);
  }

  protected function getHistoryDetail(Request $request){
    $detail=ReimbursementTaken::find($request->id);
    $detail->policyName = $detail->policyName();
    $detail->employeeName = $detail->employeeName();
    $detail->getCreated_date();
    $detail->getApproverName();
    $detail->date_reimburse = ServiceController::parseDate($detail->date_reimburse);
    $detail->attachment = $detail->request->attachmentURL();
    return response()->json($detail);
  }

  /**
   * get policy detail
   */
  protected function getPolicyDetail(Request $request){
    $model=ReimbursementPolicies::withTrashed()->find($request->id);
    $model->limit_type=$model->getLimitTypeFormat();
    if($model->deleted_at){
        $model->deleted_at=ServiceController::parseDate($model->deleted_at);
    }
    $model->effective_date=ServiceController::parseDate( $model->effective_date);
    return response()->json($model);
  }


  public function doReject(Request $request){
    $id = $request->input('id');
    $data['reason'] = $request->input('reason');
    $data['msg_model'] = Message::where('fk_ref',$id)->where('box_type',Constant::BOX_TYPE_REIMBURSEMENT)->first();
    $app = ApprovementController::rejectRequest($data);
    if ($app) return response()->json(['status'=>'rejected']);
    else return response()->json(['status'=>'unauthorized']);
  }

  public function doApprove(Request $request){
    $id = $request->input('id');
    $data['reason']=$request->input('reason');
    $data['msg_model'] = Message::where('fk_ref',$id)->where('box_type',Constant::BOX_TYPE_REIMBURSEMENT)->first();
    $app = ApprovementController::approveRequest($data);
    if ($app) return response()->json(['status'=>'approved']);
    else return response()->json(['status'=>'unauthorized']);
  }

}
