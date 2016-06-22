<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUnimitedFlagToReimbursementQuota extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('company')->table('reimbursement_quota', function (Blueprint $table) {
            $table->boolean('unlimited_flag')->default(0)->after('amount')->comment('1: unlimited');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('company')->table('reimbursement_quota', function (Blueprint $table) {
            //
        });
    }
}
