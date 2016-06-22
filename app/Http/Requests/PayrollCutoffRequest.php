<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class PayrollCutoffRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'payroll_schedule'=>'required',
            'attendance_from'=>'required',
            'attendance_to'=>'required',
            'payroll_from'=>'required',
            'payroll_to'=>'required',
            'tax_type'=>'required',
            'salary_config'=>'required',
            'company_paid_bpjstk'=>'required',
            'company_paid_bpjsk'=>'required',
            'company_paid_jp'=>'required',
            
            //
        ];
    }
    public function attributes(){
      return ['payroll_schedule'=>'Payroll Schedule'
      ,'attendance_from'=>'Attendance From'
      ,'attendance_to'=>'Attendance To'
      ,'payroll_from'=>'Payroll From'
      ,'payroll_to'=>'Payroll To'
      ,'tax_type'=>'Tax Type'
      ,'salary_config'=>'Salary Setting'
      ,'company_paid_bpjstk'=>'JHT Setting'
      ,'company_paid_jp'=>'JP Setting'
      ,'company_paid_bpjsk'=>'BPJS Kesehatan Setting'];
    }
}
