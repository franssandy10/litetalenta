<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Sentinel;
use App\User;
use Validator;
use Redis;
use BaseService;
use UserService;
use App\Models\Companie;
use App\Models\Employee;
use App\Http\Controllers\Controller;
use App\Models\TaxPerson;
use App\Models\EmployeeSalaryHistory;
use Carbon\Carbon;
use App\Models\UserAccessConnection;
use App\Models\TimeOffRequest;
use App\Models\TimeOffPolicies;
use App\Models\TimeOffAssign;
use App\Models\TimeOffQuota;
use App\Models\Department;
use App\Models\JobPosition;
use App\Models\WorkingShift;
use App\Http\Requests\EmployeePersonalRequest;
use App\Http\Requests\EmployeeCompanyRequest;
use App\Http\Requests\EmployeePayrollRequest;
use App\Models\PayrollComponent;
use App\Models\PayrollComponentEmployee;
use App\Models\ReimbursementPolicies;
use App\Models\ReimbursementAssign;
use App\Models\ReimbursementQuota;

class EmployeeController extends Controller
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
    public function employeeList()
    {
      // get id companies;
      // print_r(Auth::user()->company_id_fk);exit;
      // get companies
      // Companies::where('id',Auth::user()->company_id_fk)->get()
      // get employee
      $model= new Employee();
      $employeeList=$model->getDataTable();

      $workingShifts = WorkingShift::take(7)
                          ->orderBy('updated_date','DESC')
                          ->get()
                          ->toarray();

      return view('employee/index',['employee_list'=>$employeeList,'working_shifts'=>$workingShifts]);

    }
    /**
     * Get List Employee
     *
     * @return \Illuminate\Http\Response In Json Format
     */
    public function getData(){
      return response()->json(['employees'=>Employees::all(),'status'=>'success']);
    }
    /**
     * Validate Personal Step Employee Create
     *
     * @return \Illuminate\Http\Response In Json Format
     */
    public function validatePersonal(EmployeePersonalRequest $request){
      $model=new Employee();
      $request->session()->put('personal',$request->all());
      return response()->json(['status'=>'success']);
    }

    /**
     * Validate Company Detail Step Employee Create
     *
     * @return \Illuminate\Http\Response In Json Format
     */
    public function validateCompanyDetail(EmployeeCompanyRequest $request){

      $model=new Employee();
      $request->session()->put('companydetail',$request->all());
      if(!TaxPerson::first()){
        $this->doCreateEmployee();
      }
      return response()->json(['status'=>'success']);

    }

    /**
     * Validate Company Detail Step Employee Create
     *
     * @return \Illuminate\Http\Response In Json Format
     */
    public function validatePayrollDetail(EmployeePayrollRequest $request){
      $model=new Employee();
      $request->session()->put('payrolldetail',$request->all());
      $this->doCreateEmployee();
      return response()->json(['status'=>'success']);
    }

    /**
     * Create Employee
     *
     * @return \Illuminate\Http\Response In Json Format
     */
    protected function doCreateEmployee(){
      $personal=session('personal');
      $companyDetail=session('companydetail');
      $payrollDetail=[];

      if(TaxPerson::first()){
        $payrollDetail=session('payrolldetail');
      }

      $result=array_merge($personal,$companyDetail,$payrollDetail);

      $result=BaseService::setNullArray($result);
      $model=new Employee();
      $model->setRules();
      $model->insertData($result);
      if(TaxPerson::first()){
        $modelSalary=new EmployeeSalaryHistory();
        $modelSalary->employee_id_fk=$model->id;
        $modelSalary->new_salary=$result['salary'];
        $modelSalary->effective_date=Carbon::now();
        $modelSalary->save();
        if(isset($payrollDetail['component_ids'])){
          foreach($payrollDetail['component_ids'] as $key=> $value){
            $employeeComponent=new PayrollComponentEmployee;
            $employeeComponent->employee_id_fk=$model->id;
            $employeeComponent->component_id_fk=$value;
            $employeeComponent->component_amount=$payrollDetail['component_amounts'][$key];
            $employeeComponent->save();
          }
        }
      }

      // set user access connection with employee

      $modelConnection=new UserAccessConnection();
      if(isset($result['first_register'])){
        if($result['first_register']==='yes'){
          $modelConnection=$modelConnection::where('user_access_id_fk',Sentinel::getUser()->id)->where('company_id_fk',sentinel::getUser()->company_id_fk)->first();
        }
      }
      $modelConnection->company_id_fk=Sentinel::getUser()->company_id_fk;
      $modelConnection->employee_id_fk=$model->id;
      $modelConnection->save();

      $today=Carbon::today();

      // set default time off for new employee
      $defaultPoliciesTimeOff = TimeOffPolicies::where('default_flag',1)->get();


      foreach ($defaultPoliciesTimeOff as $policy) {

          $assignSample = TimeOffAssign::where('policy_id_fk',$policy->id)->first();
          if (!$assignSample){
              $assignSample['assign_date'] = '01-01';
              $assignSample['expired_date'] = '31-12';
          }
          // $assign_date=Carbon::createFromFormat('d-m-Y',$assignSample['assign_date'].'-'.$today->year);
          // $expired_date=Carbon::createFromFormat('d-m-Y',$assignSample['expired_date'].'-'.$today->year);

          $assign = new TimeOffAssign;
          $assign->policy_id_fk = $policy->id;
          $assign->employee_id_fk = $model->id;
          $assign->assign_date=$assignSample['assign_date'];
          $assign->expired_date=$assignSample['expired_date'];
          $assign->save();

        if ($policy->unlimited_flag==0 && $policy->effective_date<=$today){ // && $assign_date<=$today && $expired_date>=$today){
          $quota = new TimeOffQuota;
          $quota->policy_id_fk = $policy->id;
          $quota->employee_id_fk = $model->id;
          $quota->amount = $policy->balance;
          $quota->effective_date = $assignSample['assign_date'].'-'.$today->year;
          $quota->expired_date = $assignSample['expired_date'].'-'.$today->year;
          $quota->created_by = 0;
          $quota->save();
        }
      }

      // set default reimbursement for new employee
      $defaultPoliciesReimbursement = ReimbursementPolicies::where('default_flag',1)->get();

      foreach ($defaultPoliciesReimbursement as $policy) {

          $assignSample = ReimbursementAssign::where('policy_id_fk',$policy->id)->first();
          if (!$assignSample){
              $assignSample['assign_date'] = '01-01';
              $assignSample['expired_date'] = '31-12';
          }
          // $assign_date=Carbon::createFromFormat('d-m-Y',$assignSample['assign_date'].'-'.$today->year);
          // $expired_date=Carbon::createFromFormat('d-m-Y',$assignSample['expired_date'].'-'.$today->year);

          $assign = new ReimbursementAssign;
          $assign->policy_id_fk = $policy->id;
          $assign->employee_id_fk = $model->id;
          $assign->assign_date=$assignSample['assign_date'];
          $assign->expired_date=$assignSample['expired_date'];
          $assign->save();

        if ($policy->unlimited_flag==0 && $policy->effective_date<=$today){ // && $assign_date<=$today && $expired_date>=$today){
          $quota = new ReimbursementQuota;
          $quota->policy_id_fk = $policy->id;
          $quota->employee_id_fk = $model->id;
          $quota->amount = $policy->limit;
          $quota->effective_date = $assignSample['assign_date'].'-'.$today->year;
          $quota->expired_date = $assignSample['expired_date'].'-'.$today->year;
          $quota->created_by = 0;
          $quota->save();
        }
      }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //print_r(date('Y-m-d',strtotime(date('Y-m-d') . "+1 days")));


        //print_r(Employee::find(6)->getCurrentSalary()->new_salary);exit;
        // print_r(Auth::user()->getDetailCompany()->getDepartment());exit;\
        $companyDetail=Sentinel::getUser()->userCompany;
        $statusPayroll=UserService::runPayrollStatus();
        return view('employee/add'
          ,['company_detail'=>$companyDetail
          ,'status_payroll'=>$statusPayroll
          ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Schedule List for All Employee.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function schedule()
    {
      return view('employee/schedule');
    }

    /**
     * Schedule List for Single Employee.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function detailSchedule()
    {
      return view('employee/detail-schedule');
    }

      public static function updateEmploymentData($model,$inputs){
      // $model->setRules(2);
      // set employment_status
      if($inputs['employment_status']==1){
        $inputs['end_contract_date']=NULL;
        $inputs['end_probation_date']=NULL;
      }
      else if($inputs['employment_status']==2){
        $inputs['end_probation_date']=NULL;
      }
      else if($inputs['employment_status']==3){
        $inputs['end_contract_date']=NULL;
      }
      $model->fill($inputs)->save();
      return ['status'=>'success'];
    }
    public static function updatePersonalData($model,$inputs){
      $model->fill($inputs)->save();
      return ['status'=>'success'];

    }
    public static function updatePayrollData($model,$inputs){
      $model->fill($inputs)->save();
      if(isset($inputs['component_ids'])){
        foreach($inputs['component_ids'] as $key=> $value){
          // find component_id
          $employeeComponent=PayrollComponentEmployee::where('component_id_fk',$value)->first();
          if(!$employeeComponent){
            $employeeComponent=new PayrollComponentEmployee;
          }
          $employeeComponent->employee_id_fk=$model->id;
          $employeeComponent->component_id_fk=$value;
          $employeeComponent->component_amount=$inputs['component_amounts'][$key];
          $employeeComponent->save();
        }
      }
      if($inputs['component_id_delete']!==''){
        $temp=explode(',',$inputs['component_id_delete']);
        PayrollComponentEmployee::destroy($temp);
      }
      return ['status'=>'success'];
    }
    /**
     * Display edit employee.
     *
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {

      $model=Employee::find($id);
      $listTimeOffRequest=TimeOffRequest::all();
      $statusPayroll=UserService::runPayrollStatus();
      $payrollComponent=PayrollComponentEmployee::where('employee_id_fk',$id)->get();
      return view('employee/info',['model'=>$model
      ,'type'=>'employee'
      ,'employee_id_fk'=>$id
      ,'status_payroll'=>$statusPayroll
      ,'list_timeoff_request'=>$listTimeOffRequest
      ,'payroll_component'=>$payrollComponent]);

      // $model=new Employee();
    }
    /**
     * [updateEmploymentData update employment data]
     * @param  Reequest $request [description]
     * @return [type]            [description]
     */
    protected function doUpdateEmploymentData(EmployeeCompanyRequest $request,$id){
      $model=Employee::find($id);
      $inputs=$request->all();
      $result=$this->updateEmploymentData($model,$inputs);
      return response()->json($result);
    }
    protected function doUpdatePersonalData(EmployeePersonalRequest $request,$id){
      $model=Employee::find($id);
      $inputs=$request->all();
      $result=$this->updatePersonalData($model,$inputs);

      return response()->json($result);
    }
    protected function doUpdatePayrollData(EmployeePayrollRequest $request,$id){
      $model=Employee::find($id);
      $inputs=$request->all();
      $result=EmployeeController::updatePayrollData($model,$inputs);

      return response()->json($result);
    }
    protected function doInsertStructure(Request $request){
      $inputs=$request->all();
      $model=NULL;
      // check type first exist or not
      if(isset($inputs['type'])){
        if($inputs['type']=='add_department'){
          $model=new Department();
          $model->name=$inputs['new_data'];
          $model->save();
        }
        else if($inputs['type']=='add_job'){
          $model=new JobPosition();
          $model->name=$inputs['new_data'];
          $model->save();
        }
      }
      return response()->json($model->id);
    }
}
