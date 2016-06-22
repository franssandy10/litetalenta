<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
                $table->string('subject');
                $table->longText('message');
                $table->bigInteger('sender_id_fk')->unsigned();
                $table->bigInteger('receiver_id_fk')->unsigned();
                $table->string('attachment')->nullable();
                $table->integer('box_type');
                $table->boolean('is_read');
                $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
//TODO ilangin updated_at
                $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP'));
                // $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
                $table->timestamp('deleted_at_sender')->nullable();
                $table->timestamp('deleted_at_receiver')->nullable();
                $table->foreign('sender_id_fk')->references('id')->on('user_access'); //->onDelete('cascade');
                $table->foreign('receiver_id_fk')->references('id')->on('user_access'); //->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('messages');
    }
}
