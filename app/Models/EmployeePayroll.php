<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\Models\CustomModelCompany;

class EmployeePayroll extends CustomModelCompany
{
    protected $table = 'employee_payroll';
    public function employeeDetail()
    {
        return $this->belongsTo('App\Models\Employee','employee_id_fk','id');
    }
}
