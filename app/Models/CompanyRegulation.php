<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\CustomModel;
class CompanyRegulation extends CustomModel
{

  protected $table = 'company_regulation';
  protected $fillable=['jkm','jht_company','jht_employee','bpjsk_company','bpjsk_employee','jp_employee','jp_company','commenced_date','expired_date','max_salary_jp','max_salary_bpjsk'];
}
