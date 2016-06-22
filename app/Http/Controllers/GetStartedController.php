<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Validator;
use App\Models\User;
use App\Models\Company;
use App\Models\TaxPerson;
use App\Http\Controllers\Controller;
use App\Http\Requests\GetStartedOneRequest;
use App\Http\Requests\GetStartedFourRequest;

class GetStartedController extends Controller
{
    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Method GET
     * Show page Getting Started 1
     *
     * @param  request $request
     * @return view
     */
    protected function pageOne(Request $request)
    {
      return view('getting-started/1');
    }
    /**
     * Get a validator get started 1.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function doStartedOne(GetStartedOneRequest $request)
    {


        $result=$request->input();
        unset($result['_token']);
        unset($result['password_confirmation']);
        $result['ip_address']=$request->ip();
        $request->session()->put('one', $result);
        return response()->json(['status'=>'success','url'=>route('getstarted.two')]);
    }
   /**
    * Method GET
    * Show page Getting Started 2
    *
    * @param  request $request
    * @return view
    */
   protected function pageTwo(Request $request)
   {
     return view('getting-started/2');
   }
   /**
    * Get a validator get started 2.
    *
    * @param  array  $data
    * @return \Illuminate\Contracts\Validation\Validator
    */
   protected function doStartedTwo(Request $request)
   {
      $input=$request->all();
      unset($input['_token']);
      unset($input['submitButton']);
      $request->session()->put('two', $input);
      return response()->json(['status'=>'success','url'=>route('getstarted.three')]);
   }
  /**
   * Method GET
   * Show page Getting Started 3
   *
   * @param  request $request
   * @return view
   */
  protected function pageThree(Request $request)
  {
    // print_r(session('departments'));exit;
    return view('getting-started/3');
  }
  /*
  * Handle  get started 3.
  * if success save in session first
  * @param payroll_flag
  * @return Response
  * after change
  *
  */
   protected function doStartedThree(Request $request){
      $validator = Validator::make($request->all(), [
          'payroll_flag' => 'required',
      ]);
      if ($validator->fails()) {
        return response()->json($validator->messages(),422);
      }
      else{
        $request->session()->put('payroll_flag', $request->input('payroll_flag'));
        if($request->input('payroll_flag')==='no'){
          return response()->json(['status'=>'success','url'=>route('register')]);
        }
        return response()->json(['status'=>'success','url'=>route('getstarted.four')]);
      }

   }
   /**
    * Method GET
    * Show page Getting Started 4
    *
    * @param  request $request
    * @return view
    */
   protected function pageFour(Request $request)
   {
     return view('getting-started/4');
   }
   /*
   * Handle get started 4
   * if success save in session first
   * @param job positions
   * @return Response
   */
  protected function doStartedFour(GetStartedFourRequest $request){
      $inputs=$request->all();
      unset($inputs['_token']);
      unset($inputs['submitButton']);
      $request->session()->put('four',$inputs);
      return response()->json(['status'=>'success','url'=>route('register')]);

  }

}
