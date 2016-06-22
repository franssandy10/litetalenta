<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableSalaryHistory extends Migration
{
  public function up()
  {

        Schema::connection("company")->create('employee_salary_history', function (Blueprint $table) {
          $table->bigIncrements('id')->unsigned();
          $table->bigInteger('employee_id_fk')->unsigned();
          $table->double('old_salary')->default(0);
          $table->double('new_salary');
          $table->date('effective_date');
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
      Schema::connection("company")->dropIfExists('employee_salary_history');
  }
}
