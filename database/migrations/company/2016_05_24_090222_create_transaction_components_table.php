<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionComponentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection("company")->create('transaction_components', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->string('transaction_id');
            $table->bigInteger('type_transaction');
            $table->string('changes');
            $table->date('effective_date');
            $table->timestamp('created_date')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_date')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
        });

        Schema::connection('company')->table('employee_salary_history', function ($table) {
            $table->bigInteger('transaction_id_fk')->nullable()->after('employee_id_fk');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('transaction_components');
    }
}
