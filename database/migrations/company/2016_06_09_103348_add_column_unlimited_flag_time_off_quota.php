<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnUnlimitedFlagTimeOffQuota extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::connection('company')->table('time_off_quota', function ($table) {
          $table->integer('unlimited_flag')->default(0)->after('created_by')->comment('1: flag if quota is unlimited_flag');
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
