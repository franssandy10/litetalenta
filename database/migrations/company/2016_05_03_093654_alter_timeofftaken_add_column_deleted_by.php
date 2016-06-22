<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTimeofftakenAddColumnDeletedBy extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::connection('company')->table('time_off_takens', function ($table) {
        $table->bigInteger('deleted_by')
            ->unsigned()->nullable()
            ->after('deleted_at')
            ->comment('happens when a user change time off value in attendance');
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
