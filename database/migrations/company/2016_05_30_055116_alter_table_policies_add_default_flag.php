<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTablePoliciesAddDefaultFlag extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('time_off_policies', function (Blueprint $table) {
        $table->boolean('default_flag')->default(0)->after('unlimited_flag')->comment('1: default timeoff for new employee');
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
