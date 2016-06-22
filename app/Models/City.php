<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\CustomModel;
class City extends CustomModel
{
  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'city';
  public $timestamps=false;

  private $model;
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = ['province','city','amount','effective_date'];
}
