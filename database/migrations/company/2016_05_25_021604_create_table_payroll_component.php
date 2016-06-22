<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablePayrollComponent extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      // set component policies
      Schema::create('payroll_components', function (Blueprint $table) {
          $table->bigIncrements('id')->unsigned();
          $table->string('component_name');
          $table->integer('component_type')->comment('1:allowance,2:deduction');
          $table->integer('component_type_occur')->comment('1:daily,2:monthly,3:one-time');
          $table->double('component_amount');
          $table->integer('component_tax_type')->comment('1:taxable,2:non_taxable');
          $table->integer('prorate_flag')->comment('can be prorate if set in middle of month');
          $table->integer('default_flag')->comment('set if have new employee');

          $table->timestamp('created_date')->default(DB::raw('CURRENT_TIMESTAMP'));
          $table->timestamp('updated_date')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));

      });
      // attach component to employee
      Schema::create('payroll_component_employees', function (Blueprint $table) {
          $table->bigIncrements('id')->unsigned();
          $table->bigInteger('component_id_fk')->unsigned();
          $table->bigInteger('employee_id_fk')->unsigned();
          $table->double('component_amount');
          $table->bigInteger('transaction_id_fk')->nullable();
          $table->timestamp('created_date')->default(DB::raw('CURRENT_TIMESTAMP'));
          $table->timestamp('updated_date')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
      });
      // for run payroll
      Schema::create('payroll_component_employee_payrolls', function (Blueprint $table) {
          $table->bigIncrements('id')->unsigned();
          $table->bigInteger('component_id_fk')->unsigned();
          $table->bigInteger('employee_id_fk')->unsigned();
          $table->double('component_amount');
          $table->integer('month_process');
          $table->integer('year_process');
          $table->date('cutoff_to');
          $table->date('cutoff_from');
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
      Schema::dropIfExists('payroll_components');
      Schema::dropIfExists('payroll_component_employees');
      Schema::dropIfExists('payroll_component_employee_payrolls');

    }
}
