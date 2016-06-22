<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class PayrollComponentAdjustmentRequest extends Request
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
            'component_id_fk'=>'required',
            'exact-amount'=>'required|numeric',
            'employees'=>'required_if:selectForEmployee,noOnlySelected',
        ];
    }

    public function messages(){
      return [
          'employees.required_if'=>'Choose at least 1 employee',
      ];
    }
    public function attributes(){
      return [
        'component_id_fk'=>'Payroll Component',
        'exact-amount'=>'Amount'
        ];
    }
}
