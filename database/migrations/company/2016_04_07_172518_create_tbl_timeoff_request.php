<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblTimeoffRequest extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::connection("company")->create('time_off_request', function (Blueprint $table) {
          $table->bigIncrements('id')->unsigned();
          $table->bigInteger('employee_id_fk')->unsigned();
          $table->bigInteger('policy_id_fk')->unsigned();
          $table->date('start_date');
          $table->date('end_date');
          $table->text('reason');
          $table->integer('approved_flag')->default(0)->comment('flag=0:not yet approved/rejected; flag=1:approved; flag=2:rejected');
          // $table->bigInteger('approved_by')->unsigned()->nullable();
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
        //
    }
}
