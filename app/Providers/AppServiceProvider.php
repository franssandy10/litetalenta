<?php

namespace App\Providers;

use Validator;
use Queue;
use App\Models\Company;
use App\Models\UserAccess;
use App\Models\UserAccessRole;
use Illuminate\Support\ServiceProvider;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        Validator::extend('alpha_spaces', 'App\CustomValidator@alphaSpaces');
        Validator::extend('password_validator', 'App\CustomValidator@passwordValidator');
        Validator::extend('current_password', 'App\CustomValidator@checkCurrentPassword');
        Validator::extend('file_type', 'App\CustomValidator@checkFileType');
        Validator::extend('unique_email', 'App\CustomValidator@uniqueEmail');
        Validator::extend('more_than_other_date','App\CustomValidator@moreThanOtherDate');
        Queue::after(function ($connection, $job, $data) {
          // echo 'queue';
       });


    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
    }
}
