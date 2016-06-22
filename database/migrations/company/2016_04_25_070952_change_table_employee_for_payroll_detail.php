<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeTableEmployeeForPayrollDetail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::connection('company')->table('employee', function ($table) {
        $table->date('npwp_date')->nullable()->comment('tanggal npwp')->after('npwp_number');
        $table->integer('employment_tax_status')->comment('employee tax status')->nullable()->change();

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
