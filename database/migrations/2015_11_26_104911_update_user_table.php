<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Models\UserAccessRole;
class UpdateUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('user_access', function ($table) {
          $table->bigInteger('company_id_fk')->unsigned();
          $table->foreign('company_id_fk')->references('id')->on('company')->onDelete('cascade');
        });
        Schema::table('roles',function($table){
          $table->bigInteger('company_id_fk')->unsigned()->nullable();
        });
        $role = Sentinel::getRoleRepository()->createModel()->create([
            'name' => 'Super Admin',
            'slug' => 'superadmin'
        ]);
        $role = Sentinel::getRoleRepository()->createModel()->create([
            'name' => 'Employee',
            'slug' => 'employee'
        ]);
        Artisan::call('db:seed');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::table('roles', function ($table) {
        $table->dropColumn('company_id_fk');
      });

      Schema::table('user_access', function ($table) {
        $table->dropForeign('user_access_company_id_fk_foreign');
        $table->dropColumn('company_id_fk');
      });



    }
}
