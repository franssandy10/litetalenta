<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReimbursementQuotaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection("company")->create('reimbursement_quota', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->bigInteger('policy_id_fk')->unsigned();
            $table->bigInteger('employee_id_fk')->unsigned();
            $table->double('amount')->nullable(); // can be minus for penalty purposes
            $table->date('effective_date');
            $table->date('expired_date')->nullable(); //set to null for quota which will never expired such as penalty (minus quota)
            $table->bigInteger('created_by')->unsigned();
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
