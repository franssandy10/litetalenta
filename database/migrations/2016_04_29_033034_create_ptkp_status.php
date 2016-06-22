<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Models\PtkpStatus;
class CreatePtkpStatus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('ptkp_statuses', function (Blueprint $table) {
          $table->bigIncrements('id')->unsigned();
          $table->date('effective_date');
          $table->double('tk0')->nullable();
          $table->double('tk1')->nullable();
          $table->double('tk2')->nullable();
          $table->double('tk3')->nullable();
          $table->double('k0')->nullable();
          $table->double('k1')->nullable();
          $table->double('k2')->nullable();
          $table->double('k3')->nullable();
          $table->timestamp('created_date')->default(DB::raw('CURRENT_TIMESTAMP'));
          $table->timestamp('updated_date')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
      });
      PtkpStatus::firstOrCreate(['effective_date'=>'2010-01-01','tk0'=>24300000,'tk1'=>26325000,'tk2'=>28350000,'tk3'=>30375000
        ,'k0'=>26325000,'k1'=>28350000,'k2'=>30375000,'k3'=>32400000]);
      PtkpStatus::firstOrCreate(['effective_date'=>'2015-07-01','tk0'=>36000000,'tk1'=>39000000,'tk2'=>42000000,'tk3'=>45000000
        ,'k0'=>39000000,'k1'=>42000000,'k2'=>45000000,'k3'=>48000000]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::dropIfExists('ptkp_statuses');

    }
}
