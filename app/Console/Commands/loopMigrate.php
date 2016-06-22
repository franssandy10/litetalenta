<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Company;
use Artisan;
class loopMigrate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'company:loopmigrate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'test Loop';

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
      $result=Company::all();
      foreach($result as $model){print_r('sadfsadf');
        Artisan::queue('company:migrate', ['company_id'=>$model->id]);

      }
    }
}
