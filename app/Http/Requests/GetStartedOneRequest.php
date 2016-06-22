<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class GetStartedOneRequest extends Request
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
          'name' => 'required|alpha_spaces|max:255|min:2',
          'company_name' => 'required|max:255|min:2',
          'email'=>'required|email|max:255|unique:user_access',
          'password'=>'required|password_validator|confirmed|min:6',
          'phone'=>'digits_between:6,20',
        ];
    }
    public function attributes(){
      return[
        'name'=>'full name',
      ];
    }
}
