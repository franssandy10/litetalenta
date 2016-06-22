<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\CustomModel;
class Province extends CustomModel
{
  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'province';
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = ['name','amount','effective_date'];
}
