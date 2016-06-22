<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterReimbursementRequestAddColumnApprovedFlag extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::connection('company')->table('reimbursement_request', function ($table) {
        $table->integer('approved_flag')->default(0)->after('reason')->comment('flag=0:not yet approved/rejected; flag=1:approved; flag=2:rejected');
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
