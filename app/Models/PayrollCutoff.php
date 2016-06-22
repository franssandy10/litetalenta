<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\CustomModelCompany;
class PayrollCutoff extends CustomModelCompany
{
    protected $table="payroll_cutoff";
    protected $fillable=['tax_type'
    ,'salary_config'
    ,'company_paid_bpjsk'
    ,'company_paid_bpjstk'
    ,'company_paid_jp'
    ,'autorun_schedule'
    ,'payroll_schedule'
    ,'payroll_to'
    ,'payroll_from'
    ,'attendance_to'
    ,'attendance_from'];
}
