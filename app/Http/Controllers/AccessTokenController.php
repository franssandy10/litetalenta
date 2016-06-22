<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\AccessToken;
use Constant;
use App\Models\Message;
use App\Models\Approvement;
use Sentinel;

class AccessTokenController extends Controller
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
  protected function access($token, $status=''){ //status = request approved | request rejected
    $model=AccessToken::where('code',$token)->first();
    if($model){
      if($model->user_access_id_fk == Sentinel::getUser()->id){
        if($model->complete_access()){
          return redirect()->route('approve.fromemail',[
                                'type_ref'=>$model->type_ref,
                                'fk_ref'=>$model->fk_ref,
                                'receiver'=>$model->user_access_id_fk,
                                'status'=>$status]);
        } else $reason = 'Token Expired!';
      } else return redirect()->route('dashboard'); //$reason = 'Unauthorized User';
    } else $reason = '404 Page Not Found';
    return redirect()->route('errorPage',['reason'=>$reason]);
  }
}