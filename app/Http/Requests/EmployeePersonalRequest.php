<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Config;
class EmployeePersonalRequest extends Request
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
      if($this->method=='POST'){
        $validator->sometimes(['email'], 'unique:'.Config('default').'.user_access,email', function($input)
        {
            return $input->first_register!=='yes';
        });

      }

      return $validator;
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
      return $rules= [
        'employee_id' => 'required|max:255|min:2',
        'email'=>'required|email|unique_email:first_register|max:255',
        'first_name'=>'required|max:255|min:2',
        'last_name'=>'min:2',
        'identity_type'=>'required',
        'identity_number'=>'min:2|max:30',
        'identity_expired_date'=>'date',
        'address'=>'min:15',
        'postal_code'=>'min:2',
        'place_of_birth'=>'min:2',
        'date_of_birth'=>'date',
        'mobile_phone'=>'digits_between:6,20',
        'phone'=>'digits_between:6,20',
        'gender'=>'required',
        'marital_status'=>'required',
        'blood_type'=>'required',
        'religion'=>'required'
      ];

    }
    /**
     * [attributes get the attributes rules that apply to request]
     * @return [type] [description]
     */
    public function attributes(){
      return [
        'employee_id' => 'Employee ID',
        'email'=>'Email',
        'first_name'=>'First Name',
        'last_name'=>'Last Name',
        'identity_type'=>'Identity Type',
        'identity_number'=>'Identity Number',
        'identity_expired_date'=>'Identity Expired Date',
        'address'=>'Address',
        'postal_code'=>'Postal Code',
        'place_of_birth'=>'Place of Birth',
        'date_of_birth'=>'Date of Birth',
        'mobile_phone'=>'Mobile Phone',
        'phone'=>'Phone',
        'gender'=>'Gender',
        'marital_status'=>'Marital Status',
        'blood_type'=>'Blood Type',
        'religion'=>'Religion',
      ];
    }
}
