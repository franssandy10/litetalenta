<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Sentinel;
use UserService;
use App\Models\Employee;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\TimeOffPolicies;
use App\Models\TimeOffRequest;
use App\Http\Requests\EmployeePayrollRequest;
use App\Http\Requests\EmployeePersonalRequest;
use App\Http\Requests\EmployeeCompanyRequest;
use App\Models\PayrollComponentEmployee;
class MyinfoController extends Controller
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
      if(Sentinel::getUser()->userAccessConnection->userEmployee){
        $model=Sentinel::getUser()->userAccessConnection->userEmployee;
        $listTimeOffRequest=TimeOffRequest::with('policy')->get();
        $statusPayroll=UserService::runPayrollStatus();
        $employeePayrollComponents=PayrollComponentEmployee::self()->get();
        return view('my-info/index',['model'=>$model,
        'type'=>'myinfo'
        ,'list_timeoff_request'=>$listTimeOffRequest
        ,'status_payroll'=>$statusPayroll
        ,'payroll_component'=>$employeePayrollComponents
        ,'employee_id_fk'=>Sentinel::getUser()->userAccessConnection->userEmployee->id]);
      }
      return redirect('dashboard');
      // $model=new Employee();
    }
    /**
     * [updateEmploymentData update employment data]
     * @param  Reequest $request [description]
     * @return [type]            [description]
     */
    protected function doUpdateEmploymentData(EmployeeCompanyRequest $request){
      $model=Sentinel::getUser()->userAccessConnection->userEmployee;
      $inputs=$request->all();
      $result=EmployeeController::updateEmploymentData($model,$inputs);
      return response()->json($result);
    }
    protected function doUpdatePersonalData(EmployeePersonalRequest $request){
      $model=Sentinel::getUser()->userAccessConnection->userEmployee;

      $inputs=$request->all();
      $result=EmployeeController::updatePersonalData($model,$inputs);

      return response()->json($result);
    }
    protected function doUpdatePayrollData(EmployeePayrollRequest $request){
      $model=Sentinel::getUser()->userAccessConnection->userEmployee;
      $inputs=$request->all();
      $result=EmployeeController::updatePayrollData($model,$inputs);

      return response()->json($result);
    }
}
