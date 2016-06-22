<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\CustomModelCompany;

class ReimbursementQuota extends CustomModelCompany
{
	/**
	* The database table used by the model.
	*
	* @var string
	*/
	protected $table = 'reimbursement_quota';
	protected $fillable = ['policy_id_fk','employee_id_fk','amount','effective_date','expired_date','unlimited_flag'];
	protected $messages=[];
	protected $rules=array(
		'balance'=>'required|numeric',

	);
	protected $attributeNames=[
		'balance'=>'Balance',
	];

	// ======= RELATIONSHIPS ===============
    protected function employee(){
      return $this->belongsTo('App\Models\Employee','employee_id_fk');
    }
    protected function policy(){
      return $this->belongsTo('App\Models\ReimbursementPolicies','policy_id_fk');
    }

    public static function getMyBalancePerPolicy($policy_id_fk, $employee_id_fk, $forblade = false) {
    	$lastAssignedQuota = ReimbursementQuota::where('policy_id_fk',$policy_id_fk)
                                             ->where('employee_id_fk',$employee_id_fk)
                                             ->orderBy('created_date','DESC')->first();
 		if(!$lastAssignedQuota) return $forblade ? 'Rp 0' : 0;

		if($forblade) {
			return $lastAssignedQuota->unlimited_flag ? 'Unlimited' : 'Rp '.number_format($lastAssignedQuota['amount']-ReimbursementTaken::totalMyApprovedMountPerPolicy($policy_id_fk,$employee_id_fk),0,'.',',');
		}
  		return $lastAssignedQuota['amount']-ReimbursementTaken::totalMyApprovedMountPerPolicy($policy_id_fk,$employee_id_fk);
    }
}
