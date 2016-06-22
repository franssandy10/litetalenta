<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\CustomModel;
class CompanyRegulationJkk extends CustomModel
{
    //
    protected $table = 'company_regulation_jkk';
    protected $fillable=['company_regulation_jkk','description','jkk','commenced_date'];
}
