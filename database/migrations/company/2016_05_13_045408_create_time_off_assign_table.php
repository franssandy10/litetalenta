<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTimeOffAssignTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection("company")->create('time_off_assign', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->bigInteger('policy_id_fk')->unsigned();
            $table->bigInteger('employee_id_fk')->unsigned();
            $table->string('assign_date');
            $table->string('expired_date');
            $table->timestamp('created_date')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_date')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('time_off_assign');
    }
}
