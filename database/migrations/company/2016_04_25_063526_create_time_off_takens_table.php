<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTimeOffTakensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection("company")->create('time_off_takens', function (Blueprint $table) {
          $table->bigIncrements('id')->unsigned();
          $table->bigInteger('fk_ref')->unsigned();
          $table->bigInteger('employee_id_fk')->unsigned();
          $table->bigInteger('policy_id_fk')->unsigned();
          $table->date('date'); // timeoff date
          $table->bigInteger('days_amount'); // 1 day, half day, etc
          $table->integer('has_approver')->default(1)->comment('1: user request langsung ; 0: inputed by admin, without approval');
          $table->softDeletes();
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
        Schema::drop('time_off_takens');
    }
}
