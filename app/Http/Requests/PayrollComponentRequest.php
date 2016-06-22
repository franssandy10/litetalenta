<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class PayrollComponentRequest extends Request
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
            'component_name'=>'required',
            'component_amount'=>'required|numeric',
            'component_tax_type'=>'required',
            'component_type_occur'=>'required',
            'component_type'=>'required',

        ];
    }
    public function attributes(){
      return [
        'component_type_occur'=>'Type',
      'component_name'=>'Component name'];
    }
}
