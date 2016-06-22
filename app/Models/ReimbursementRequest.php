<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\CustomModelCompany;
use Storage;
use Constant;
use Sentinel;
class ReimbursementRequest extends CustomModelCompany
{
  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'reimbursement_request';
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */

  protected $fillable = ['employee_id_fk','policy_id_fk','amount','reason','attachment'];

  protected $messages=[];
  protected $rules=array(
    'policy_id_fk'=>'required',
    'amount'=>'required|numeric',
    'reason'=>'required',
    'attachment'=>'required'
  );
  protected $attributeNames=[
    'employee_id_fk'=>'Employee ',
    'policy_id_fk'=>'Policy',
    'amount'=>'Amount',
    'attachment' => 'Import File'
  ];

  public function policyName(){
    $return = $this->policy->name;
    unset($this->policy);
    unset($this->policy_id_fk);
    return $return;
  }

  public function employeeName(){
    $return = $this->employee->first_name.' '.$this->employee->last_name;
    unset($this->employee);
    unset($this->employee_id_fk);
    return $return;
  }

  public function attachmentURL(){
    $bucketName = 'https://s3-ap-southeast-1.amazonaws.com/talenta-lite/reimbursement/';
    $pathToFile = $bucketName.$this->attachment;
    return $pathToFile;
    // $this->attachment = $pathToFile;
    // $this->attachment = \Redirect::away($pathToFile);
  }
  public function getPendingApproverName(){
    $query = Approvement::with(['approver' => function($qq) {
                                      $qq->addSelect(['name','id']);
                                  }])
                                 ->where('box_type',Constant::BOX_TYPE_REIMBURSEMENT)
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
  public function getApprover(){
    $this->approver = Approvement::where('box_type',Constant::BOX_TYPE_REIMBURSEMENT)
                                     ->where('fk_ref',$this->id)->get();
  }

  public function policy(){
    return $this->belongsTo('App\Models\ReimbursementPolicies','policy_id_fk','id')->withTrashed();
  }

  public function employee(){
    return $this->belongsTo('App\Models\Employee','employee_id_fk');
  }

  /**
   * [getAttachment description]
   * @return [type] [description]
   */
  public function getAttachment(){
    $imagePath = 'reimbursement/'.$this->attachment;
    if($imagePath){
      $exists = Storage::disk('s3')->exists($imagePath);
      if($exists){
        return config('param.url_s3_storage').$imagePath;
      }
    }
    return null; //asset(config('param.url_uploads').'blank.jpg');
  }

  public function setRulesUploadImages(){
    $this->rules=array(
      'file_name'=>'file_type',
    );
    $this->attributeNames=[
      'file_name'=>'File Type',
    ];
  }
  public function getAmountFormat(){
    return $this->setNumberFormat($this->amount);
  }
}
