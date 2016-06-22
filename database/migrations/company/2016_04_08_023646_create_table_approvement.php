<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableApprovement extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::connection("company")->create('approvement', function (Blueprint $table) {
          $table->bigIncrements('id')->unsigned();
          $table->bigInteger('box_type')->unsigned()->comment('timeoff=2;reimbursement=3;');
          $table->bigInteger('fk_ref')->unsigned()->comment('foreign_key');
          $table->text('reason')->nullable();
          $table->bigInteger('approved_by')->unsigned()->comment('base user_access dengan type super admin');
          $table->integer('approved_flag')->default(0)->comment('flag=0:not yet approved/rejected; flag=1:approved; flag=2:rejected');

          $table->date('approved_date')->nullable();
          $table->bigInteger('position');
          $table->softDeletes();
          $table->timestamp('created_date')->default(DB::raw('CURRENT_TIMESTAMP'));
          $table->timestamp('updated_date')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
          // approved by itu super admin so base on user_access models
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
        Schema::connection('company')->drop('approvement');
    }
}
