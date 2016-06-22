<?php

namespace App\Models;

use App\Models\CustomModelCompany;
use Illuminate\Database\Eloquent\SoftDeletes;

class PayrollComponent extends CustomModelCompany
{
   use SoftDeletes;
    //
    protected $fillable=['component_name','component_amount'
      ,'component_type','component_type_occur'
      ,'component_tax_type','prorate_flag','default_flag'];
}
