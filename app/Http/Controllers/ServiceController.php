<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Sentinel;
use MailService;
use UserService;
use App\Http\Requests;
use App\Models\Company;
use App\Models\UserAccessConnection;
use App\Http\Controllers\Controller;
use App\Http\Controllers\CalendarController;
use App\Models\TaxPerson;
use App\Models\Employee;
use App\Models\WorkingShift;
use App\Models\TimeOffTaken;
use App\Models\User;
use Activation;
use Hash;
use Config;
use Reminder;
use Illuminate\Support\Collection;
use Faker\Factory as Faker;
use Carbon\Carbon;
use App\Jobs\SendEmail;
use Mail;
use App\Models\PayrollComponent;
use App\Models\PayrollComponentEmployee;
class ServiceController extends Controller
{
  /**
   * Create a new authentication controller instance.
   *
   * @return void
   */
  public function __construct()
  {
      $arrayGuest=['login','index','testing', 'thanksApproval','forgotPassword','doForgotPassword', 'resetPassword','doResetPassword', 'errorPage', 'getDummyData'];
      $this->middleware('auth',['except'=>$arrayGuest]);
      $this->middleware('guest',['only'=>$arrayGuest]);

  }
    /**
     * For Testing Only
     *
     * @return \Illuminate\Http\Response
     */
    protected function testing()
    {
       dd(sentinel::getUser());
      // $list = PayrollComponent::where('component_type', 3)->get(['id'])->toArray();
      // dd(PayrollComponentEmployee::getDeductionEmployee(1, $list).'-----'.PayrollComponentEmployee::getAllowanceEmployee(1, $list));
    }
    /**
     * Display login page
     *
     * @return \Illuminate\Http\Response
     */
    protected function login()
    {

      return view('services/login');
    }
    /**
     * Display dashboard page
     *
     * @return \Illuminate\Http\Response
     */
    protected function dashboard()
    {
      // get Detail company
      $detailUserAccess=Sentinel::getUser()->getDetailUserAccess();
      $companyDetail=Sentinel::getUser()->userCompany;
      $whosOnLeave= CalendarController::getTimeoffList(7);
      return view('services/dashboard'
      ,['company_detail'=>$companyDetail
      ,'detail_user_access'=>$detailUserAccess
      ,'whos_on_leave'=>$whosOnLeave
      ]);
    }
    /**
     * Display Index page
     *
     * @return \Illuminate\Http\Response
     */
    protected function index()
    {
      if (Sentinel::getUser()) {
        return redirect()->route('dashboard');
      }
      return view('services/index');
    }
    /**
     * [changePassword for change password that only access by other function not request]
     * @param  array  $data
     * @return [type]       [description]
     */

    /**
     * Thanks Pages for approval
     * @param  array  $data
     * @return [type]       [description]
     */
    protected function thanksApproval(){
      return view('services/thanks-approval');
    }
    protected function forgotPassword(){
      return view('services/forgot-password');
    }
    protected function doForgotPassword(Request $request){

      $model=new User();
      $model->setRulesForgotPassword();

      if (!$model->validate($request->input())) {
        return response()->json($model->errors());
      }
      else{
        Reminder::removeExpired();
        $model = User::where('email', '=', $request->input('email'))->firstOrFail();
        $reminder=Reminder::create($model);
        // create string hash set on email
        $stringRandom=$reminder->code;
        $position=mt_rand(0,32);
        $firstString=substr($stringRandom,0,$position);
        $secondString=substr($stringRandom,$position);
        $hashString=$firstString.$model->id.$secondString.$position.strlen($position).strlen($model->id);
        $data=array();
        $data['code']=$hashString;
        $data['subject']='Forgot Password';
        $data['template_name']='emails.forgot-password';
        $data['user']=$model->toArray();
        MailService::emailWithCode($data);

        return response()->json(['status'=>'success','url'=>route('login')]);
      }
    }
    private function extractIdFromToken($id){
      // get digit of id dipaling belakang

      $getLengthId=substr($id,-1);
      // get digit of random string
      $getLength=substr($id,-2,-1);
      $getFirstHash=substr($id,0,-2);
      $getPosition=substr($getFirstHash,-$getLength);
      $getSecondHash=substr($getFirstHash,0,-$getLength);
      // get  string before id
      $firstString=substr($getSecondHash,0,$getPosition);
      // get  string after id
      $secondString=substr($getSecondHash,$getPosition+$getLengthId);
      // get id
      $getId=substr($getFirstHash,$getPosition,$getLengthId);
      // combine code
      $getCode=$firstString.$secondString;
      return ['id'=>$getId,'code'=>$getCode];
    }
    private function extractIdFromTokenInvitation($id){


      $lengthOfId=substr($id,-1);
      $lengthOfFirstLength=substr($id,-2,-1);
      $lengthOfSecondLength=substr($id,-3,-2);
      $secondLength=substr($id,-5,$lengthOfSecondLength);
      $firstLength=substr($id,-5-$lengthOfSecondLength,$lengthOfFirstLength);
      $firstString=substr($id,0,$firstLength);
      $userAccessId=substr($id,$firstLength,$lengthOfId);
      $secondString=substr($id,$firstLength+$lengthOfId,$secondLength);
      return ['id'=>$userAccessId,'code'=>$firstString,'codeActivation'=>$secondString];
    }
    protected function resetPassword($id){
      $result=$this->extractIdFromToken($id);
      if(strlen($id)>50){
        $result=$this->extractIdFromTokenInvitation($id);
      }
      if(intval($result['id'])!==0){
        $user = User::where('id', '=', $result['id'])->firstOrFail();
        if(Reminder::exists($user)){
          return view('services/reset-password',['id'=>$id]);

        }
      }
      return redirect()->route('login');
    }
    protected function doResetPassword(Request $request,$id){
      $model=new User();
      $model->setRulesResetPassword();

      if (!$model->validate($request->input())) {
        return response()->json($model->errors());
      }
      else{
        $result=$this->extractIdFromToken($id);
        if(strlen($id)>50){
          $result=$this->extractIdFromTokenInvitation($id);
          if(intval($result['id'])!==0){
            $user = User::where('id', '=', $result['id'])->firstOrFail();
            // exist jika ada yang belom complete
            if(Activation::exists($user)){
              $Activation = Activation::complete($user, $result['codeActivation']);

            }
          }
        }
        if(intval($result['id'])!==0){
          $user = User::where('id', '=', $result['id'])->firstOrFail();
          // exist jika ada yang belom complete
          if(Reminder::exists($user)){
            $reminder = Reminder::complete($user, $result['code'], $request->input('new_password'));
            if ($reminder)
            {
              return response()->json(['status'=>'success','url'=>route('login')]);

                // Reminder was successfull
            }
            else
            {
              return response()->json(['Token is wrong or not exists']);


                // Reminder not found or not completed.
            }
          }
          return response()->json(['Token already use, this page will redirect to forgot-password again']);
        }
      }
    }

    protected function errorPage($reason){
      return view('services/errors',['reason'=>$reason]);
    }
    /**
     * [getUserLoginJson get current user access]
     */
    public function getUserLoginJson(){
      return response()->json(['user'=>Sentinel::getUser()]);
    }

    /**
     * [sendInvitation to send invitation]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    protected function doSendInvitation(Request $request){
      $data=$request->input('employee');
      $employees=Employee::whereIn('id', $data)->get();
      $employeeEmail=[];
      foreach($employees as $employee){
        $employeeEmail[]=$employee->email;
      }
      // check email first
      $userAccess=User::whereIn('email',$employeeEmail)->get();
      $error=[];
      foreach($userAccess as $user){
          $error[]=[$user->email." is already have access from other company"];
      }
      if($userAccess->count()!=0){
        return response()->json($error);
      }
      foreach($employees as $employee){
        // create user access
        $result=Sentinel::register([
            'name' => $employee['first_name']." ".$employee['last_name'],
            'email' => $employee['email'],
            'company_id_fk'=>Sentinel::getUser()->company_id_fk,
            'last_login'=>Carbon::now(),
            'ip_address'=>$request->ip(),
            'password' =>'testing',
        ]);
        // create connection
        $model=UserAccessConnection::where('employee_id_fk',$employee->id)->where('company_id_fk',Sentinel::getUser()->company_id_fk)->first();
        $model->user_access_id_fk=$result->id;
        $model->save();
        $role = Sentinel::findRoleBySlug('employee');
        $role->users()->attach($result);
        $model = User::where('id', $result->id)->firstOrFail();
        // create reset password
        $reminder=Reminder::create($model);
        // create activate user
        $activation = Activation::create($model);
        // create hash code
        $firstString=$reminder->code;
        $secondString=$activation->code;
        $firstLength=strlen($firstString);
        $secondLength=strlen($secondString);
        $lengthOfFirstLength=strlen($firstLength);
        $lengthOfSecondLength=strlen($secondLength);
        $lengthOfId=strlen($model->id);
        // combine

        $hashString=$firstString.$model->id.$secondString.$firstLength.$secondLength.$lengthOfSecondLength.$lengthOfFirstLength.$lengthOfId;
        $data=array();
        $data['code']=$hashString;
        $data['subject']='Invitation Activate Account';
        $data['template_name']='emails.invitation';
        $model->userCompany;
        $model['admin']=Sentinel::getUser()->toArray();
        $data['user']=$model->toArray();
        // dd($data['user']);
        MailService::emailWithCode($data);
      }
      return response()->json(['status'=>'success','url'=>route('settinguseraccess')]);

    }
    protected function doRemoveAccess(Request $request){
      if($request->has('employee')){
        $userid=$request->input('employee');
        UserAccessConnection::where('user_access_id_fk',$userid)
          ->where('company_id_fk',Sentinel::getUser()->company_id_fk)
          ->update(['user_access_id_fk'=>NULL]);
        User::where('id',$userid)->delete();
      }
      return response()->json(['status'=>'success','url'=>route('settinguseraccess')]);
    }
    protected function doChangeAccess(Request $request){
      if($request->has('employee')&&$request->has('role')){
        $user=User::find($request->input('employee'));
        $role=Sentinel::findRoleById($user->getRoles()[0]->id);
        $role->users()->detach($user);
        $role=Sentinel::findRoleById($request->input('role'));
        $role->users()->attach($user);
      }
      return response()->json(['status'=>'success','url'=>route('settinguseraccess')]);
    }

    public static function parseDate($date,$format=0){
      $temp = Carbon::parse($date);
      if($format==0) return $temp->format('D, d F Y'); // Wednesday, 03 August 1975
      else return $temp->format('y-m-d');
      //)
      // return Carbon::parse($date)->formatLocalized('%A, %d %B %Y'); // Wednesday, 03 August 1975
    }

    public static function getDayOff() {
      $dayOff =  WorkingShift::take(7)
                            ->orderBy('updated_date','DESC')
                            ->get()
                            ->where('start_hour',0)
                            ->where('start_minute',0)
                            ->where('end_hour',0)
                            ->where('end_minute',0)
                            ->pluck('day')
                            ->toarray();
      if(count($dayOff)==0) $dayOff=['saturday','sunday'];

      return $dayOff;
    }
    public static function countDays($start_date,$end_date,$with_days_string=0){

      $dayOff = ServiceController::getDayOff();
      //dd($dayOff);
      $MyDateNow = Carbon::parse($start_date);
      $MyDateEnd = Carbon::parse($end_date);
      
      $amount=0;
      for($date=$MyDateNow;$date<=$MyDateEnd;$date=$date->addDay()) {
        if(!in_array(strtolower($date->format('l')),$dayOff)){
          $amount = $amount + 1;
        }
      }
      
      if($with_days_string==1){
        if ($amount>1) $amount = $amount.' work days';
                  else $amount = $amount.' work day';
      }
      return $amount;
    }

    public static function countDaysApproveByReuqestId($fk_ref){
      $count = TimeOffTaken::where('fk_ref',$fk_ref)->get()->count();
        return  $count.($count == 1 ?' work day': ' work days');
    }
}
