<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Sentinel;
use App\Models\UserAccessRole;
use App\Models\userAccessConnection;
use App\Models\JobPosition;
use App\Models\Department;
use App\Models\Company;
use App\Models\TaxPerson;
use App\Models\City;
use App\Models\User;
use App\Models\Province;
use App\Models\SentinelRole;
use App\Models\TimeOffPolicies;
use App\Models\ReimbursementPolicies;
use App\Models\Employee;
use App\Models\PayrollComponent;
use Carbon\Carbon;
use UserService;
use App\Models\ReimbursementAssign;
use App\Models\TimeOffAssign;
class UserServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
    public static function getUserEmployee(){
      $status=Sentinel::getUser()->userAccessConnection;
      if($status->employee_id_fk===NULL){
        return false;
      }
      return true;
    }
    public static function getDetailCompany(){
      return Sentinel::getUser()->userCompany;
    }
    public static function getDetailUserAccess(){
      return Sentinel::getUser()->getDetailUserAccess();
    }
    public static function getFullName(){
      return Sentinel::getUser()->getFullName();
    }
    public static function getListDepartment(){
      $list=[''=>'-Select-']+Department::lists('name','id')->all();
      return $list;
    }
    public static function getDepartmentById($id=NULL){
      $list=self::getListDepartment();
      if($id==NULL){
        return 'Not Set';
      }
      else if(isset($list[$id])){
        return $list[$id];
      }
    }
    public static function getListJobPosition(){
      $list=[''=>'-Select-'];

      return $list+JobPosition::lists('name','id')->all();
    }
    public static function getJobPositionById($id=NULL){
      $list=self::getListJobPosition();
      if($id==NULL){
        return 'Not Set';
      }
      else if(isset($list[$id])){
        return $list[$id];
      }

    }
    /**
     * [runPayrollStatus get status want to run payroll or not]
     * @return [type] [description]
     */
    public static function runPayrollStatus(){
      if(TaxPerson::first()){
        return true;
      }
      else{
        return false;
      }
    }
    /**
     * [getCity list city]
     * @param  [type] $name [description]
     * @return [type]       [description]
     */
    public static function getCity($name){
      $result=City::where('province',$name)->lists('name')->all();
      if($result){
        $list=[''=>'-Select-']+$result;
        return $list;
      }
      return ['status'=>'nodata'];
    }
    /**
     * [getProvince list provice]
     * @return [type] [description]
     */
    public static function getProvince(){
      $list=[''=>'-Select-']+Province::lists('name','id')->all();
      return $list;
    }
    /**
     * [getTimeOffPolicies list TimeoffPolicies]
     * @return [type] [description]
     */
    public static function getTimeOffPolicies($defaultValue='-Select-', $defaultKey=''){
      if(UserService::isSuperAdmin()) {
        $list=[$defaultKey=>$defaultValue]+TimeoffPolicies::where('effective_date','<=',Carbon::now())->lists('name','id')->all();
        return $list;
      }
      if (UserService::getUserEmployee() == true) {
        $availableReimbursement= TimeOffAssign::where('employee_id_fk', Sentinel::getUser()->userAccessConnection->employee_id_fk)
        ->get(['policy_id_fk'])->toArray();
          
        $list=[''=>'-Select-']+TimeOffPolicies::whereIn('id',$availableReimbursement)->where('effective_date','<=',Carbon::now())->lists('name','id')->all();
        return $list;
      }
    }
    /**
     * [getReimbursementPolicies list]
     * @return [type] [description]
     */
    public static function getReimbursement(){
      if(UserService::isSuperAdmin()) {
        $list=[''=>'-Select-']+ReimbursementPolicies::where('effective_date','<=',Carbon::now())->lists('name','id')->all();
        return $list;

      }
      if (UserService::getUserEmployee() == true) {
        $availableReimbursement= ReimbursementAssign::where('employee_id_fk', Sentinel::getUser()->userAccessConnection->employee_id_fk)
        ->get(['policy_id_fk'])->toArray();
          
        $list=[''=>'-Select-']+ReimbursementPolicies::whereIn('id',$availableReimbursement)->where('effective_date','<=',Carbon::now())->lists('name','id')->all();
        return $list;
      }
    }
    /**
     * [getData get data with company_id_fk]
     * @return [type] [description]
     */
   public static function getListRole(){
     return SentinelRole::where('company_id_fk',Sentinel::getUser()->company_id_fk)->orWhere('company_id_fk')->lists('name','id')->all();
   }
   public static function getUserIdHash($route=""){
    return sha1(Sentinel::getUser()->id.$route);
   }
   public static function convertToTree($type=NULL,$parent_id_fk=0){
     if($type){
       $list=[];
       if($type==='department'){
         $list=Department::where('parent_id_fk',$parent_id_fk)->orderBy('parent_id_fk')->get()->toArray();
       }
       else if($type=='job'){
         $list=JobPosition::where('parent_id_fk',$parent_id_fk)->orderBy('parent_id_fk')->get()->toArray();
       }
       $tempList=[];
       foreach($list as $data){
         $data['type']=$type;
         $data['children']=self::convertToTree($type,$data['id']);
         $tempList[]=$data;
       }
       return $tempList;
     }

     return 'Type not Choose';
   }
   public static function listEmployeeForm(){
    return Employee::all();
   }


   public static function userAccessList(){
    return userAccessConnection::where('company_id_fk',Sentinel::getUser()->company_id_fk)
                                  ->whereNotNull('user_access_id_fk')
                                  ->whereNotNull('employee_id_fk')
                                  ->get();
  }
   /**
   *  for lit component for add
   *
   */
   public static function listComponent($getDefaultComponent,$type=null){
      if($getDefaultComponent) $list=PayrollComponent::where('component_type',$type)->get();
      else $list=PayrollComponent::where('default_flag',0)->get();
      $result='';
      foreach($list as $row){

        $result.='<option value="'.$row->id.'" data-amount="'.$row->component_amount.'" data-type="'.$row->component_type.'">'.$row->component_name.'</option>';
      }
      return $result;
   }


   public static function isSuperAdmin(){
     return Sentinel::getUser()->getDetailUserAccess()['slug'] == "superadmin";
   }
   // public static function listOtherEmployeeForm(){
   //  $id = Sentinel::getUser()->userAccessConnection->employee_id_fk;
   //  if ($id == null) return Employee::all(); //dia bukan sebagai employee, get all
   //  else return Employee::where('id','!=',$id)->get(); //get semua employee selain dia
   // }
}
