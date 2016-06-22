<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Models\Company;

class EmployeePayroll extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::connection("company")->create('employee_payroll', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->bigInteger('employee_id_fk')->unsigned();
            $table->double('basic_salary')->default(0);
            $table->double('full_salary');
            $table->date('cutoff_to');
            $table->date('cutoff_from');
            $table->integer('month_process');
            $table->integer('year_process');
            $table->double('takehomepay');
            $table->double('allowance_taxable');
            $table->double('allowance_nontaxable');
            $table->double('deduction_taxable');
            $table->double('deduction_nontaxable');
            $table->double('jkk');
            $table->double('jkm');
            $table->double('jht_employee');
            $table->double('jht_company');
            $table->double('jp_company');
            $table->double('jp_employee');
            $table->double('bpjsk_employee');
            $table->double('bpjsk_company');
            $table->double('gross_monthly');
            $table->double('gross_yearly');
            $table->double('position_cost');
            $table->double('jht_employee_yearly');
            $table->double('jp_employee_yearly');
            $table->double('netto_yearly');
            $table->double('ptkp');
            $table->double('pkp');
            $table->double('pph_yearly');
            $table->double('pph_monthly');
            $table->timestamp('created_date')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_date')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
            $table->foreign('employee_id_fk')->references('id')->on('employee')->onDelete('cascade');

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
        Schema::connection("company")->dropIfExists('employee_payroll');

    }
}
