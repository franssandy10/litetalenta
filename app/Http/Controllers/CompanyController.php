<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class CompanyController extends Controller
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
    public function updateCompanyDetail(Request $request){
      $validator = Validator::make($request->all(), [
          'employee_id' => 'required|max:255',
          'email'=>'required|email|max:255',
          'first_name'=>'required|max:255',
          'last_name'=>'required|max:255',
          'identity_type'=>'required',
          'identity_number'=>'required|max:30',
          'identity_expired_date'=>'required|date',
          'address'=>'string',
          'postal_code'=>'digits_between:3,8',
          'place_of_birth'=>'string',
          'date_of_birth'=>'date',
          'mobile_phone'=>'digits_between:3,15',
          'phone'=>'digits_between:3,15',
          'gender'=>'required',
          'marital_status'=>'required',
          'blood_type'=>'required',
          'religion'=>'required'
      ]);
      if ($validator->fails()) {
        return response()->json($validator->messages());
      }
      else{
        return response()->json(['status'=>'success']);
      }
    }
}
