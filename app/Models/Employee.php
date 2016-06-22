<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Config;
use Carbon\Carbon;
use App\Models\CustomModelCompany;
use Sentinel;
class Employee extends CustomModelCompany
{
  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'employee';
  public function employeeDepartment(){
    return $this->belongsTo('App\Models\Department','department_id_fk','id');
  }
  public function employeeJobPosition(){
    return $this->belongsTo('App\Models\JobPosition','job_position_id_fk','id');
  }
  public function employeeSalaryHistory(){
    return $this->hasMany('App\Models\EmployeeSalaryHistory','employee_id_fk','id');
  }
  public function lastEmployeeSalaryHistory(){
    return $this->employeeSalaryHistory()->orderBy('id','desc')->first();
  }
  public function getCurrentSalary(){
    return $this->employeeSalaryHistory()->where('effective_date','<=',Carbon::now()->toDateString())->orderBy('created_date','desc')->first();
  }
  public function employeePayroll(){
    return $this->hasMany('App\Models\EmployeePayroll','employee_id_fk','id');
  }
  public function employeeAttendance(){
    return $this->hasMany('App\Models\Attendance','employee_id_fk','id');
  }
  public function employeeTimeOffTaken(){
    return $this->hasMany('App\Models\TimeOffTaken','employee_id_fk','id');
  }
  public function latestEmployeePayroll(){
    return $this->employeePayroll()->orderBy('id','desc')->first();
  }
  /**
   * get relationship employee data
   * @return object employee
   */
  protected function userAccessConnection(){
    return $this->belongsTo('App\Models\UserAccessConnection','id','employee_id_fk')->where('company_id_fk',sentinel::getUser()->company_id_fk);
  }

  protected $rules=[
    'employee_id' => 'required|max:255',
    'email'=>'required|email|max:255',
    'first_name'=>'required|max:255',
    'last_name'=>'required|max:255',
    'identity_type'=>'required',
    'identity_number'=>'required|max:30',
    'identity_expired_date'=>'required|date',
    'address'=>'string',
    'postal_code'=>'numeric',
    'place_of_birth'=>'string',
    'date_of_birth'=>'date',
    'mobile_phone'=>'numeric',
    'phone'=>'numeric',
    'gender'=>'required',
    'marital_status'=>'required',
    'blood_type'=>'required',
    'religion'=>'required',
    'salary'=>'required|numeric',
    'npwp_number'=>'required|max:255',
    'bank_account'=>'required_unless:bank_id_fk,|numeric',
    'bank_holder'=>'required_unless:bank_id_fk,|string',
    'bpjstk_number'=>'numeric',
    'bpjsk_number'=>'numeric',
    'employment_status'=>'required|max:255',
    'join_date'=>'required|max:255',
    'end_contract_date'=>'required_if:employment_status,2',
    'end_probation_date'=>'required_if:employment_status,3'];
  private $rulesCompany=[

  ];
  private $rulesPayroll=[

  ];
  private $rulesPayrollEdit=[
    'npwp_number'=>'required|max:255',
    'bank_account'=>'required_unless:bank_id_fk,|numeric',
    'bank_holder'=>'required_unless:bank_id_fk,|alpha',
    'bpjstk_number'=>'numeric',
    'bpjsk_number'=>'numeric',
  ];
  protected $attributeNames=[
    'employee_id' => 'Employee ID',
    'email'=>'Email',
    'first_name'=>'First Name',
    'last_name'=>'Last Name',
    'identity_type'=>'Identity Type',
    'identity_number'=>'Identity Number',
    'identity_expired_date'=>'Identity Expired Date',
    'address'=>'Address',
    'postal_code'=>'Postal Code',
    'place_of_birth'=>'Place of Birth',
    'date_of_birth'=>'Date of Birth',
    'mobile_phone'=>'Mobile Phone',
    'phone'=>'Phone',
    'gender'=>'Gender',
    'marital_status'=>'Marital Status',
    'blood_type'=>'Blood Type',
    'religion'=>'Religion',
    'employment_status'=>'Employment Status',
    'join_date'=>'Join Date',
    'end_contract_date'=>'End Contract Date',
    'end_probation_date'=>'End Probation Date',
    'salary'=>'Salary',
    'npwp_number'=>'NPWP',
    'bank_account'=>'Bank Account',
    'bank_holder'=>'Bank Holder',
    'bpjstk_number'=>'BPJSTK Number',
    'bpjsk_number'=>'BPJSK Number',
  ];
  protected $messages=[
    'bank_account.required_unless'=>'The bank account is Required',
    'bank_holder.required_unless'=>'The bank holder is Required',
    'end_contract_date.required_if'=>'The end contract date is Required',
    'end_probation_date.required_if'=>'The end probation date is Required'];
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = ['first_name', 'last_name','employee_id'
                ,'identity_type','email'
                ,'identity_number','identity_expired_date','postal_code'
                ,'address','city','place_of_birth','date_of_birth','mobile_phone'
                ,'gender','marital_status','blood_type','religion'
                ,'department_id_fk','job_position_id_fk','employment_status'
                ,'join_date','end_probation_date','end_contract_date','npwp_number','npwp_date'
                ,'tax_status','bank_id','bank_account','bank_holder'
                ,'bpjstk_number','bpjstk_number','tax_config','salary_config'
                ,'salary_type','company_paid','employment_tax_status'];

  /**
   * [setRules set rules base on type rules : 1.personal,2.company,3.payroll]
   * @param [type] $type [base on type in form]
   */
  public function setRules($type=NULL){
    if($type==1){
      $this->rules=$this->rulesPersonal;
    }
    else if($type==2){
      $this->rules=$this->rulesCompany;
    }
    else if($type==3){
      $this->rules=$this->rulesPayroll;
    }
    else if($type==4){
      $this->rules=$this->rulesPayrollEdit;

    }
    else{
    }
  }
}
