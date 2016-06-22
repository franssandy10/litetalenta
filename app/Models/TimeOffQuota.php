<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\CustomModelCompany;

class TimeOffQuota extends CustomModelCompany
{
	/**
	* The database table used by the model.
	*
	* @var string
	*/
	protected $table = 'time_off_quota';
	protected $fillable = ['policy_id_fk','employee_id_fk','amount','effective_date','expired_date'];
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
      return $this->belongsTo('App\Models\TimeOffPolicies','policy_id_fk');
    }

    public static function getMyBalancePerPolicy($employee_id_fk, $policy_id_fk) {
    	$lastAssignedQuota = TimeOffQuota::where('policy_id_fk',$policy_id_fk)
                                             ->where('employee_id_fk',$employee_id_fk)
                                             ->orderBy('created_date','DESC')->first();
        //list approved timeoffrequest per policy

       	$listApprovedForThisPolicy = TimeOffRequest::where('policy_id_fk',$policy_id_fk)
                                        ->where('employee_id_fk',$employee_id_fk)
                                        ->where('approved_flag',1)
                       					->get(['id'])->toArray();

        $totalApprovedCount = TimeOffTaken::whereIn('fk_ref',$listApprovedForThisPolicy)->sum('day_amount');
        return $lastAssignedQuota['amount']-$totalApprovedCount;
    }
}
