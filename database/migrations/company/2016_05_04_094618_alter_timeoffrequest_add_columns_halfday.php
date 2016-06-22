<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTimeoffrequestAddColumnsHalfday extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::connection('company')->table('time_off_request', function ($table) {
        $table->boolean('half_day')->default(0)->after('end_date')->comment('1 = half day, 0 = bukan');
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
