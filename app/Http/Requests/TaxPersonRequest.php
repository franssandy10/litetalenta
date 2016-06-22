<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class TaxPersonRequest extends Request
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
          'bpjstk_number'=>'required|min:4|max:50',
          'jkk_type'=>'required',
        ];
    }
    public function attributes(){
      return ['tax_person_name'=>'Tax Person Name',
        'tax_person_npwp'=>'Tax Person NPWP',
        'company_npwp'=>'Company NPWP',
        'npwp_date'=>'NPWP Date',
        'bpjstk_number'=>'BPJSTK Number',
        'jkk_type'=>'JKK Type'
      ];
    }
}
