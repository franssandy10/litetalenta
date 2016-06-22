<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\CustomModelCompany;

class Attendance extends CustomModelCompany
{
   /**
   * The attributes that are mass assignable.
   *
   * @var array
   */

  protected $fillable = ['date','employee_id_fk','checked_in_at','checked_out_at',
							'late_in','late_out','early_in','early_out'];

  protected $messages=[];
  protected $rules=array(
    'employee_id_fk'=>'required',
    'checked_in_hour'	=>'required|numeric|max:23',
    'checked_in_minute'	=>'required|numeric|max:59',
    'checked_out_hour'	=>'required|numeric|max:23',
    'checked_out_minute'=>'required|numeric|max:59',
  );
  protected $attributeNames=[
    'employee_id_fk'=>'Employee ',
    'checked_in_hour'=>'Hour ',
    'checked_in_minute'=>'Minute ',
    'checked_out_hour'=>'Hour ',
    'checked_out_minute'=>'Minute ',
  ];

 /**
  * //////////// RELATIONSHIP //////////
  */   
  public function employee(){
    return $this->belongsTo('App\Models\Employee','employee_id_fk');
  }

}
