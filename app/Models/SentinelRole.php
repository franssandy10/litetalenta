<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Auth;
use App\Models\CustomModel;
use Cartalyst\Sentinel\Roles\EloquentRole;
class SentinelRole extends EloquentRole
{
  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $connection="mysql";

  /**
   * The Eloquent users model name.
   *
   * @var string
   */
  protected static $usersModel = 'App\Models\User';
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = ['name','company_id_fk','slug','permissions'];
}
