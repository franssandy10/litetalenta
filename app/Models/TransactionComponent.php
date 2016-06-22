<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\CustomModelCompany;

class TransactionComponent extends CustomModelCompany
{
    protected $fillable = ['transaction_id', 'type_transaction','effective_date'];

	public function salaryHistory(){
		return $this->hasMany('App\Models\EmployeeSalaryHistory','transaction_id_fk','id');
	}
	public function payrollComponentEmployee(){
		return $this->hasMany('App\Models\PayrollComponentEmployee','transaction_id_fk','id');
	}
}
