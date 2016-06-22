<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Models\CompanyRegulation;
use App\Models\CompanyRegulationJkk;
class CreateCompanyRegulation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('company_regulation', function (Blueprint $table) {
          $table->bigIncrements('id')->unsigned();
          $table->date('effective_date');
          $table->double('jkm',15,2)->nullable();
          $table->double('jht_company',15,2)->nullable();
          $table->double('jht_employee',15,2)->nullable();
          $table->double('bpjsk_company',15,2)->nullable();
          $table->double('bpjsk_employee',15,2)->nullable();
          $table->double('jp_employee',15,2)->nullable();
          $table->double('jp_company',15,2)->nullable();
          $table->double('max_salary_jp',15,2)->nullable();
          $table->double('max_salary_bpjsk',15,2)->nullable();
          $table->date('commenced_date')->nullable();
          $table->date('expired_date')->nullable();
          $table->timestamp('created_date')->default(DB::raw('CURRENT_TIMESTAMP'));
          $table->timestamp('updated_date')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));

      });
      Schema::create('company_regulation_jkk', function (Blueprint $table) {
          $table->bigIncrements('id')->unsigned();
          $table->string('description')->nullable();
          $table->double('jkk',15,2)->nullable();
          $table->date('commenced_date')->nullable();
          $table->timestamp('created_date')->default(DB::raw('CURRENT_TIMESTAMP'));
          $table->timestamp('updated_date')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));

      });
      CompanyRegulation::Create(['jkm'=>0.3,'jht_company'=>3.7,'jht_employee'=>2,'bpjsk_company'=>4
      ,'bpjsk_employee'=>0.5,'jp_employee'=>0,'jp_company'=>0
      ,'commenced_date'=>'2013-01-01','max_salary_jp'=>7000000,'max_salary_bpjsk'=>4725000]);
      CompanyRegulation::Create(['jkm'=>0.3,'jht_company'=>3.7,'jht_employee'=>2,'bpjsk_company'=>4
      ,'bpjsk_employee'=>1,'jp_employee'=>1,'jp_company'=>2
      ,'commenced_date'=>'2015-07-01','max_salary_jp'=>7000000,'max_salary_bpjsk'=>4725000]);
      CompanyRegulation::Create(['jkm'=>0.3,'jht_company'=>3.7,'jht_employee'=>2,'bpjsk_company'=>4
      ,'bpjsk_employee'=>1,'jp_employee'=>1,'jp_company'=>2
      ,'commenced_date'=>'2016-03-01','max_salary_jp'=>7335300,'max_salary_bpjsk'=>4725000]);
      CompanyRegulationJkk::Create(['description'=>'1','jkk'=>0.24,'commenced_date'=>'2013-01-01']);
      CompanyRegulationJkk::Create(['description'=>'2','jkk'=>0.54,'commenced_date'=>'2013-01-01']);
      CompanyRegulationJkk::Create(['description'=>'3','jkk'=>0.89,'commenced_date'=>'2013-01-01']);
      CompanyRegulationJkk::Create(['description'=>'4','jkk'=>1.27,'commenced_date'=>'2013-01-01']);
      CompanyRegulationJkk::Create(['description'=>'5','jkk'=>1.74,'commenced_date'=>'2013-01-01']);



    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::dropIfExists('company_regulation');
      Schema::dropIfExists('company_regulation_jkk');

    }
}
