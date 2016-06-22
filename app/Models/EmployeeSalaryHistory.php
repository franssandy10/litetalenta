<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Auth;
use Config;
use App\Models\CustomModelCompany;

class EmployeeSalaryHistory extends CustomModelCompany
{
  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'employee_salary_history';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = ['new_salary', 'old_salary','effective_date','employee_id_fk','transaction_id_fk'];
  protected $rules=array(
    'new_salary' => 'required|numeric',
    );
  protected $attributeNames=[
    'new_salary'=>'Salary'
  ];
  protected $messages=[];


  public function employee(){
    return $this->belongsTo('App\Models\Employee','employee_id_fk','id');
  }
}
