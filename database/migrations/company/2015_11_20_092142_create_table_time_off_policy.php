<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableTimeOffPolicy extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::connection("company")->create('time_off_policies', function (Blueprint $table) {
          $table->bigIncrements('id')->unsigned();
          $table->string('name');
          $table->double('balance',15,2);
          $table->date('effective_date');
          $table->boolean('renew_flag');
          $table->timestamp('created_date')->default(DB::raw('CURRENT_TIMESTAMP'));
          $table->timestamp('updated_date')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));

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
          Schema::connection("company")->dropIfExists('time_off_policies');
    }
}
