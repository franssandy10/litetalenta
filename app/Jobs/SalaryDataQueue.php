<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\EmployeePayroll;
use App\Events\PayrollDataEvent;
use Redis;
use Illuminate\Support\Collection;
use Sentinel;

class SalaryDataQueue extends Job implements SelfHandling,ShouldQueue
{
  protected $data;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
      $this->user_access=sha1(Sentinel::getUser()->id);

      //
      $users=EmployeePayroll::all();
      $salaryDetail=[];
      $salaryDetail[]=[
        'employee_id'       => 'Employee ID',
        'full_name'         => 'Full Name',
        'job_title'         => 'Job Title',
        'basic_salary'      => 'Basic Salary',


      ];
      foreach($users as $data){
        $temp=[];
        $temp['employee_id']=$data->employeeDetail->employee_id;
        $temp['full_name']=$data->employeeDetail->first_name." ".$data->employeeDetail->last_name;
        $temp['job_title']="";
        $temp['salary']=$data['basic_salary'];

        $salaryDetail[]=$temp;
      }
      $this->data=$salaryDetail;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
      //STEP
      //1.Get All Employee
      //2.Get All Employee Salary
      //3.Get All Employee Deduction
      //4.Get All Employee Allowance
      foreach($this->data as $employee){

        // event(new PayrollDataEvent($employee));
        Redis::publish('salary', json_encode(['employee'=>$employee,'user_access'=>$this->user_access]));
      }
      // event(new \App\Events\EventName());
      // foreach($listEmployee as $employee){
      //   echo $employee;
      //   // event(new PayrollDataEvent($employee));
      // }

    }
}
