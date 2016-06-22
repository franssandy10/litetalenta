<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableConnectionUserAccessWithEmployee extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_access_connection', function (Blueprint $table) {
          $table->bigIncrements('id')->unsigned();
          $table->bigInteger('employee_id_fk')->unsigned()->nullable();
          $table->bigInteger('user_access_id_fk')->unsigned()->nullable();
          $table->bigInteger('company_id_fk')->unsigned();
          $table->string('avatar')->nullable();
          $table->foreign('company_id_fk')->references('id')->on('company')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_access_connection');

    }
}
