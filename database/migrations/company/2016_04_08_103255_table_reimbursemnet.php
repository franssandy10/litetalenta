<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TableReimbursemnet extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::connection('company')->create('reimbursement_policies', function ($table) {
        $table->bigIncrements('id')->unsigned();
        $table->string('name');
        $table->double('limit',15,2);
        $table->date('effective_date');
        $table->boolean('unlimited_flag')->comment('0 limited,1 unlimited')->default(true);
        $table->softDeletes();
        $table->timestamp('created_date')->default(DB::raw('CURRENT_TIMESTAMP'));
        $table->timestamp('updated_date')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
      });
      Schema::connection('company')->create('reimbursement_request', function ($table) {
        $table->bigIncrements('id')->unsigned();
        $table->bigInteger('employee_id_fk')->unsigned();
        $table->bigInteger('policy_id_fk')->unsigned();
        $table->double('amount',15,2);
        $table->text('attachment');
        $table->text('reason');
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
