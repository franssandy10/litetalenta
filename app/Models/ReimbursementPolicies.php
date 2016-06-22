<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\CustomModelCompany;
use Illuminate\Database\Eloquent\SoftDeletes;
class ReimbursementPolicies extends CustomModelCompany
{
  use SoftDeletes;
    private $approve;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'reimbursement_policies';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = ['name','limit','effective_date','limit_type','unlimited_flag','default_flag'];

    protected $messages=[];
    protected $rules=array(
      'name' => 'required|max:255|unique:company.reimbursement_policies,name',
      'limit' => 'required',
      'effective_date'=>'required|date',
      'limit_type'=>'required',
      // 'approver_list'=>'required'
      );
    protected $attributeNames=[
      'name'=>'Reimbursement Name',
      'effective_date'=>'Effective Date',
      'limit'=>'Limit',
      // 'approver_list' =>'Approver'
    ];
    /**
   * get relationship approver
   * @return object employee
   */
  protected function approverList(){
    return $this->hasMany('App\Models\ApproverList','policy_id_fk','id');
  }
  /**
  * set approvelist data
  * @return list approver in string
  */
  public function getApproverListName(){
    $list=$this->approverList;
    $tempListName=[];
    if($list->count()==0){
      return 'No Approver';
    }
    foreach($list as $data){
      $tempListName[]=$data->getApprover->name;
    }
     $tempListName=implode(", ", $tempListName);
    return $tempListName;
  }
  public function getLimitFormat(){
    return $this->setNumberFormat($this->limit);
  }
  public function getLimitTypeFormat(){
    if($this->limit_type==1){
      return 'PER CLAIM';
    }
    else if($this->limit_type==2){
      return 'PER MONTH';
    }
    else if($this->limit_type==3){
      return 'PER YEAR';
    }
  }
}
