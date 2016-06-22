<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Config;
use App\Models\Company;
class CreateEmployeeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

          Schema::connection("company")->create('employee', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('employee_id');
            $table->string('avatar')->nullable();
            $table->string('email');
            $table->string('identity_type')->comment('ktp or passport')->nullable();
            $table->string('identity_number');
            $table->date('identity_expired_date');
            $table->string('postal_code')->nullable();
            $table->text('address')->nullable();
            $table->string('place_of_birth')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('mobile_phone')->nullable();
            $table->string('phone')->nullable();
            $table->integer('gender')->comment('1:male or 2:female')->nullable();
            $table->integer('marital_status')->default(1);
            $table->integer('blood_type')->default(1);
            $table->integer('religion')->default(1);
            $table->bigInteger('department_id_fk')->nullable();
            $table->bigInteger('job_position_id_fk')->nullable();
            $table->bigInteger('employment_status')->default(1);
            $table->date('join_date')->nullable();
            $table->date('end_probation_date')->nullable();
            $table->date('end_contract_date')->nullable();
            $table->string('npwp_number')->nullable();
            $table->string('tax_status')->comment('tk0,tk1,tk2,tk3,k0,k1,k2,k3')->nullable();
            $table->bigInteger('bank_id')->nullable();
            $table->string('bank_account')->nullable();
            $table->string('bank_holder')->nullable();
            $table->string('bpjstk_number')->nullable();
            $table->string('bpjsk_number')->nullable();
            $table->string('tax_config')->comment('gross,net')->nullable();
            $table->string('salary_config')->comment('taxable,non_taxable')->nullable();
            $table->string('salary_type')->comment('monthly,daily')->nullable();
            $table->boolean('company_paid')->default(false);
            $table->integer('employment_tax_status')->default(1);
            $table->timestamp('created_date')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_date')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
          });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::connection("company")->dropIfExists('employee');
    }
}
