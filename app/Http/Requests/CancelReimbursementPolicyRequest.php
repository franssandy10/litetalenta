<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
class CancelReimbursementPolicyRequest extends Request
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
          'data' => 'required'
        ];
    }

    public function attributes(){
        return [
          'data'=>'',

        ];
    }
    public function messages()
    {
        return [
            'id.required' => 'Please Using button to cancel policy',
        ];
    }
}
