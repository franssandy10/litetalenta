<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAttendancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::connection("company")->create('attendances', function (Blueprint $table) {
        $table->bigIncrements('id')->unsigned();
        $table->date('date');
        $table->bigInteger('employee_id_fk')->unsigned()->comment('employee id ');
        $table->string('checked_in_at')->nullable();
        $table->string('checked_out_at')->nullable();
        $table->integer('late_in')->nullable();
        $table->integer('late_out')->nullable();
        $table->integer('early_in')->nullable();
        $table->integer('early_out')->nullable();
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
        Schema::drop('attendances');
    }
}
