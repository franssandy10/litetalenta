<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Config;
use Sentinel;
class ReimbursementPoliciesRequest extends Request
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

      $validator->sometimes(['limit','limit_type'], 'required', function($input)
      {
          return $input->unlimited_flag==false;
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
      Config::set('database.connections.company.database',Config::get('app.database_name_company').Sentinel::getUser()->company_id_fk);
        return [
          'name' => 'required|max:255|unique:company.reimbursement_policies,name',
          'limit' => 'numeric',
        'assign_date'=>'date',
          'effective_date'=>'required|date',
          'limit_type'=>'required',
        ];
    }
    public function attributes(){
      return [
        'name'=>'Reimbursement Name',
        'effective_date'=>'Effective Date',
        'limit'=>'Limit',];
    }
}
