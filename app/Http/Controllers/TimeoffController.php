<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\CreateTimeOffPolicyRequest;
use App\Http\Controllers\Controller;
use App\Models\TimeOffPolicies;
use App\Models\TimeOffRequest;
use App\Models\Message;
use App\Models\Approvement;
use App\Models\TimeOffTaken;
use App\Models\TimeOffAssign;
use App\Models\TimeOffQuota;
use App\Models\Employee;
use Carbon\Carbon;
use Sentinel;
use App\Models\User;
use MailService;
use Constant;
use UserService;
use App\Models\ApproverList;
use DB;
use Config;
class TimeoffController extends Controller
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
    public function index()
    {
      $policyList=$this->getPolicyList();
      $requestList['pending']=$this->getRequestList();
      $requestList['history']=$this->getHistoryList();
      $users= Sentinel::getUser()->getData();
      if(UserService::isSuperAdmin()) {
        return view('timeoff/index',['list'=>$policyList,'requestList'=>$requestList,'users'=>$users]);
      }
      if (UserService::getUserEmployee() == true) {
      // dd($requestList['history'][0]->toArray());
        $availableTimeOff = TimeOffAssign::with(['policy'=>function($q) {
        $q->where('deleted_at',null)->where('effective_date','<=',Carbon::now());
      }])->where('employee_id_fk', Sentinel::getUser()->userAccessConnection->employee_id_fk)
          ->get();
        return view('timeoff/index-employee',['myTimeOffList'=>$this->getAllMyTimeOffRequest(),'generalHeaderTitle1'=>'Time Off History','availableTimeOff'=>$availableTimeOff]);      }


    }
    protected function getAllMyTimeOffRequest() {
      $user = Sentinel::getUser();
      $timeofflist = TimeOffRequest::with(['policy','employee'])
                             ->where(function($q) use ($user) {
                                 $q->Where('employee_id_fk',$user->userAccessConnection->employee_id_fk);
                              })
                             ->where('deleted_at',null)
                             ->orderBy('start_date', 'DESC')->get();

      $return = array();
      foreach ($timeofflist as $timeoff){
          $timeoff['start_date']=ServiceController::parseDate($timeoff->start_date);
          $timeoff['end_date']=ServiceController::parseDate($timeoff->end_date);
          if ($timeoff['half_day']==1) $timeoff['amount'] = 'half day';
          else {

            if($timeoff->approved_flag == 0 || $timeoff->approved_flag == 2) {
                  $timeoff['amount'] = ServiceController::countDays($timeoff['start_date'],$timeoff['end_date'],1);

              }
              else if($timeoff->approved_flag == 1) {
                  $timeoff['amount'] = ServiceController::countDaysApproveByReuqestId($timeoff['id']);

              }
          }

          if($timeoff->approved_flag == 1 || $timeoff->approved_flag == 2)  {
            $reason = Approvement::where('fk_ref', $timeoff->id)->where('box_type', Constant::BOX_TYPE_TIMEOFF)->where('approved_flag',$timeoff->approved_flag)->first()->reason;
            if($reason) {
              $type = $timeoff->approved_flag == 1 ? 'Approved Reason: ': 'Rejected Reason: ';
              $timeoff['approvement_reason'] = $type.$reason;
            }
          }
          $return[] = $timeoff;
      }

      return $return;
    }
    /**
     *
     */
    protected function getPolicyList(){

      $policies= TimeoffPolicies::withTrashed()->get();
      // print_r($policies);exit;
      foreach ($policies as $policy){
        $policy->effective_date = ServiceController::parseDate($policy->effective_date);
        if($policy->deleted_at){
            $policy->deleted_at = ServiceController::parseDate($policy->deleted_at);
        }
      }
      return $policies->toArray();
    }
    /**
    * get History
    */
   protected function getHistoryList($month=0,$year=0){
     $user = Sentinel::getUser();
     $query = TimeOffTaken::with(['policy','employee','timeoffrequest'])
               ->where('employee_id_fk',$user->userAccessConnection->employee_id_fk)
               ->orderBy('created_date', 'DESC');
     // if ($month && $year){
     //     $query->whereBetween('date', ['01/'.$month.'/'.$year,'31/'.$month.'/'.$year]);
     // }
     $return = array();
     foreach ($query->get() as $list){
         //format date
         $list['dateF']=ServiceController::parseDate($list->date);
         $return[] = $list;
     }
     // if($month) return ;//view('timeoff/index',['list'=>$policyList,'requestList'=>$dummy]);
     // else
       return $return;
   }

   /**
      * Get request list that are waiting for approval
      * @param $key, $criteria : Filter for searching or categorizing
      */
     protected function getRequestList($searchKey=''){
       $user = Sentinel::getUser();
       $id = Approvement::where('box_type',2) // 2 = TIMEOFF
                        ->where('approved_flag',0) // 0 = PENDING
                        // ->where('approved_flag','!=',2) // 2 = REJECTED
                        ->where('approved_by',$user->id)
                        ->get(['fk_ref'])->toArray();
       // $id = array();
       // foreach($id_collection as $ids){
       //   $id[] = $ids['fk_ref'];
       // }

       $query = TimeOffRequest::with(['policy','employee'])
                              ->where(function($q) use ($id,$user) {
                                  $q->whereIn('id',$id);
                                  $q->orWhere('employee_id_fk',$user->userAccessConnection->employee_id_fk);
                               })
                              ->where('approved_flag',0)
                              ->where('deleted_at',null)
                              ->orderBy('created_date', 'DESC');
       // if($searchKey) {
       // // $query->whereBetween('votes', [1, 100]);
       //   $query->where(function($q) use ($searchKey) {
       //       $q->where('days_amount', 'like', "%$searchKey%");
       //       $q->orWhere('reason', 'like', "%$searchKey%");
       //       $q->orWhereHas('policy', function($qw) use ($searchKey) {
       //           $qw->where('name', 'like', "%$searchKey%");
       //       });
       //       $q->orWhereHas('employee', function($qw) use ($searchKey) {
       //           $qw->where('first_name', 'like', "%$searchKey%");
       //           $qw->where('last_name', 'like', "%$searchKey%");
       //       });
       //   });
       // }
       $requestList = $query->get();
       $return = array();

       foreach ($requestList as $list){
         // $status = $list->getApprovementStatus();
         // if( $status=='pending') {
           //format date
           $list['start_date']=ServiceController::parseDate($list->start_date);
           $list['end_date']=ServiceController::parseDate($list->end_date);

           if ($list['half_day']==1) $list['amount'] = 'half day';

           else $list['amount'] = ServiceController::countDays($list['start_date'],$list['end_date'],1);
           $return[] = $list;
         // }
       }
       return $return;
     }

    /**
     * Get selected history detail
     */
    protected function getHistoryDetail($id=null){
      if ($id==null) return response()->json(['status'=>'failed']);
      $request = TimeOffTaken::with(['policy','employee'])->where('id',$id)->first();
      // set date format to  'Wednesday 21 May 1975'
      $request['date']=ServiceController::parseDate($request->date);
      $request['created_date']=ServiceController::parseDate($request->created_date);

      $request->getApproverName();
      return response()->json($request);
    }

    /**
     * Get selected request detail
     */
    protected function getRequestDetail($id=null){
      if ($id==null) return response()->json(['status'=>'failed']);
      $request = TimeOffRequest::with(['policy','employee'])->where('id',$id)->first();

      if ($request['half_day']==1) $request['amount'] = 'half day';
      else $request['amount'] = ServiceController::countDays($request['start_date'],$request['end_date'],1);

      $request['start_date']=ServiceController::parseDate($request->start_date);
      $request['end_date']=ServiceController::parseDate($request->end_date);
      $request['approver'] = $request->getPendingApproverName();
      //search approval list
      // $request['status'] = $request->Approvement();
      return response()->json($request);
    }
    protected function getRejectedList($searchKey=''){
     $user = Sentinel::getUser();
     $id = Approvement::where('box_type',2) // 2 = TIMEOFF
                      ->where('approved_flag',2) // 0 = PENDING
                      ->where('approved_by',$user->id)
                      ->get(['fk_ref'])->toArray();

     $query = TimeOffRequest::with(['policy','employee'])
                            ->where(function($q) use ($id,$user) {
                                $q->whereIn('id',$id);
                                $q->orWhere('employee_id_fk',$user->userAccessConnection->employee_id_fk);
                             })
                            ->where('approved_flag',2)
                            ->where('deleted_at',null)
                            ->orderBy('created_date', 'DESC');
     $rejectedList = $query->get();
     $return = array();

     foreach ($rejectedList as $list){
         $list['start_date']=ServiceController::parseDate($list->start_date);
         $list['end_date']=ServiceController::parseDate($list->end_date);

         if ($list['half_day']==1) $list['amount'] = 'half day';
         else $list['amount'] = ServiceController::countDays($list['start_date'],$list['end_date'],1);
         $list['rejected_reason'] = Approvement::where('fk_ref', $list->id)->first()->reason;
         $return[] = $list;
     }
     return $return;
   }
    /**
     * Show the form for creating a time off polices.
     *
     * @return \Illuminate\Http\Response
     */
    public function doCreate(CreateTimeOffPolicyRequest $request)
    {
      $model=new TimeoffPolicies;
       $inputs=$request->all();
        //  $inputs['assign_date']='1-31';
       if(isset($inputs['unlimited_flag'])) {
       //    //put default value to pass validate() function
       //    $inputs['balance']=0;
          // $inputs['unlimited_flag'] = 1;

       }
       else $inputs['unlimited_flag'] = 0;

       // if (!$model->validate($inputs)) {
       //   return response()->json($model->errors());
       // }
       $model->insertData($inputs);
       $model->save();
       //set approver
        $lists=explode(',',$request->approver_list);
         foreach($lists as $list){
           if($list != null){
             $approver = new ApproverList;
             $approver->policy_type = Constant::BOX_TYPE_TIMEOFF; // 2 for timeoff
             $approver->policy_id_fk = $model->id;
             $approver->approver_id_fk = $list;
             $approver->save();
           }
        }

       // === create time_off_assign for auto assign this timeOff policy each period ===
      //  if(isset($inputs['allEmployee'])) $inputs['employees'] = Employee::lists('id')->toArray();
       $today=Carbon::today();

       // if($inputs['unlimited_flag']==1){
       //   $assign_date=Carbon::minValue();
       //   $expired_date=Carbon::maxValue();
       // }else{ // unlimited_flag == 0
       //   $assign_date=Carbon::createFromFormat('Y-m-d',$inputs['assign_date']);
       //   $expired_date=$assign_date->copy()->addYear()->subDay(); // set expired date to 1 year after assign_date
       $assign_date=Carbon::now();
       $expired_date=$assign_date->copy()->addYear()->subDay(); // set expired date to 1 year after assign_date

        if(isset($inputs['employees'])){
          foreach ($inputs['employees'] as $employee) {
            $assign = new TimeOffAssign;
            $assign->policy_id_fk = $model->id;
            $assign->employee_id_fk = $employee;
            $assign->assign_date=$assign_date->day.'-'.$assign_date->month; // convert to dd-mm
            $assign->expired_date=$expired_date->day.'-'.$expired_date->month;
            $assign->save();

            if ($inputs['effective_date']<=$today){ // && $assign_date<=$today && $expired_date>=$today){
              $unlimited_flag=0;
              $amount=$model->balance;
              if($inputs['unlimited_flag']!=0){
                   $amount=0;
                   $unlimited_flag=1;
              }
              $quota = new TimeOffQuota;
              $quota->policy_id_fk = $model->id;
              $quota->employee_id_fk = $employee;
              $quota->amount = $amount;
              $quota->effective_date = $assign_date;
              $quota->expired_date = $expired_date;
              $quota->created_by = 0;
              $quota->unlimited_flag=$unlimited_flag;
              $quota->save();

            }
          }        
        }
      return response()->json(['status'=>'success','url'=>route('timeoff').'#policy']);
    }

    public function getPolicyDetail($id=null){
      if($id==null) return response()->json(['status'=>'failed']);
      $policy = TimeoffPolicies::withTrashed()->find($id);
      if($policy->deleted_at){
          $policy->deleted_at=ServiceController::parseDate($policy->deleted_at);
      }
      $policy->effective_date=ServiceController::parseDate($policy->effective_date);
      return $policy;
    }

    public function doDeletePolicy(Request $request){
      // delete timeOffAssign for this policy
      $assign = TimeOffAssign::where('policy_id_fk',$request['id'])->delete();
      // finally delete policy
      $policy = TimeoffPolicies::where('id',$request['id'])->delete();
      if( $policy ) return response()->json(['status'=>'success','url'=>route('timeoff')."#policy"]);
      else return response()->json(['status'=>'failed']);
    }

    /**
     * Request time-off from employee
     */
    public function doRequest(Request $request){
      // step
      // 1. create time off request
      // 2. create message to approvers
      // 3. send email to approvers
      $timeoff=new TimeOffRequest();
       $inputs=$request->all();
       // example
      //  $inputs['policy_id_fk']=3;
      //  $inputs['reason']='testing';
      //  $inputs['start_date']=Carbon::now();
      //  $inputs['end_date']=Carbon::now();

       $user = Sentinel::getUser(); // we will use Sentinel::getUser() many times

       // requester should be an employee, and should have an employee_id.
       // store this id in timeoff_request table
       $timeoff->employee_id_fk = $user->userAccessConnection->employee_id_fk;

       if (isset($inputs['half_day'])) $inputs['end_date'] = $inputs['start_date'];

       // validate and insert
       if (!$timeoff->validate($inputs)) {
         return response()->json($timeoff->errors());
       }

       //start_date must be more than or equal to effective_date
       if(TimeOffPolicies::find($inputs['policy_id_fk'])->effective_date > $inputs['start_date'])
           return response()->json(['start_date'=>['Start Date must be > effective_date']]);

       // start_date must be smaller than end_date
       $daysamount = ServiceController::countDays($inputs['start_date'],$inputs['end_date']);
       if ($daysamount<=0){
           return response()->json(['date'=>['End Date must be larger than Start Date.']]);
       }

        if(!TimeOffPolicies::find($inputs['policy_id_fk'])->unlimited_flag) {
        //validate days amount to balance i have
         $myBalance = TimeOffQuota::getMyBalancePerPolicy($user->userAccessConnection->employee_id_fk, $inputs['policy_id_fk']);
         if($daysamount > $myBalance) {
            return response()->json(['end_date'=>['Your balance is not enough']]);
         }
        }


       $timeoff->insertData($inputs);
       if($timeoff->save()){
         $data=[];
         $data['sender_email']=$user->email;
         $data['sender_name']=$user->name;
         $data['type']=Constant::BOX_TYPE_TIMEOFF;
         $data['reason']=$inputs['reason'];
         $data['fk_ref']=$timeoff->id;
         // request will be sent to receivers (super_admins) in the same company as requester
         $data['receivers']=User::where('company_id_fk',$user->company_id_fk)
                 ->join('role_users','user_access.id','=','role_users.user_id')
                 ->where('role_users.role_id',1)
                 ->get();
         $data['subject']='Time Off Request';

         //make approvement, message, and email request
         ApprovementController::createApprovalList($data);
         MessageController::createCustomMessage($data);
         $data['datedesc']=ServiceController::parseDate($timeoff->start_date).' - '.
                           ServiceController::parseDate($timeoff->end_date);
         $data['template_name']='emails.request-timeoff';
         $data['ess_type']='timeoff';
         MailService::emailRequestWithCode($data);
       }
       return response()->json(['status'=>'success','url'=>route('timeoff')]);
    }

    public function doReject(Request $request){
      $id = $request->input('id');
      $data['reason'] = $request->input('reason');
      $data['msg_model'] = Message::where('fk_ref',$id)->where('box_type',2)->first();
      $app = ApprovementController::rejectRequest($data);
      if ($app) return response()->json(['status'=>'rejected']);
      else return response()->json(['status'=>'unauthorized']);
    }

    public function doApprove(Request $request){
      $id = $request->input('id');
      $data['reason']=$request->input('reason');
      $data['msg_model'] = Message::where('fk_ref',$id)->where('box_type',2)->first();
      $app = ApprovementController::approveRequest($data);
      if ($app) return response()->json(['status'=>'approved']);
      else return response()->json(['status'=>'unauthorized']);
    }

    /**
     *  get employees' time off balance
     */
    public static function getTimeOffBalances ($policy_id = null){
    // protected function getTimeOffBalances(){
      $today = Carbon::today();

      if (isset($policy_id)==null ) {
        return response()->json(['status'=>'failed','message'=>'policy not found!']);;
      }
      $companyTable = Config::get('app.database_name_company'). Sentinel::getUser()->company_id_fk;
      // $lastAssignedQuota = TimeOffQuota::where('policy_id_fk',$policy_id)
      //                                  ->orderBy('created_date','DESC')->first();
      // 1. get TimeOffAssign
      // 2. get timeoff quota from table TimeOffAssign
      // 3. get timeoff taken
      $query=TimeOffAssign::where('policy_id_fk',$policy_id)

        ->join($companyTable.'.time_off_policies',$companyTable.'.time_off_policies.id','=',$companyTable.'.time_off_assign.policy_id_fk')
        ->join($companyTable.'.employee','employee.id','=',$companyTable.'.time_off_assign.employee_id_fk')
        // ->selectRaw("(SELECT FROM time_off_quota)")
        ->select(DB::raw('(SELECT amount FROM '.$companyTable.'.time_off_quota
          WHERE '.$companyTable.'.time_off_quota.employee_id_fk='.$companyTable.'.time_off_assign.employee_id_fk
          AND  '.$companyTable.'.time_off_quota.policy_id_fk='.$companyTable.'.time_off_policies.id
          ORDER BY '.$companyTable.'.time_off_quota.created_date DESC LIMIT 1) as quota,
          (SELECT unlimited_flag FROM '.$companyTable.'.time_off_quota
            WHERE '.$companyTable.'.time_off_quota.employee_id_fk='.$companyTable.'.time_off_assign.employee_id_fk
            AND  '.$companyTable.'.time_off_quota.policy_id_fk='.$companyTable.'.time_off_policies.id
            ORDER BY '.$companyTable.'.time_off_quota.created_by LIMIT 1) as flag
          ,employee.first_name,employee.last_name,employee.id as employee_id,employee.employee_id as employee_code,
          IFNULL((SELECT SUM(day_amount) FROM '.$companyTable.'.time_off_takens
            WHERE '.$companyTable.'.time_off_takens.employee_id_fk='.$companyTable.'.time_off_assign.employee_id_fk
            AND '.$companyTable.'.time_off_takens.policy_id_fk='.$companyTable.'.time_off_assign.policy_id_fk
            AND YEAR(date)
          ),0)
          as taken
          '))->get();


      return response()->json($query);
    }

    /**
     *  get list of employee who assigned to this policy
     *  fired when admin click "edit policy" icon
     *  @param int policy_id
     *  @return list of employees
     */
    protected function getTimeOffAssign($id){
      // return response()->json($id);
      $employees = TimeOffAssign::where('policy_id_fk',$id)->lists('employee_id_fk');
      $policy = TimeOffPolicies::find($id);
      if ($policy->default_flag==1) $default=true;
      else $default=false;
      return response()->json(['employees'=>$employees,'default'=>$default]);
    }
    /**
     *  change time off assign (adding or removing auto-assign)
     *  @param $request = list of employees
     */
    protected function editTimeOffAssign(Request $request){
      $inputs=$request->all();
      $lists=explode(',',$request->approver_list);
      $listDeleted = ApproverList::where('policy_type', Constant::BOX_TYPE_TIMEOFF)->where('policy_id_fk',$inputs['modalEP-id'])->whereNotIn('approver_id_fk',$lists)->get();
      foreach ($listDeleted as $deleteApprover) {
        $deleteApprover->delete();
      }
      foreach($lists as $list){
         if($list != null && ApproverList::where('approver_id_fk',$list)->where('policy_id_fk', $inputs['modalEP-id'])->get()->count() == 0){
           $approver = new ApproverList;
           $approver->policy_type = Constant::BOX_TYPE_TIMEOFF; // 2 for timeoff
           $approver->policy_id_fk = $inputs['modalEP-id'];
           $approver->approver_id_fk = $list;
           $approver->save();
         }
      }

      // get previous assignment for sample

      // $prevAssign=TimeOffAssign::where('policy_id_fk',$inputs['modalEP-id'])->first();
      // invalidate previous time_off_assign for this policy
      TimeOffAssign::where('policy_id_fk',$inputs['modalEP-id'])
          ->delete();

      
      // make new assignments
      if(isset($inputs['employees'])){
        $time_off_policies = TimeOffPolicies::find($inputs['modalEP-id']);
        $assign_date=Carbon::now();
        $expired_date=$assign_date->copy()->addYear()->subDay(); // set expired date to 1 year after
        foreach ($inputs['employees'] as $employee) {
          $oldAssign = TimeOffAssign::where('employee_id_fk', $employee)
                      ->where('policy_id_fk',$inputs['modalEP-id'])
                      ->get();
          $insertQuota = $oldAssign->count()==0 && $time_off_policies->effective_date <= Carbon::now();

          $assign = new TimeOffAssign;
          $assign->policy_id_fk = $inputs['modalEP-id'];
          $assign->employee_id_fk = $employee;
          $assign->assign_date='1-1';
          $assign->expired_date='31-12';
          $assign->save();

          if($insertQuota) {
            $quota = new TimeOffQuota;
            $quota->policy_id_fk = $inputs['modalEP-id'];
            $quota->employee_id_fk = $employee;
            $quota->amount = $time_off_policies->balance;
            $quota->effective_date = $assign_date;
            $quota->expired_date = $expired_date;
            $quota->created_by = 0;
            $quota->unlimited_flag=$time_off_policies->unlimited_flag;
            $quota->save();
          }


        }
      }

      if(isset($inputs['default_flag'])){
        TimeoffPolicies::find($inputs['modalEP-id'])->update(['default_flag'=>1]);
      }else{
        TimeoffPolicies::find($inputs['modalEP-id'])->update(['default_flag'=>0]);
      }
      return response()->json(['status'=>'success','url'=>route('timeoff').'#policy']);
    }

    /**
     *  manually assign time off quota
     *  fired by cron job at the beginning of each day
     *  useful for give bonus to or deplete current employee's timeoff quota
     */
    protected function editQuota(Request $request){
      $inputs=$request->all();
      $quota = new TimeOffQuota;
      //validate
      if (!$quota->validate($inputs)) {
        return response()->json($quota->errors());
      }
      // get timeoff assign
      $getTimeOffAssign=TimeOffAssign::where('policy_id_fk',$inputs['policy_id'])
        ->where('employee_id_fk',$inputs['employee_id'])
        ->orderBy('created_date','DESC')
        ->first();
      // $lastAssignedQuota = TimeOffQuota::where('policy_id_fk',$inputs['policy_id'])
      //                                  ->where('employee_id_fk',$inputs['employee_id'])
      //                                  ->orderBy('created_date','DESC')->first();
      // //dd($inputs['policy_id']. '---'. $inputs['employee_id']);
      // if(!$lastAssignedQuota){
      //   // if($lastAssignedQuota->expired_date == null) $exp_date = '2900-01-01';
      //   // else $exp_date = $lastAssignedQuota->expired_date;
      // // } else {
      //   // $lastAssignedQuota['effective_date'] = '0000-00-00';
      //   // $lastAssignedQuota['expired_date'] = '0000-00-00';
      //   return response()->json(['status'=>['message'=>'previous quota not found']]);
      // }
      // $sum = TimeOffTaken::where('policy_id_fk',$inputs['policy_id'])
      //                    ->where('employee_id_fk',$inputs['employee_id'])
      //                    ->where('time_off_takens.date', '>',$lastAssignedQuota['effective_date'])
      //                    ->where('time_off_takens.date', '<',$exp_date)
      //                    ->sum('day_amount');

      $quota->amount=$inputs['balance']; // + $sum;
      $quota->policy_id_fk = $inputs['policy_id'];
      $quota->employee_id_fk = $inputs['employee_id'];
      $assignDate=Carbon::createFromFormat('d-m-Y',$getTimeOffAssign->assign_date.'-'.date('Y'));
      $expiredDate=Carbon::createFromFormat('d-m-Y',$getTimeOffAssign->expired_date.'-'.date('Y'));
      $quota->effective_date = $assignDate;
      $quota->expired_date = $expiredDate;
      $quota->created_by = Sentinel::getUser()->id;
      $quota->save();
      return response()->json(['status'=>'success']);
    }

    /**
     *  auto assign time off quota
     *  fired by cron job at the beginning of each day
     *  according to records at TimeOffAssign
     *  and exclude quota that has already been assigned by admin
     */
    public static function autoAssignTimeOffQuota(){
      $today = Carbon::today();
      if (strlen($today->month)==2) $month = $today->month;
      else $month = '0'.$today->month;
      $assignments = TimeOffAssign::where('assign_date',$today->day.'-'.$month)->get();

      foreach($assignments as $assigntment){
          dd(TimeoffPolicies::find($assignment->policy_id_fk)->balance); //TODO ttes

          // assign
          $quota = new TimeOffQuota;
          $quota->policy_id_fk = $assignment->policy_id_fk;
          $quota->employee_id_fk = $assignment->employee_id_fk;
          $quota->effective_date = $today;
          $quota->expired_date = Carbon::createFromFormat('d-m-Y', $assignment->expired_date.'-'.$today->year);
          // $quota->amount = TimeoffPolicies::find($assignment->policy_id_fk)->balance; //TODO tes
          // $quota->amount = ( TimeoffPolicies::find($assignment->policy_id_fk) )->balance; //TODO tes
          $quota->created_by = 0; // flag for 'not created by user admin'
          $quota->save();
      }
    }

    // /**
    //  *  set new auto-assign, or modify existing auto-assign instance
    //  *  to automatically assign time offs at given date
    //  */
    // protected function setAutoAssign(Request $request){

    //   // validate TODO

    //   // check if this assignment is exist
    //   $assign = TimeOffAssign::find($request->id);
    //   if ($assign == null) $assign = new TimeOffAssign;

    //   // update/insert data
    //   $assign->insertData($request);

    //   return response()->json(['status'=>'success']);
    // }

    /**
     * get list of assignments
     */
    protected function getAssignmentList(){
      $assignments = TimeOffAssign::all();
      return response()->json($assignments);
    }
    /**
     *  get timeOffAssign detail when clicked
     */
    protected function getAssignmentDetail($id){
      // $assignment = TimeOffAssign::with(['employee,policy'])->find($id);
      $assignment = TimeOffAssign::find($id);
      $assignment->employee = $assignment->employee->first_name.' '.$assignment->employee->last_name;
      $assignment->policy = $assignment->policy->name;
      return response()->json($assignment);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function reportByEmployee()
    {
        return view('timeoff/report-by-employee');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function setting()
    {
        return view('timeoff/setting');
    }

    public function transaction(){
        return view('timeoff/transaction');
    }

    public function transactionDetail(){
        return view('timeoff/transaction-detail');
    }

}
