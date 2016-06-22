<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReimbursementTakens extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::connection("company")->create('reimbursement_takens', function (Blueprint $table) {
        $table->bigIncrements('id')->unsigned();
        $table->bigInteger('employee_id_fk')->unsigned()->comment('employee id ');
        $table->bigInteger('request_id_fk')->unsigned()->comment('reimbursement request id ');
        $table->date('date_reimburse');
        $table->double('amount',15,2);
        $table->integer('has_approver')->comment('0: request inputed by admin, without approval; [1-*]: latest user who approve this request');
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
