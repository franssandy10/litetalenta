<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\Employee;
use App\Events\PayrollDataEvent;
use Redis;
use Illuminate\Support\Collection;
use Sentinel;
use Carbon\Carbon;
use App\Models\EmployeePayroll;
use App\Models\PayrollComponent;
use App\Models\PayrollComponentEmployee;
use Constant;
class PayrollDataQueue extends Job implements SelfHandling,ShouldQueue
{
  use InteractsWithQueue, SerializesModels;
  protected $data;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
        $this->user_access=sha1(Sentinel::getUser()->id.'payroll');

        // $users = new Collection;
        // $allowance = new Collection;
        // $deduction = new Collection;
        //
        // $faker = \Faker\Factory::create();
        //
        // $allowance->push ([
        //   'Tunjangan A'   => 200000,
        //   'Tunjangan B'   => 500000,
        //   'Tunjangan C'   => 300000,
        // ]);
        //
        // $deduction->push ([
        //   'Potongan A'   => 200000,
        //   'Potongan B'   => 500000,
        //   'Potongan C'   => 300000,
        // ]);
        //
        // //UNTUK TEST PAGE RUN PAYROLL
        // for ($i = 0; $i < 100; $i++) {
        //   if ($i == 0) {
        //     $users->push([
        //       'employee_id'       => 'Employee ID',
        //       'full_name'         => 'Full Name',
        //       'job_title'         => 'Job Title',
        //       'basic_salary'      => 'Basic Salary',
        //       'total_allowance'   => 'Total Allowance',
        //       'total_deduction'   => 'Total Deduction'
        //     ]);
        //   }
        //   else {
        //     $users->push([
        //         'employee_id'       => 'TDI-A' . $i . ' a',
        //         'full_name'         => $faker->name . ' b',
        //         'job_title'         => $faker->streetName . ' c',
        //         'basic_salary'      => number_format($faker->numberBetween($min = 1000000, $max = 9000000)) . ' d',
        //         'total_allowance'   => number_format($faker->numberBetween($min = 100000, $max = 1000000)) . ' e',
        //         'allowance'         => $allowance,
        //         'total_deduction'   => number_format($faker->numberBetween($min = 100000, $max = 1000000)) . ' f',
        //         'deduction'         => $deduction
        //     ]);
        //   }
        // }
        $dataPayroll=[];
        $dataPayroll[]=[
          'employee_details'          => 'Employee Details',
          'basic_salary'              => 'Basic Salary',
          // 'approved_overtime'         => 'Approved Overtime',
          'total_allowance'           => 'Total Allowance',
          'total_deduction'           => 'Total Deduction',
          'total_pay'                 => 'Total Pay'
        ];
        $users=Employee::all();
        $listcomponentAllowance = PayrollComponent::where('component_type', Constant::COMP_TYPE_ALLOWANCE)->where('component_type_occur', Constant::COMP_TYPE_OCCUR_MONTHLY)->get(['id'])->toArray();
        $listcomponentDeduction = PayrollComponent::where('component_type', Constant::COMP_TYPE_DEDUCTION)->where('component_type_occur', Constant::COMP_TYPE_OCCUR_MONTHLY)->get(['id'])->toArray();
        foreach ($users as $data) {
          if($data->getCurrentSalary() != null) {
            $temp=[];
            $temp['employee_id']=$data['id'];
            $temp['employee_details']='<p class="truncate bold">' . $data['first_name']." ".$data['last_name'] . '</p><p>' . $data['employee_id'] . '</p><p>' . $data['employee_id'] . '</p>' ;
            $temp['basic_salary']=$data->getCurrentSalary()->new_salary;
            // $temp['approved_overtime']=0;
            $temp['total_allowance']=$this->calculateAllowance($temp['employee_id'], $listcomponentAllowance);
            $temp['total_deduction']=$this->calculateDeduction($temp['employee_id'], $listcomponentDeduction);
            $temp['total_pay']=$this->calculateTotalPay($temp);
            $dataPayroll[]=$temp;
          }
        }
        $this->data=$dataPayroll;
        echo 'boot';
    }
    public function calculateDeduction($employee_id, $list_componentdeduction){
      return PayrollComponentEmployee::getDeductionEmployee($employee_id, $list_componentdeduction); //3 get taxable and nontaxable
    }
    public function calculateAllowance($employee_id, $list_componentallowance){
      return PayrollComponentEmployee::getAllowanceEmployee($employee_id, $list_componentallowance);//3 get taxable and nontaxable
    }
    public function calculateTotalPay($data){
      $total=$data['basic_salary']+$data['total_allowance']-$data['total_deduction'];
      return $total;
    }
    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
      echo $this->user_access;
        //STEP
        //1.Get All Employee
        //2.Get All Employee Salary
        //3.Get All Employee Deduction
        //4.Get All Employee Allowance
        foreach($this->data as $employee){
          print_r($employee);
          // event(new PayrollDataEvent($employee));
          Redis::publish('payroll', json_encode(['employee'=>$employee,'user_access'=>$this->user_access]));
        }
        // event(new \App\Events\EventName());
        // foreach($listEmployee as $employee){
        //   echo $employee;
        //   // event(new PayrollDataEvent($employee));
        // }

    }

}
