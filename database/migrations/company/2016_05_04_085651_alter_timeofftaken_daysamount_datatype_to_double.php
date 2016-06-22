<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTimeofftakenDaysamountDatatypeToDouble extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::connection('company')->table('time_off_takens', function ($table) {
        $table->dropColumn('days_amount');
        $table->double('day_amount')->default(1)->comment('1 day, half day, etc');
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
