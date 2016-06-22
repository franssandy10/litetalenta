<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Company;
use App\Models\TimeoffPolicies;
use App\Models\TimeOffAssign;
use Carbon\Carbon;
class TimeoffAddQuota extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'timeoff:addquota';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add Quota with effective date or the first day of the year';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
      // 1. get list company
      // 2. set config to database base on company
      // 3. get list policies in all company
      // 4. get list assign employee
      // 5. get list employee already has quota
      $listCompany=Company::all();
      foreach($listCompany as $company){
          Config::set('database.connections.company.database',config('app.database_name_company').$companyId);
          $policies=Timeoff::all();
          foreach($policies as $policy){
            $today=Carbon::now()->toDateString();
            $flagRun=false;
            if($today->eq($policy->effective_date)){
              $flagRun=true;
              $employeesHasQuota=TimeOffQuota::where('policy_id_fk',$policy->id)
                // ->where('effective_date',$policy->effective_date)
                ->get(['employee_id_fk'])->toArray();
              $employeesAssign=TimeOffAssign::where('policy_id_fk',$policy->id)->whereNotIn('employee_id_fk',$employeesHasQuota)->get();
              foreach($employeesAssign as $employee){
                $quota = new TimeOffQuota;
                $quota->policy_id_fk = $policy->id;
                $quota->employee_id_fk = $employee->id;
                $quota->amount = $policy->balance;
                $quota->effective_date = $policy->effective_date;
                $quota->expired_date =NULL;
                $quota->created_by = 0;
                $quota->save();
              }
            }
          }
      }

        //
    }
}
