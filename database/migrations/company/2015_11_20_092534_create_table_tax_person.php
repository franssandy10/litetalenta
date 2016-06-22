<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableTaxPerson extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::connection("company")->create('tax_person', function (Blueprint $table) {
          $table->bigIncrements('id')->unsigned();
          $table->bigInteger('branch_id')->unsigned()->nullable();
          $table->string('tax_person_name');
          $table->string('tax_person_npwp');
          $table->string('company_npwp');
          $table->date('npwp_date');
          $table->string('bpjstk_number');
          $table->integer('jkk_type');
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
        Schema::connection("company")->dropIfExists('tax_person');
    }
}
