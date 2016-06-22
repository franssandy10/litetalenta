<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('province', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->string('name');
            $table->double('amount');
            $table->date('effective_date');
            $table->timestamp('created_date')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_date')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));

        });
        Schema::create('city', function (Blueprint $table) {
          $table->bigIncrements('id')->unsigned();
          $table->string('province');
          $table->string('name');
          $table->double('amount');
          $table->date('effective_date');
          $table->timestamp('created_date')->default(DB::raw('CURRENT_TIMESTAMP'));
          $table->timestamp('updated_date')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));

        });
        Schema::create('company', function (Blueprint $table) {
          $table->bigIncrements('id')->unsigned();
          $table->string('name');
          $table->string('email');
          $table->text('address');
          $table->string('phone');
          $table->string('postcode');
          $table->bigInteger('province_id_fk')->unsigned();
          $table->string('city');
          $table->string('token')->index();
          $table->timestamp('created_date')->default(DB::raw('CURRENT_TIMESTAMP'));
          $table->timestamp('updated_date')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
          $table->foreign('province_id_fk')->references('id')->on('province')->onDelete('cascade');

        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::dropIfExists('company');
      Schema::dropIfExists('province');
      Schema::dropIfExists('city');




    }
}
