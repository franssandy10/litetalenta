<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\CustomModelCompany;
use Constant;
use Sentinel;
class Approvement extends CustomModelCompany
{
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
   protected $table = 'approvement';

  protected $fillable = ['box_type','fk_ref','reason','approved_flag','approved_date'];
  protected $messages=[];
  protected $rules=array();
  protected $attributeNames=[];
  /**
   * [reimbursementPolicies relationship with reimbursement request]
   * @return [type] [belongsTo]
   */
  public function reimbursementRequest(){
    return $this->belongsTo('App\Models\ReimbursementRequest','fk_ref');
  }
  /**
   * [timeoffPolicies relationship with timeoff request]
   * @return [type] [belongsTo]
   */
  protected function timeoffRequest(){
    return $this->belongsTo('App\Models\timeoffPolicies','fk_ref');
  }
  /**
   * [employee relationship with user access]
   * @return [type] [description]
   */
  public function useraccess(){
    return $this->belongsTo('App\Models\User','approved_by')->where('company_id_fk',Sentinel::getUser()->id);
  }

  /**
  * relationship with user
  */
  public function approver(){
    return $this->belongsTo('App\Models\User','approved_by');
  }
}
