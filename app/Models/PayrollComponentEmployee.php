<?php

namespace App\Models;

use App\Models\CustomModelCompany;
use Sentinel;
use Constant;
class PayrollComponentEmployee extends CustomModelCompany
{

	/**
	* The attributes that are mass assignable.
	* @var array
	*/
	protected $fillable = ['component_id_fk', 'employee_id_fk','component_amount','transaction_id_fk'];

	public function component(){
		return $this->hasOne('App\Models\PayrollComponent','id','component_id_fk');
	}

	public function employee(){
		return $this->belongsTo('App\Models\Employee','employee_id_fk','id');
	}
	public function scopeSelf($query){
		return $query->where('employee_id_fk',Sentinel::getUser()->userAccessConnection->userEmployee->id);
	}


	//MONTHLY ALLOWANCE
	public static function getAllowanceEmployee($employee_id, $list_componentallowance=null, $tax_type=3) {
		if($list_componentallowance==null) { //$tax_type==3 get taxable and nontaxable
			$list_componentallowance = $tax_type == 3 ? PayrollComponent::where('component_type', Constant::COMP_TYPE_ALLOWANCE)->where('component_type_occur', Constant::COMP_TYPE_OCCUR_MONTHLY)->get(['id'])->toArray() : PayrollComponent::where('component_type', Constant::COMP_TYPE_ALLOWANCE)->where('component_type_occur', Constant::COMP_TYPE_OCCUR_MONTHLY)->where('component_tax_type', $tax_type)->get(['id'])->toArray();
		}
		return PayrollComponentEmployee::where('employee_id_fk', $employee_id)->whereIn('component_id_fk', $list_componentallowance)->sum('component_amount');
	}


	//MONTHLY DEDUCTION
    public static function getDeductionEmployee($employee_id, $list_componentdeduction=null, $tax_type=3){
		if($list_componentdeduction==null) { //$tax_type==3 get taxable and nontaxable
			$list_componentdeduction = $tax_type == 3 ? PayrollComponent::where('component_type', Constant::COMP_TYPE_DEDUCTION)->where('component_type_occur', Constant::COMP_TYPE_OCCUR_MONTHLY)->get(['id'])->toArray() : PayrollComponent::where('component_type', Constant::COMP_TYPE_DEDUCTION)->where('component_type_occur', Constant::COMP_TYPE_OCCUR_MONTHLY)->where('component_tax_type', $tax_type)->get(['id'])->toArray();
		}
      	return PayrollComponentEmployee::where('employee_id_fk', $employee_id)->whereIn('component_id_fk', $list_componentdeduction)->sum('component_amount');
    }
}

