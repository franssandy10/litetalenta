<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUnlimitedflagToReimburstmentPolicies extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    protected $table = 'reimbursement_policies';
    
    public function up()
    {
        Schema::connection('company')->table('reimbursement_policies', function ($table) {
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
