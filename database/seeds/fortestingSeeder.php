<?php

use Illuminate\Database\Seeder;
use App\Models\Company;
use App\Models\User;
use App\Models\UserAccessConnection;
use App\Models\TimeOffPolicies;
use App\Models\TaxPerson;
use App\Models\Employee;
use App\Http\Controllers\DatabaseController;
use Carbon\Carbon;
use App\Models\EmployeeSalaryHistory;
class fortestingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $company=Company::create([
        'name'=>'Admin Company',
        'email'=>'vald.karate@gmail.com',
        'phone'=>'78903456'
      ]);
      echo 'testing';
      $admin =Sentinel::registerAndActivate( [

        'name'=>'Admin Testing 1',
        'email'    => 'vald.karate@gmail.com',
        'password' => 'testing123',
        'phone'=>'1234567890',
        'company_id_fk'=>$company->id
      ]);

      // ketika insert massnya cuman 1 input lebih bagus dijadikan seperti ini
      $model=new UserAccessConnection();
      $model->user_access_id_fk=$admin->id;
      $model->company_id_fk=$company->id;
      $model->save();
      // Sentinel::login($result);
      $role = Sentinel::findRoleBySlug('superadmin');
      $role->users()->attach($admin);

      (new DatabaseController)->create($company->id);
      // Login

      // Login
      echo 'after database';
      // for set connection for company
      Config::set('database.connections.company.database',Config::get('app.database_name_company').$company->id);
      echo 'set database';
      // insert initial holiday and sick
      $model=new TimeoffPolicies(false,$company->id);
      $model->name="Holiday";
      $model->balance='12';
      $model->effective_date=Carbon::now();
      $model->unlimited_flag=false;
      $model->policy_code='AL';
      $model->save();
      echo ' set time off';
      $model=new TimeoffPolicies(false,$company->id);
      $model->name="Sick";
      $model->balance='12';
      $model->effective_date=Carbon::now();
      $model->unlimited_flag=false;
      $model->policy_code='SL';
      $model->save();
      $model=new TaxPerson(false,$company->id);
      $model->branch_id=NULL;
      $model->tax_person_name='testing 123';
      $model->tax_person_npwp='npwp tax person';
      $model->company_npwp='1234567890';
      $model->bpjstk_number='0987654321';
      $model->jkk_type='tk0';
      $model->npwp_date=Carbon::now();
      $model->save();
      $model=new Employee(false,$company->id);
      $model->first_name='Testing';
      $model->last_name='Test 2';
      $model->employee_id='TDI001';
      $model->email='testing@admincompany.com';
      $model->identity_type='ktp';
      $model->identity_number='123456789';
      $model->identity_expired_date='2002-20-02';
      $model->save();

      $modelSalary=new EmployeeSalaryHistory(false,$company->id);
      $modelSalary->old_salary=0;
      $modelSalary->new_salary=12000000;
      $modelSalary->effective_date=Carbon::now();
      $modelSalary->employee_id_fk=$model->id;
      $modelSalary->save();
      $modelConnection=new UserAccessConnection();
      $modelConnection->employee_id_fk=$model->id;
      $modelConnection->company_id_fk=$company->id;
      $modelConnection->save();
      $model=new Employee(false,$company->id);
      $model->first_name='Testing 3';
      $model->last_name='Test 4';
      $model->employee_id='TDI001';
      $model->email='testing2@admincompany.com';
      $model->identity_type='passport';
      $model->identity_number='1234567890';
      $model->identity_expired_date='2002-02-28';
      $model->save();
      $modelSalary=new EmployeeSalaryHistory(false,$company->id);
      $modelSalary->old_salary=0;
      $modelSalary->new_salary=10000000;
      $modelSalary->effective_date=Carbon::now();
      $modelSalary->employee_id_fk=$model->id;
      $modelSalary->save();
      $modelConnection=new UserAccessConnection();
      $modelConnection->employee_id_fk=$model->id;
      $modelConnection->company_id_fk=$company->id;
      $modelConnection->save();

    }
}
