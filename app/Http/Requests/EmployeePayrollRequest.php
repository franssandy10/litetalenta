<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class EmployeePayrollRequest extends Request
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
    protected function getValidatorInstance(){
      $validator = parent::getValidatorInstance();

      $validator->sometimes(['npwp_number','npwp_date'], 'required', function($input)
      {
          return $input->no_npwp==false && $input->salary_config==='taxable';
      });

      return $validator;
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
      $array=[
        'salary'=>'required|numeric',
        'employment_tax_status'=>'required_if:salary_config,taxable',
        'npwp_number'=>'min:3',
        'npwp_date'=>'date',
        'tax_status'=>'required_if:salary_config,taxable',
        'bank_account'=>'required_unless:bank_id_fk,|digits_between:3,30',
        'bank_holder'=>'required_unless:bank_id_fk,|string',
        'bpjstk_number'=>'min:3',
        'bpjsk_number'=>'min:3'];
      switch($this->method()){
        case 'PUT':
        {
            unset($array['salary']);
            break;
        }

      }
      return $array;
    }
    public function messages(){
      return [
          'bank_account.required_unless'=>'The bank account is Required',
          'bank_holder.required_unless'=>'The bank holder is Required',
          'bank_account.required_unless'=>'The bank account is Required',
          'bank_holder.required_unless'=>'The bank holder is Required',

      ];
    }
    public function attributes(){
      return[
        'salary'=>'Salary',
        'employment_tax_status'=>'Employee Tax Status',
        'tax_status'=>'Tax Status',
        'bank_account'=>'Bank Account',
        'bank_holder'=>'Bank Holder',
        'bpjstk_number'=>'BPJS Ketenagakerjaan',
        'bpjsk_number'=>'BPJS Kesehatan'
        ,'npwp_number'=>'NPWP'
        ,'npwp_date'=>'NPWP Date'
      ];
    }
}
