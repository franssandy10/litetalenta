<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\CustomModelCompany;
use Illuminate\Database\Eloquent\SoftDeletes;
class TimeOffTaken extends CustomModelCompany
{
  use softDeletes;

  /**
   * The database table used by the model.
   *
   * @var string
   */
  
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = ['start_date','end_date','day_amount','policy_id_fk','employee_id_fk','has_approver'];
  protected $messages=[];
  protected $rules=array(
    'policy_id_fk'=>'required',
    'start_date'=>'required|date',
    'end_date'=>'required|date',
    'reason'=>'required'
    );
  protected $attributeNames=[
    'employee_id_fk'=>'Employee Name',
    'policy_id_fk'=>'Policy Name',
    'start_date'=>'Start Date',
    'end_date'=>'End Date',
  ];
  public function approvementByUser($userid){
    $model=Approvement::where('box_type',2)->where('fk_ref',$this->id)->where('approved_by',$userid)->first();
    if(!$models){
      return 'Approvement Not Found!';
    }
    return;// $model->approved_flag;
  }

  //   $approvement = array('approved'=>array(), 'rejected'=>array(), 'pending'=>array());
  //   foreach ($models as $model){
  //       if($model->approved_flag==1){
  //         $approvement['approved'][] = $model;
  //       } else if($model->approved_flag==2){
  //         $approvement['rejected'][] = $model;
  //       } else {
  //         $approvement['pending'][] = $model;
  //       }
  //   }
  //   return $approvement;
  // }

  // public function getApprovementStatus(){
  //   $approvement = $this->Approvement();
  //   if (count($approvement['rejected'])>0) return 'rejected';
  //   else if (count($approvement['pending'])>0) return 'pending';
  //   else return 'approved';
  // }

  public function getApproverName(){//TODO nanti ga dipake kalo approver udah mau ditampilin smua
    if($this->has_approver == 0) $this->approverName = '  ---  ';
    else $this->approverName = $this->approver->name;
    unset($this->approver);
  }

  public function approver(){ //TODO nanti ga dipake kalo approver udah mau ditampilin smua
    return $this->belongsTo('App\Models\User','has_approver');
  }
  public function policy(){
    return $this->belongsTo('App\Models\TimeOffPolicies','policy_id_fk')->withTrashed();
  }
  public function employee(){
    return $this->belongsTo('App\Models\Employee','employee_id_fk');
  }
  public function request(){
    return $this->belongsTo('App\Models\TimeOffRequest','fk_ref');
  }
  public function approvement(){
    return $this->hasMany('App\Models\Approvement','fk_ref');
  }
  public function timeoffrequest(){
    return $this->belongsTo('App\Models\timeoffrequest','fk_ref');
  }
}
