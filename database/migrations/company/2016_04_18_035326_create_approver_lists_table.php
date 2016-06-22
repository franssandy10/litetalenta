<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApproverListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('company')->create('approver_lists', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('policy_type')->unsigned()->comment('2: timeoff; 3:reimbursement');
            $table->bigInteger('policy_id_fk')->unsigned();
            $table->bigInteger('approver_id_fk')->unsigned()->comment('user_access foreign_key');
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
        Schema::drop('approval_lists');
    }
}
