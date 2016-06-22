<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class CreateTimeOffPolicyRequest extends Request
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
      $array=[
        // 'exact-amount'=>'required_if:selectMethod,exactAmount|numeric',
        // 'percent-amount'=>'required_if:selectMethod,percentFrom|numeric|max:100',
        'policy_code' => 'required|max:255',
        'name'=>'required',
        'balance'=>'required_unless:unlimited_flag,1|numeric|min:1',
        // 'assign_date'=>'required_unless:unlimited_flag,1|date',
        // 'employees'=>'required',//_if:selectForEmployee,noOnlySelected',
        'effective_date'=>'required|date',
      ];
      // switch($this->method()){
      //   case 'PUT':
      //   {
      //       unset($array['salary']);
      //       break;
      //   }

      // }

      return $array;
    }

    public function messages(){
      return [
          'balance.required_unless'=>'Balance is required',
          'assign_date.required_unless'=>'Assign Date is required',
          'employees.required'=>'Choose at least 1 Employee',
      ];
    }
    public function attributes(){
      return[
      'name'=>'Policy Name',
      'policy_code'=>'Policy Code',
      'effective_date'=>'Effective Date',
      'balance'=>'Balance',
      'assign_date'=>'Assign Date',
      ];
    }
}
