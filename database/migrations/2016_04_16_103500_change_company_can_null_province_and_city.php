<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeCompanyCanNullProvinceAndCity extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // task:
        // remove contraint province_id_fk
        // province_id_fk can be null
        // city can be null
        
        Schema::table('company', function ($table) {
            $table->dropForeign('company_province_id_fk_foreign');
            
      });
      Schema::table('company', function ($table) {
            $table->bigInteger('province_id_fk')->nullable()->change();
            $table->string('city')->nullable()->change();
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
