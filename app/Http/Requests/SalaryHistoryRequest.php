<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class SalaryHistoryRequest extends Request
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
        'exact-amount'=>'required_if:selectMethod,exactAmount|numeric',
        'percent-amount'=>'required_if:selectMethod,percentFrom|numeric|max:100',
        'employees'=>'required_if:selectForEmployee,noOnlySelected',
        'effective_date'=>'required|date',
      ];
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
          'exact-amount.required_if'=>'The Amount field is Required',
          'percent-amount.required_if'=>'The Percentage field is Required',
          'employees.required_if'=>'Choose at least 1 employee',
      ];
    }
    public function attributes(){
      return[
        'exact-amount'=>'Amount',
        'percent-amount'=>'Percentage',
        'effective_date'=>'Effective Date',
      ];
    }
}
