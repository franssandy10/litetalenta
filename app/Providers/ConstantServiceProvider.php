<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ConstantServiceProvider extends ServiceProvider
{
  const BOX_TYPE_TIMEOFF=2;
  const BOX_TYPE_REIMBURSEMENT=3;
  const TYPE_REF_REQUEST=1;
  const TYPE_REF_VIEW=2;

  const COMP_TYPE_ALLOWANCE=1;
  const COMP_TYPE_DEDUCTION=2;

  const COMP_TYPE_TAXABLE=1;
  const COMP_TYPE_NONTAXABLE=2;
  const COMP_TYPE_ALLTAXTYPE=3;

  const COMP_TYPE_OCCUR_MONTHLY=1;

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
