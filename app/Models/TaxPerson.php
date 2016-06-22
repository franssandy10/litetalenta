<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Auth;
use Config;
use Validator;
use App\Models\CustomModelCompany;
class TaxPerson extends CustomModelCompany
{
  /**
   * INPUT that required
   * tax_person_name
   * npwp_number
   * company_npwp
   * bpjstk_number
   * jkk_type
   */
  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'tax_person';
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = ['branch_id','tax_person_name','npwp_date','tax_person_npwp','company_npwp','bpjstk_number','jkk_type'];

}
