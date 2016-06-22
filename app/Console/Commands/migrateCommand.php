<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Company;
use Config;
use Artisan;



class migrateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'company:migrate{company_id} ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        //
        // $result=Company::all();
        // foreach($result as $model){
        $companyId = $this->argument('company_id');
        Config::set('database.connections.company.database',config('app.database_name_company').$companyId);

        Artisan::call('migrate', [
          '--path'     => "database/migrations/company",
          '--database' => "company"
        ]);

        // }
    }
}
