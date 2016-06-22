<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Models\CompanyRegulation;
class InsertNewCompanyRegulation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      CompanyRegulation::Create(['jkm'=>0.3,'jht_company'=>3.7,'jht_employee'=>2,'bpjsk_company'=>4
      ,'bpjsk_employee'=>1,'jp_employee'=>1,'jp_company'=>2
      ,'commenced_date'=>'2016-05-01','max_salary_jp'=>7335300,'max_salary_bpjsk'=>8000000]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
