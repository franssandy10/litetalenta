<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePayrollCutoff extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('payroll_cutoff', function (Blueprint $table) {
          $table->bigIncrements('id')->unsigned();
          $table->integer('attendance_to')->nullable();
          $table->integer('attendance_from')->nullable();
          $table->integer('payroll_to')->nullable();
          $table->integer('payroll_from')->nullable();
          $table->integer('payroll_schedule')->nullable();
          $table->integer('autorun_schedule')->nullable();
          $table->integer('tax_type')->nullable()->comment('1:gross,2:netto');
          $table->integer('salary_config')->nullable()->comment('1:taxable 2:non_taxable');
          $table->integer('company_paid_bpjstk')->nullable()->comment('1:by employee,2 :by company');
          $table->integer('company_paid_bpjsk')->nullable()->commenct('1:by employee,2 :by company');
          $table->integer('company_paid_jp')->nullable()->comment('1:by employee,2 :by company');

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
    }
}
