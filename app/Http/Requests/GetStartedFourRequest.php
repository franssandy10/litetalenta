<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class GetStartedFourRequest extends Request
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
          'tax_person_name' => 'required|max:255|min:2',
          'tax_person_npwp' => 'required|size:20',
          'company_npwp'=>'required|size:20',
          'npwp_date'=>'required|date',
          'company_bpjstk'=>'required|min:4|max:50',
          'company_jkk'=>'required',
        ];
    }
    public function attributes(){
      return[
        'tax_person_name'=>'Tax Person Name',
        'tax_person_npwp'=>'Tax Person NPWP Number',
        'company_npwp'=>'Company NPWP Number',
        'npwp_date'=>'NPWP Date',
        'company_bpjstk'=>'BPJSTK Number',
        'company_jkk'=>'JKK Type'
      ];
    }
}
