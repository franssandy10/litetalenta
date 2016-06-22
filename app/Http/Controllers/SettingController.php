<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use Sentinel;
use Hash;
use Storage;
use App\Models\Company;
use App\Models\TaxPerson;
use App\Models\EmailRecomendation;
use App\Models\UserAccess;
use App\Models\Employee;
use App\Models\UserAccessRole;
use App\Models\Department;
use App\Models\JobPosition;
use App\Models\WorkingShift;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ServiceController;
use App\Models\UserAccessConnection;
use App\Models\User;
use App\Models\PayrollCutoff;
use App\Models\PayrollComponent;

use UserService;
use Input;
use App\Jobs\SendEmail;
use BaseService;

class SettingController extends Controller
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
   * SETTING Personal
   *
   * @return \Illuminate\Http\Response
   */
  protected function personal()
  {
    $modelUser=Sentinel::getUser();
    // set rules first;

    return view('setting/personal',['model_user'=>$modelUser]);

  }
  protected function doChangePassword(Request $request){

    $modelUser=Sentinel::getUser();
    $modelUser->setRulesChangePassword();
    $inputs=$request->input();
    if (!$modelUser->validate($inputs)) {
      $result=$modelUser->errors();
    }
    if(empty($result)){
        $model=Sentinel::getUser();
        $model->password=Hash::make($inputs['new_password']);
        $model->save();
        return response()->json(['status'=>'success']);
    }
    else{

      return response()->json($result);

    }
  }

  protected function doValidateAvatar(Request $request){

    $modelUser=Sentinel::getUser();
    $modelUser->setRulesChangeAvatar();

    $inputs=$request->input();
    if (!$modelUser->validate($inputs)) {
      $result=$modelUser->errors();
    }
    if(empty($result)){
      return response()->json(['status'=>'success']);
    }
    else{
      return response()->json($result);

    }

  }
  /**
   * [doChangeAvatar change avatar]
   * @param  Request $request
   * @return [type]           [description]
   */
  protected function doChangeAvatar(Request $request){
    // get Input
    $inputs=$request->input();
    $data = explode(',', $request->image_data);
    $randomString = str_random(40);
    $fileName="avatar/".$randomString.'.jpg';
    $contentFile=base64_decode($data[1]);
    $storage = Storage::disk('s3')->getDriver()->put(
              $fileName,
              $contentFile,
              ['StorageClass' => 'REDUCED_REDUNDANCY']
          );
    Sentinel::getUser()->changeAvatar($fileName);
    // $modelUser->avatar=$fileName;
    // $modelUser->save();
    return response()->json(['status'=>'success']);
  }
  /**
   * [useraccess description]
   * @return [type] [description]
   */
  public function useraccess()
  {
    $model=new User();
    // inner join
    $list=UserAccessConnection::where('user_access_id_fk','!=','')
    ->where('user_access_id_fk','!=',Sentinel::getUser()->id)
    ->where('company_id_fk',Sentinel::getUser()->company_id_fk)->get();
    $listEmployee=UserAccessConnection::where('user_access_id_fk','=',NULL)->where('company_id_fk',Sentinel::getUser()->company_id_fk)->get();
    return view('setting/user',['list'=>$list,'employees'=>$listEmployee]);
  }
  public function recommendation()
  {
    return view('setting/recommendation');
  }
  //Sending Email Via Setting/Recomendation
  public function doSentMail(Request $request)
  {
    $validator = Validator::make($request->all(), [
            'name' => 'required|min:10',
            'email' => 'required|email',
    ]);
    if ($validator->fails()) {
      return response()->json($validator->messages());
    }
    else {
      $data = $request->input();
      $email = new EmailRecomendation();
      $email->name = $request->input('name');
      $email->email = $request->input('email');
      $email->user_id_fk = Sentinel::getUser()->id;
      // $this->dispatch((new SendEmail($data))->onQueue('emails'));
      $arrayData=[];
      $arrayData['subject']='Recomendation';
      $arrayData['template_name']='emails.recommendation';
      $arrayData['model']=$data;
      $this->dispatch((new SendEmail($arrayData))->onQueue('emails'));
      $email->save();
      return response()->json(['status'=>'success']);
    }
  }
  //end of Sending Email Via Setting/Recomendation
  public function sendEmailReminder(Request $request, $id)
  {

  }
  public function branch()
  {
    return view('setting/branch');
  }
  /**
   * [companyInfo get Data Company Information]
   * @return [view]
   */
  protected function companyInfo()
  {
    $companyDetail=Sentinel::getUser()->userCompany;
    $taxPerson=TaxPerson::first();
    // print_r($companyDetail);exit;
    // $jobs=JobPosition::all();
    $listJob=UserService::convertToTree('job');
    $listDepartment=UserService::convertToTree('department');

    // print_r($job)
    return view('setting/company-info'
      ,['company_detail'=>$companyDetail
        ,'tax_person'=>$taxPerson
        ,'jobs'=>$listJob
        ,'departments'=>$listDepartment]);
  }
  /**
   * [doUpdateCompanyDetail update company detail]
   * @param  Request $request
   * @return json status or error
   */
  protected function doUpdateCompanyDetail(Request $request){
      $modelCompany=Sentinel::getUser()->userCompany;
      $modelTaxPerson=TaxPerson::first();
      $inputs=$request->input();
      $errorCompany=[];
      $errorTaxPerson=[];
      // validate company
      if (!$modelCompany->validate($inputs)) {

        $result=$modelCompany->errors();
      }
      // validtae tax person
      // $result=array_merge($errorCompany, $errorTaxPerson);
      if(empty($result)){
          $modelCompany->update($inputs);
        return response()->json(['status'=>'success']);
      }
      else{

        return response()->json($result);

      }
  }
  /**
   * [doUpdateDepartment for add new department]
   * @param  Request $request [description]
   * @return [type]           [description]
   */
  protected function doAddDepartment(Request $request ){
    $inputs=$request->input();
    $model=new Department();
    if(!$model->validate($inputs)){
      $error=$model->errors();
    }
    if(empty($error)){
      $model->insertData($inputs);
      if($inputs['parent_id_fk']!=NULL){
        $modelStructure=new Department;
      }
      return response()->json(['status'=>'success', 'id' => $model->id]);

    }
    return response()->json($error);

  }
  /**
   * [doUpdateTextDepartment update text department]
   * @param  Request $request [description]
   * @param $request id,name
   * @return [Json]           [description]
   */
  protected function doUpdateTextDepartment(Request $request){
    $id=$request->input('id');
    $name=$request->input('name');
    $validator = Validator::make($request->all(), [
        'name' => 'unique:company.department,name,$id'

    ]);
    $validator->setAttributeNames((new Department())->getAttributeNames());
    if ($validator->fails()) {
      return response()->json(['status'=>$validator->messages()]);
    }
    else{
      $model=Department::find($id);
      $model->name=$name;
      $model->save();
      return response()->json(['status'=>'success']);
    }
  }
  /**
   * [doDeleteDepartment delete department]
   * @param  [type] $id [description]
   * @return [type]     [description]
   */
  protected function doDeleteDepartment(Request $request){
    // get parent of model
    $id = $request->input('id');
    $model= Department::find($id);
    $parent_id_fk=$model->parent_id_fk;
    // check there is child with nama parent_id_fk
    $list=Department::where('parent_id_fk',$id)->get();

    foreach($list as $data){
      $data->parent_id_fk=$parent_id_fk;
      $data->save();
    }
    $model->delete();
    return response()->json(['status'=>'success']);
  }
   /**
   * [doDeleteJobPosition For delete job position]
   * @param  [type] $id [description]
   * @return [type]     [description]
   */
  protected function doUpdateDepartment(Request $request){
    // get parent of model
    $id = $request->input('id');
    $parent_id_fk = $request->input('parent_id_fk');
    $model= Department::find($id);
    $model->parent_id_fk=$parent_id_fk;
    $model->save();

    return response()->json(['status'=>'success']);
  }
  /**
   * [doUpdateJobPosition For add new JobPosition]
   * @param  Request $request [description]
   * @return [type]           [description]
   */
  protected function doAddJobPosition(Request $request ){
    $inputs=$request->input();
    $model=new JobPosition();
    if(!$model->validate($inputs)){
      $error=$model->errors();
    }
    if(empty($error)){
      $model->insertData($inputs);
      return response()->json(['status'=>'success', 'id' => $model->id]);
    }
    return response()->json($error);

  }
  /**
   * [doDeleteJobPosition For delete job position]
   * @param  [type] $id [description]
   * @return [type]     [description]
   */
  protected function doDeleteJobPosition(Request $request){
    // get parent of model
    $id = $request->input('id');
    $model= JobPosition::find($id);
    $parent_id_fk=$model->parent_id_fk;
    // check there is child with nama parent_id_fk
    $list=JobPosition::where('parent_id_fk',$id)->get();

    foreach($list as $data){
      $data->parent_id_fk=$parent_id_fk;
      $data->save();
    }
    $model->delete();
    return response()->json(['status'=>'success']);
  }
  /**
   * [doUpdateTextDepartment update text department]
   * @param  Request $request [description]
   * @param $request id,name
   * @return [Json]           [description]
   */
  protected function doUpdateTextJobPosition(Request $request){
    $id=$request->input('id');
    $name=$request->input('name');
    $validator = Validator::make($request->all(), [
        'name' => 'unique:company.job_position,name,'.$id

    ]);
    $validator->setAttributeNames((new JobPosition)->getAttributeNames());
    if ($validator->fails()) {
      return response()->json($validator->messages());
    }
    else{
      $model=JobPosition::find($id);
      $model->name=$name;
      $model->save();
      return response()->json(['status'=>'success']);
    }
  }
   /**
   * [doDeleteJobPosition For delete job position]
   * @param  [type] $id [description]
   * @return [type]     [description]
   */
  protected function doUpdateJobPosition(Request $request){
    // get parent of model
    $id = $request->input('id');
    $parent_id_fk = $request->input('parent_id_fk');
    $model= JobPosition::find($id);
    $model->parent_id_fk=$parent_id_fk;
    $model->save();

    return response()->json(['status'=>'success']);
  }

  public function companyConfig()
  {
    // get working shift
    $workingShift = WorkingShift::where('start_hour','!=',0)
                         ->orWhere('start_minute','!=',0)
                         ->orWhere('end_hour','!=',0)
                         ->orWhere('end_minute','!=',0)
                         ->orderBy('updated_date','DESC')
                         ->first(); // only get the first (latest) data, because data for another day will be same
    if($workingShift) {
        // $workingShift->toArray();
        if (strlen($workingShift['start_hour']  )==1) $workingShift['start_hour'] = '0'.$workingShift['start_hour'];
        if (strlen($workingShift['start_minute'])==1) $workingShift['start_minute'] = '0'.$workingShift['start_minute'];
        if (strlen($workingShift['end_hour']    )==1) $workingShift['end_hour'] = '0'.$workingShift['end_hour'];
        if (strlen($workingShift['end_minute']  )==1) $workingShift['end_minute'] = '0'.$workingShift['end_minute'];
    }
    else{ //set to 09:00 - 17:00
      $workingShift = array(
        'start_hour' => '09',
        'start_minute' => '00',
        'end_hour' => '17',
        'end_minute' => '00',
      );
    }
    // get day off(s)
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

    // flag for workingdays checkbox (checked/unchecked)
    $workingDayFlag=array();

    // set all day as workingDay
    foreach ( array_keys(BaseService::getDay()) as $value) $workingDayFlag[$value]=true;

    // set flag for each dayOff
    foreach ($dayOff as $value) $workingDayFlag[$value]=false;

    return view('setting/company-config',['workingShift'=>$workingShift,'workingDayFlag'=>$workingDayFlag]);
  }

  public function payrollConfig()
  {
     $taxPerson=TaxPerson::first();
    $payrollCutoff=PayrollCutoff::first();
    if(!$payrollCutoff){

      $payrollCutoff=new PayrollCutoff;
      $payrollCutoff->payroll_schedule=25;
      $payrollCutoff->payroll_from=1;
      $payrollCutoff->payroll_to=31;
      $payrollCutoff->attendance_from=1;
      $payrollCutoff->attendance_to=31;
    }
    $componentAllowance=PayrollComponent::where('component_type',1)->get();
    $componentDeduction=PayrollComponent::where('component_type',2)->get();


    return view('setting/payroll-config',['tax_person'=>$taxPerson
      ,'payroll_cutoff'=>$payrollCutoff
      ,'component_allowance'=>$componentAllowance
      ,'component_deduction'=>$componentDeduction]);
  }
  public function essConfig()
  {
    return view('setting/ess-config');
  }

  /**
  * Change personal-ESS setting (with checkboxes)
  * @param $request = which checkbox are changed
  * @return return back array of changed data
  */
  protected function doPersonalESS(Request $request){
    $user = User::find(Sentinel::getUser()->id);
    $change = $request->all();
    $change_keys = array_keys($change);
    $arr = json_decode($user->ess_email,true); //json={timeoff: 1, reimbursement: 1} etc
    for($i=0;$i<count($change);$i++){
      $k = $change_keys[$i];
      $arr[$k]=$change[$k];
    }
    \DB::table('user_access')
            ->where('id', Sentinel::getUser()->id)
            ->update(['ess_email' => json_encode($arr)]);
    return \Response::json(['status'=>'success']);
  }

  /**
   * Set working shift for this company
   */
  protected function doUpdateWorkingShift(Request $request){
    $inputs = $request->all();
    $model = new WorkingShift;


    if (!$model->validate($inputs)) {
      return response()->json($model->errors());
    }

    $weekdays = array_keys(BaseService::getDay());
    // loop 7 times, input value for all weekdays
    for ($i=0; $i<7;$i++){
      $model = new WorkingShift;
      $model->day = $weekdays[$i];

      // search if corresponding weekday is a day off
      //use === to prevent 0 being treated as false
      if( array_search($weekdays[$i], $inputs['working_days']) === false ) {
        $model->start_hour = 0;
        $model->start_minute = 0;
        $model->end_hour = 0;
        $model->end_minute = 0;
      }
      else {
        $model->insertData($inputs); // input time according to inputs
      }
      $model->save();
    }
    return response()->json(['status'=>'success']);
  }
}
