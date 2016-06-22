<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Datatables;
use Illuminate\Support\Collection;
use Sentinel;
use Carbon\Carbon;
use App\Models\EmployeeSalaryHistory;
use App\Models\PayrollComponentEmployee;
use BaseService;
class PayrollSystemController extends Controller
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
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
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

    public function importPayroll()
    {
        return view('payroll/system/import-payroll');
    }
    public function callDataPayroll(){
      $job = (new \App\Jobs\PayrollDataQueue());
      $this->dispatch($job);
    }
    public function runPayroll(Request $request)
    {
      // $this->dispatch((new SendEmail($data))->onQueue('emails'));


      if (!$request->session()->has('payrolldate')) {
          return redirect()->route('payrollindex');
      }
      $inputs=$request->session()->get('payrolldate');
      $request->session()->forget('payroll_component');
      return view('payroll/system/run-payroll'
        ,['generalHeaderTitle1'=>'Payroll'
        ,'year'=>$inputs['year']
        ,'month'=>BaseService::getNameMonth($inputs['month'])
        ,'generalHeaderTitle2'=>Sentinel::getUser()->userCompany->name]);
    }
    public function doGetPayrollDetail(Request $request,$id){
      // get employee component payroll
      // 1.get salary

      $list=array();
      $dataSalary=EmployeeSalaryHistory::where('employee_id_fk',$id)
        ->where('effective_date','<',Carbon::now())
        ->orderBy('effective_date','DESC')->first();
      $list[]=['item'=>'Basic Salary'
      ,'type'=>'salary'
      ,'once'=>'no'
      ,'amount'=>$dataSalary['new_salary']];

      $list[]=['item'=>'Monthly Allowance'
        ,'type'=>'allowance'
        ,'once'=>'no'
        ,'amount'=>PayrollComponentEmployee::getAllowanceEmployee($id)];
      $list[]=['item'=>'Monthly Deduction'
        ,'type'=>'deduction'
        ,'once'=>'no'
        ,'amount'=>PayrollComponentEmployee::getDeductionEmployee($id)];


      $length=0;
      $session=$request->session()->get('payroll_component.'.$id);
      if(sizeof($session)){
        
        $length=sizeof($session['payroll_name']);
      }

      // print_r($session);exit;
      // foreach($inputs['payroll_name'] as)
      // 2.get allowance once
      for($i=0;$i<$length;$i++){
        $list[]=['item'=>$session['payroll_name'][$i]
        ,'type'=>$session['payroll_type'][$i]
        ,'once'=>'yes'
        ,'amount'=>$session['payroll_amount'][$i]];
      }
      // 3.get deduction once
      return response()->json($list);
    }
    public function doSubmitEditPayroll(Request $request){
      $inputs=$request->all();
      //dd($inputs);
      $id=$inputs['employee_id'];
      $request->session()->forget('payroll_component.'.$id);
      //dd($request->session()->get('payroll_component.'.$id));
      unset($inputs['_token']);
      unset($inputs['employee_id']);
      $request->session()->put('payroll_component.'.$id,$inputs);


      // return response()->json($inputs);

      return response()->json(['status'=>'success']);
    }
    public function doSetComponent(Request $request){

    }
    public function processPayroll()
    {
      // $this->dispatch((new SendEmail($data))->onQueue('emails'));
      $job = (new \App\Jobs\ProcessPayrollQueue());
      $this->dispatch($job);

        // return view('payroll/system/run-payroll');
    }
    /**
     * [getDummyData get current user access]
     */
    public function getDummyData(){
      $users = new Collection;
      $allowance = new Collection;
      $deduction = new Collection;

      $faker = \Faker\Factory::create();

      $allowance->push ([
          'Tunjangan A'   => 200000,
          'Tunjangan B'   => 500000,
          'Tunjangan C'   => 300000,
      ]);

      $deduction->push ([
          'Potongan A'   => 200000,
          'Potongan B'   => 500000,
          'Potongan C'   => 300000,
      ]);

      for ($i = 0; $i < 200; $i++) {
          if ($i == 0) {
            $users->push([
              'employee_id'       => 'Employee ID',
              'full_name'         => 'Full Name',
              'job_title'         => 'Job Title',
              'basic_salary'      => 'Basic Salary',
              'total_allowance'   => 'Total Allowance',
              'total_deduction'   => 'Total Deduction'
            ]);
          }
          else {
            $users->push([
                'employee_id'       => 'TDI-A' . $i,
                'full_name'         => $faker->name,
                'job_title'         => $faker->streetName,
                'basic_salary'      => number_format($faker->numberBetween($min = 1000000, $max = 9000000)),
                'total_allowance'   => number_format($faker->numberBetween($min = 100000, $max = 1000000)),
                'allowance'         => $allowance,
                'total_deduction'   => number_format($faker->numberBetween($min = 100000, $max = 1000000)),
                'deduction'         => $deduction
                /*'titleMale'   => number_format($faker->randomNumber(2)),
                'titleFemale' => number_format($faker->randomNumber(2)),
                'suffix'      => number_format($faker->randomNumber(2)),

                'name'    => number_format($faker->randomNumber(2)),
                'firstName'   => number_format($faker->randomNumber(2)),
                'firstNameMale'    => number_format($faker->randomNumber(2)),
                'firstNameFemale'  => number_format($faker->randomNumber(2)),
                'lastName'   => number_format($faker->randomNumber(2)),
                'cityPrefix'       => number_format($faker->randomNumber(2)),
                'secondaryAddress'   => number_format($faker->randomNumber(2)),
                'state' => number_format($faker->randomNumber(2)),
                'stateAbbr'      => number_format($faker->randomNumber(2)),

                'name1'    => number_format($faker->randomNumber(2)),
                'firstName1'   => number_format($faker->randomNumber(2)),
                'firstNameMale1'    => number_format($faker->randomNumber(2)),
                'firstNameFemale1'  => number_format($faker->randomNumber(2)),
                'lastName1'   => number_format($faker->randomNumber(2)),
                'cityPrefix1'       => number_format($faker->randomNumber(2)),
                'secondaryAddress1'   => number_format($faker->randomNumber(2)),
                'state1' => number_format($faker->randomNumber(2)),
                'stateAbbr1'      => number_format($faker->randomNumber(2)),

                'name2'    => number_format($faker->randomNumber(2)),
                'firstName2'   => number_format($faker->randomNumber(2)),
                'firstNameMale2'    => number_format($faker->randomNumber(2)),
                'firstNameFemale2'  => number_format($faker->randomNumber(2)),
                'lastName2'   => number_format($faker->randomNumber(2)),
                'cityPrefix2'       => number_format($faker->randomNumber(2)),
                'secondaryAddress2'   => number_format($faker->randomNumber(2)),
                'state2' => number_format($faker->randomNumber(2)),
                'stateAbbr2'      => number_format($faker->randomNumber(2)),

                'name3'    => number_format($faker->randomNumber(2)),
                'firstName3'   => number_format($faker->randomNumber(2)),
                'firstNameMale3'    => number_format($faker->randomNumber(2)),
                'firstNameFemale3'  => number_format($faker->randomNumber(2)),
                'lastName3'   => number_format($faker->randomNumber(2)),
                'cityPrefix3'       => number_format($faker->randomNumber(2)),
                'secondaryAddress3'   => number_format($faker->randomNumber(2)),
                'state3' => number_format($faker->randomNumber(2)),
                'stateAbbr3'      => number_format($faker->randomNumber(2))*/
            ]);
          }
      }


      //return Datatables::of($users)->make();
      return json_encode($users);
      // for ($i = 0; $i < 1000; $i++) {
      //     $users->push([
      //         'employee'    => $faker->name,
      //         'allowance'   => number_format($faker->randomNumber),
      //         'overtime'    => number_format($faker->randomNumber),
      //         'additional'  => number_format($faker->randomNumber),
      //         'deduction'   => number_format($faker->randomNumber),
      //         'total'       => number_format($faker->randomNumber)
      //     ]);
      // }
      // return Datatables::of($users)->make();
    }


}
