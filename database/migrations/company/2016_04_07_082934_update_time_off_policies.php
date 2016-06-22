<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateTimeOffPolicies extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::connection('company')->table('time_off_policies', function ($table) {
          $table->string('policy_code')->after('id');
          $table->boolean('unlimited_flag')->after('effective_date')->comment('0 limited,1 unlimited')->default(true);
          $table->softDeletes()->after('updated_date');
          $table->dropColumn('renew_flag');
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
