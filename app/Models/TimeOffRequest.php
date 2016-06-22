<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\CustomModelCompany;
use App\Models\Approvement;
use Constant;
use Sentinel;
class TimeOffRequest extends CustomModelCompany
{
  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'time_off_request';
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = ['start_date','end_date','half_day','reason','policy_id_fk','employee_id_fk'];
  protected $messages=[];
  protected $rules=array(
    'policy_id_fk'=>'required',
    'start_date'=>'required|date',
    'end_date'=>'required|date',
    'reason'=>'required'

    );
  protected $attributeNames=[
    'employee_id_fk'=>'Employee Name',
    'policy_id_fk'=>'Policy',
    'start_date'=>'Date',
    'end_date'=>'Date',
    'reason'=>'Reason',
  ];
  public function Approvement(){
    $models=Approvement::where('box_type',2)->where('fk_ref',$this->id)->get();
    if(!$models){
      return 'Approvement Not Found!';
    }

    $approvement = array('approved'=>array(), 'rejected'=>array(), 'pending'=>array());
    foreach ($models as $model){
        if($model->approved_flag==1){
          $approvement['approved'][] = $model;
        } else if($model->approved_flag==2){
          $approvement['rejected'][] = $model;
        } else {
          $approvement['pending'][] = $model;
        }
    }
    return $approvement;
  }

  public function getApprovementStatus(){
    $approvement = $this->Approvement();
    if (count($approvement['rejected'])>0) return 'rejected';
    else if (count($approvement['pending'])>0) return 'pending';
    else return 'approved';
  }

  public function getPendingApproverName(){
    $query = Approvement::with(['approver' => function($qq) {
                                      $qq->addSelect(['name','id']);
                                  }])
                                 ->where('box_type',Constant::BOX_TYPE_TIMEOFF)
                                 ->where('fk_ref',$this->id)
                                 ->where('approved_flag',0)
                                 ->get();
    $username = Sentinel::getUser()->name;
    $arr = array();
    $isApprover = 0;
    foreach($query as $q){
      $name = $q->approver->name;
      if ($name == $username) {
        $arr[] = 'You';
        $isApprover=1;
      }
      else $arr[] = $name;
    }
    return array('list'=>$arr,'isApprover'=>$isApprover);
  }

  public function policy(){
    return $this->belongsTo('App\Models\TimeOffPolicies','policy_id_fk')->withTrashed();
  }
  public function employee(){
    return $this->belongsTo('App\Models\Employee','employee_id_fk');
  }
}
