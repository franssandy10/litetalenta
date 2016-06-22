<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use UserService;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class ServiceJsonController extends Controller
{
  /**
   * Create a new authentication controller instance.
   *
   * @return void
   */
  public function __construct()
  {
      // $this->middleware('guest');

  }
  protected function getCityJson($name){
    return response()->json(UserService::getCity($name));
  }


}
