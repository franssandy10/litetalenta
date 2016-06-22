<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class EmployeeCompanyRequest extends Request
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
          'employment_status'=>'required|max:255',
          'join_date'=>'required|max:255',
          'end_contract_date'=>'required_if:employment_status,2|more_than_other_date:join_date',
            'end_probation_date'=>'required_if:employment_status,3|more_than_other_date:join_date',
        ];

    }
    public function attributes(){
      return [
        'employment_status'=>'Employment Status',
        'join_date'=>'Join Date',
        'end_contract_date'=>'End Contract Date',
        'end_probation_date'=>'End Probation Date'
      ];
    }
    public function messages(){
      return ['end_contract_date.required_if'=>'The end contract date is Required',
      'end_probation_date.required_if'=>'The end probation date is Required'];
    }
}
