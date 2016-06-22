<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\CustomModelCompany;
use App\Http\Controllers\ServiceController;
class ReimbursementTaken extends CustomModelCompany
{
  protected $fillable = ['employee_id_fk','request_id_fk','date_reimburse','amount'];
  
  /*   
  /////// Get data from relations ////////////
  */
  public function employeeName(){
    $return = $this->employee->first_name.' '.$this->employee->last_name;
    unset($this->employee);
    unset($this->employee_id_fk);
    return $return;
  }

  public function getApproverName(){
    $this->approverName = $this->approver->name;
    unset($this->approver);
  }

  public function policyName(){
    // $return = $this->request->policy;
    $return = $this->request->policy()->withTrashed()->first();
    return $return->name;
  }

  public function getCreated_date(){
    $this->created_date = ServiceController::parseDate($this->request->created_date);
  }
  /*
  ////// RELATIONSHIP //////////
  */
  public function employee(){
    return $this->belongsTo('App\Models\Employee','employee_id_fk');
  }
  public function approver(){
    return $this->belongsTo('App\Models\User','has_approver');
  }
  public function request(){
    return $this->belongsTo('App\Models\ReimbursementRequest','request_id_fk','id');
    // return $this->hasOne('App\Models\ReimbursementRequest','id','request_id_fk');
  }

  public static function totalMyApprovedMountPerPolicy($policy_id_fk, $employee_id_fk) {
    $lastAssignedQuota = ReimbursementQuota::where('policy_id_fk',$policy_id_fk)
                                             ->where('employee_id_fk',$employee_id_fk)
                                             ->orderBy('created_date','DESC')->first();
    $totalApprovedMount = 0;
    $listApprovedForThisPolicy = ReimbursementRequest::where('policy_id_fk',$policy_id_fk)
                                        ->where('employee_id_fk',$employee_id_fk)
                                        ->where('approved_flag',1)
                                ->get(['id'])->toArray();

      if(ReimbursementPolicies::find($policy_id_fk)->limit_type==1) //perclaim
          $totalApprovedMount = ReimbursementTaken::whereIn('request_id_fk',$listApprovedForThisPolicy)->sum('amount');//total all approved 
      else if(ReimbursementPolicies::find($policy_id_fk)->limit_type==2) //permonth
        $totalApprovedMount = ReimbursementTaken::whereIn('request_id_fk',$listApprovedForThisPolicy)
                                  ->whereMonth('created_date', '=', date('n'))
                                  ->whereYear('created_date', '=', date('Y'))
                                  ->sum('amount');//total all approved this month and year
      else if(ReimbursementPolicies::find($policy_id_fk)->limit_type==3) //peryear
        $totalApprovedMount = ReimbursementTaken::whereIn('request_id_fk',$listApprovedForThisPolicy)
                                  ->whereMonth('created_date', '=', date('n'))
                                  ->sum('amount');//total all approved this year

      return $totalApprovedMount;
  }
  // public function policy(){
  //   return $this->request->policy;
  // }
}
