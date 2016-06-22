<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\CustomModel;
use Carbon\Carbon;
class AccessToken extends CustomModel
{
  protected $table = 'access_token';
    public function complete_access(){
      if($this->checkToken()===true){
        $this->completed=1;
        $this->completed_at=Carbon::now();
        $this->save();
        return true;
      }
      return false;
    }

    public function checkToken(){
      $expiredDate=Carbon::parse($this->expired_at);
      $currentDate=Carbon::now();
      // check if expirednya uda abz
      // check if uda prnh dipakai
      if($expiredDate->diffInDays($currentDate)<0||$this->completed==1){
        return false;
      }
      return true;
    }

    public function generateToken($user_access,$fk_ref,$type_ref,$view_access){
      $this->user_access_id_fk=$user_access;
      $this->fk_ref=$fk_ref;
      $this->type_ref=$type_ref;
      $this->code=str_random(200);
      $this->expired_at=Carbon::now()->addWeeks(1);
      $this->save();
      return $this->code;
    }
}
