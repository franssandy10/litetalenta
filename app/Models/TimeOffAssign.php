<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\CustomModelCompany;
use Illuminate\Database\Eloquent\SoftDeletes;

class TimeOffAssign extends CustomModelCompany
{
  	use SoftDeletes;
  	
	/**
	* The database table used by the model.
	*
	* @var string
	*/
	protected $table = 'time_off_assign';

	// ======= RELATIONSHIPS ===============
    protected function employee(){
      return $this->belongsTo('App\Models\Employee','employee_id_fk');
    }
    public function policy(){
      return $this->belongsTo('App\Models\TimeOffPolicies','policy_id_fk');
    }
}
