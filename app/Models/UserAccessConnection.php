<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\CustomModel;
use Config;
use Storage;

class UserAccessConnection extends CustomModel
{
  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'user_access_connection';
  /**
   * get relationship employee data
   * @return object employee
   */
  protected function userEmployee(){
    return $this->hasOne('App\Models\Employee','id','employee_id_fk');
  }
  protected function userAccess(){
    return $this->hasOne('App\Models\User','id','user_access_id_fk');
  }
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = ['user_access_id_fk','employee_id_fk','company_id_fk','avatar'];
  /**
   * [getAvatar description]
   * @return [type] [description]
   */
  public function getAvatar(){
    $avatar=$this->avatar;
    if($avatar){
      $exists = Storage::disk('s3')->exists($avatar);
      if($exists){
        return config('param.url_s3_storage').$avatar;
      }
    }
    return asset(config('param.url_uploads').'blank.jpg');
  }

}
