<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\TaxPersonRequest;
use App\Http\Requests\PayrollCutoffRequest;
use App\Http\Controllers\Controller;
use App\Models\TaxPerson;
use App\Models\PayrollCutoff;
use App\Models\PayrollComponent;
class PayrollController extends Controller
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
        return view('payroll/index');
    }
    public function doSetDate(Request $request){
      $inputs=$request->all();
      $request->session()->put('payrolldate', $inputs);
      return response()->json(['status'=>'success','url'=>route('payrollsystemrun')]);

      // return redirect()->route('payrollsystemrun');
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


    /* Payroll Config, if people doesn't use payroll feature at the begining, and want to use it in the other day */
    // payroll cutoff and tax person still firsttimer
    public function configure(){
      $componentAllowance=PayrollComponent::where('component_type',1)->get();
      $componentDeduction=PayrollComponent::where('component_type',2)->get();
        $taxPerson=TaxPerson::first();
        if(!$taxPerson){
          $taxPerson=new TaxPerson;
        }
        $payrollCutoff=PayrollCutoff::first();
        if(!$payrollCutoff){

          $payrollCutoff=new PayrollCutoff;
          $payrollCutoff->payroll_schedule=25;
          $payrollCutoff->payroll_from=1;
          $payrollCutoff->payroll_to=31;
          $payrollCutoff->attendance_from=1;
          $payrollCutoff->attendance_to=31;
        }
        return view('payroll/configure',['tax_person'=>$taxPerson
          ,'payroll_cutoff'=>$payrollCutoff
          ,'component_allowance'=>$componentAllowance
          ,'component_deduction'=>$componentDeduction]);
    }
    /**
     * [doSetPayrollDetail set payroll detail]
     * @param  TaxPersonRequest $request [description]
     * @return [type]                    [description]
     */
    public function doSetPayrollDetail(TaxPersonRequest $request){
      //dd($request->all());
      $model=TaxPerson::first();
      if($model){
        $model->update($request->all());
      }
      else{
        $model=new TaxPerson;
        $model->insertData($request->all());
      }
      return response()->json(['status'=>'success']);
    }
    /**
     * [doSetPayrollDetail set payroll detail]
     * @param  TaxPersonRequest $request [description]
     * @return [type]                    [description]
     */
    public function doSetPayrollCutoff(PayrollCutoffRequest $request){
      $model=PayrollCutoff::first();
      if($model){
        $model->update($request->all());
      }
      else{
        $inputs=$request->all();
        $inputs['autorun_schedule']=0;
        $model=new PayrollCutoff;
        $model->insertData($inputs);
      }

      return response()->json(['status'=>'success']);
    }
}
