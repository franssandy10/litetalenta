<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableAccessToken extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('access_token', function (Blueprint $table) {
          $table->bigIncrements('id')->unsigned();
          $table->bigInteger('user_access_id_fk')->unsigned();
          $table->string('code');
          $table->bigInteger('type_access')->unsigned();
          $table->bigInteger('type_ref')->unsigned();
          $table->bigInteger('fk_ref')->unsigned();
          $table->boolean('completed')->default(0);
          $table->timestamp('completed_at')->nullable();
          $table->timestamp('expired_at')->nullable();
          $table->timestamp('created_date')->default(DB::raw('CURRENT_TIMESTAMP'));
          $table->timestamp('updated_date')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
          $table->foreign('user_access_id_fk')->references('id')->on('user_access')->onDelete('cascade');

      });
        //
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::dropIfExists('access_token');

    }
}
