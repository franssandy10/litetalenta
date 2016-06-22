<?php

use Illuminate\Database\Seeder;
use App\Models\UserAccessRoleStructure;
class EmployeeDataSeeder extends Seeder
{
    /**
     * Run seed for access role structure.
     *
     * @return void
     */
    public function run()
    {
        //
        $role = Sentinel::findRoleBySlug('employee');

       $role->permissions = [];

       $role->save();
    }
}
