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
use App\Models\PtkpStatus;
use App\Models\CompanyRegulation;
use App\Models\CompanyRegulationJkk;
use App\Models\TaxPerson;
use App\Models\PayrollComponent;
use App\Models\PayrollComponentEmployee;
use Constant;
use BaseService;
use Illuminate\Http\Request;
use App\Models\PayrollCutoff;
class ProcessPayrollQueue extends Job implements SelfHandling,ShouldQueue
{
    protected $employeeData;
    // perhitungan payroll karyawan
    // 1. Penghasilan bruto per bulan = basic_salary+jkk+jkm+bpjsKcompany+ allowance_taxable -deduction_taxable (if they are used)
    // 2. penghasilan bruto per tahun = bruto_per_bulan* service_join
    // 4. penghasilan jp employee per tahun= jp_employee*basic_salary*service_join
    // 5. penghasilan jht employee per tahun=jht_employee*basic_salary*service_join
    // 6. penghasilan netto per tahun= bruto_per_tahun - jp_employee_per_tahun - jp_employee_yearley - position_cost_per_tahun
    // 7. pkp=netto tahunan - ptkp
    // 8. pph Yearly= trgantung dari nilai pkp -> liat rumus pph calculate
    // 9. pph monthly= pphyearly/service_join
    /**
     * Length Of Service
     * @param integer $process_year, $process_year, $cutoff_payroll_to
     * @param date $join_date
     * @return years, months, endDate
     */
    public function lengthOfService($data)
    {

        $datePayrollTo          = date('Y-m-d',strtotime($data['process_year'].'-'.$data['process_month'].'-'.$data['day_end']));
        $lengthOfService  = BaseService::dateDifference($data['join_date'], $datePayrollTo);
        $tempDate         = explode(' ',$lengthOfService);

        $years  = intval($tempDate[0]);
        $months = intval($tempDate[2]);
        $days   = intval($tempDate[4]);

        $lastDay = cal_days_in_month(CAL_GREGORIAN, $data['process_month'], $data['process_year']);
        if($days == $lastDay)
        {
            $months = intval($tempDate[2]+1);
        }

        return array(
            'years'     => $years,
            'months'    => $months,
            'end_date'   => $datePayrollTo,
        );
    }
    /**
     * Service
     * @param in array
     * @param $periodYear (process year), $periodMonth (process month), $cutOffPayrollTo
     * @param date $joinDate,$years
     * @param $npwpDateCompany
     * @param $periodStart
     * @param $periodEnd
     *
     * @return Duration Service
     */
    public function service($data)
    {
      // get npwp date company
      $npwpDateCompany=$data['npwp_date_company'];
      // join date
      $joinDate=$data['join_date'];
      // payrollSchedule
      $payrollSchedule=$data['payroll_schedule'];
      $payrollCutOffTo=$data['day_end'];
      $payrollCutOffFrom=$data['day_start'];
      $processYear=$data['process_year'];
      $processMonth=$data['process_month'];
      // set join date jika npwpDateCompany lebih besar dari join date
      if($npwpDateCompany!=NULL){
        if(date('Y-m-d',strtotime($npwpDateCompany)) > date('Y-m-d',strtotime($joinDate)))
        {
            $joinDate = $npwpDateCompany;
        }
      }
      // get cutoff to period
      $cutoffToPayrollDate    = date('Y-m-d',strtotime($processYear.'-'.$processMonth.'-'.$payrollCutOffTo));

      $lengthOfService  = BaseService::dateDifference($joinDate, $cutoffToPayrollDate);
      $tempDate         = explode(' ',$lengthOfService);

      //GET LENGTH OF SERVICE
      $service = 12;
      if(date('Y',strtotime($joinDate)) == $processYear)
      {
          if($data['years'] == 0)
          {
              $rangeCutOff = abs($payrollCutOffFrom - $payrollCutOffTo);
              $dayJoin     = intval(date('d',strtotime($joinDate)));
              $monthJoin   = intval(date('m',strtotime($joinDate)));
              if($payrollCutOffFrom > $payrollCutOffTo || $rangeCutOff < 5)
              {
                  if(date('m',strtotime($joinDate)) < $processMonth && date('d',strtotime($joinDate)) > $payrollCutOffTo)
                  {
                      $monthJoin = $monthJoin + 1;
                  }
              }

              $service        = intval(12 - $monthJoin + 1);

              $proccessDate   = intval($payrollSchedule);

              $processDate = date('Y-m-d',strtotime($processYear.'-'.$monthJoin.'-'.$proccessDate));
              if($processDate > $cutoffToPayrollDate)
              {
                  $date = date_create($processDate);
                  date_sub($date, date_interval_create_from_date_string('1 months'));
                  $processDate = $date->format('Y-m-d');
              }

              if($joinDate > $processDate)
              {
                  $service = $service - 1;
              }
          }
      }

      return $service;
    }

    /**
     * Create a new job instance.
     *
     * @return void
     */
    /**
     * [__construct Calculate Gaji And Tax]
     * @input employee with basic salary
     * @input jkk_type to calculate jkkReguler (if have bpjstk company)
     * @input jkm to calculate jkm (if have bpjstk company)
     * @input jht to calculate JHT (if have bpjstk company)
     * @input jaminan pensiun to calculate  jaminan pensiun
     * @input bpjsk to calculate bpjsk_company and bpjsk_employee
     * @input
     */
    public function __construct()
    {
      $company=Sentinel::getUser()->userCompany;
      $taxPerson=TaxPerson::find(1);
       // get list ptkp for taxing
         // get payroll cutoff from and to;
      $cutoffPayrollFrom=1;
      $cutoffPayrollTo=31;
      $cutoff=PayrollCutoff::first();

      // get payroll schedule
      $param['payroll_schedule']=25;
      if($cutoff){
        $cutoffPayrollFrom=$cutoff->payroll_from;

        $cutoffPayrollTo=$cutoff->payroll_to;
      }

        // data for run payroll
        // get employee
        $employees=Employee::all();
        // get company
        // get period
        $period=$this->getPeriodPayroll($cutoffPayrollFrom,$cutoffPayrollTo);
        // get regulation
        $listCompanyRegulation=CompanyRegulation::where('commenced_date','<',$period['end'])->orderBy('commenced_date','DESC')->first();
        // get regulation jkk
        $jkkArray=CompanyRegulationJkk::where('description',"".$taxPerson->jkk_type)->orderBy('commenced_date','DESC')->first();
        $jkk=$jkkArray->jkk;
        // get month and year process
        $dateProcess=session('payrolldate');
        // delete process by month and year
        $this->deletePayrollByProcess($dateProcess['month'],$dateProcess['year']);

        $listPtkp=PtkpStatus::orderBy('effective_date','DESC')->first();
        foreach($employees as $data){

          $model= new \App\Models\EmployeePayroll();
          $tempCutTax=[];
          // set normal data first
          // $model['takehomepay']=$data->getCurrentSalary()->new_salary;
          $model['cutoff_to']=$period['start'];
          $model['cutoff_from']=$period['end'];
          $model['employee_id_fk']=$data->id;
          $model['basic_salary']=$data->getCurrentSalary()->new_salary;
          $model['full_salary']=$data->getCurrentSalary()->new_salary;
          $model['month_process']=$dateProcess['month'];
          $model['year_process']=$dateProcess['year'];

          $param['jkk']=$jkk;
          $param['list_company_regulation']=$listCompanyRegulation;
          $param['employee']=$data;
          $param['company']=$taxPerson;
          $param['process_year']=$dateProcess['year'];
          $param['process_month']=$dateProcess['month'];
          $param['day_start']=$cutoffPayrollFrom;
          $param['day_end']=$cutoffPayrollTo;
          $param['cutoff_to']=$period['start'];
          $param['cutoff_from']=$period['end'];
          $param['join_date']=$data->join_date;
          $param['basic_salary']=$data->getCurrentSalary()->new_salary;

          if($data->salary_config=='non_taxable'){
              // dia ga mau dibayar pajaknya
                  $model['allowance_taxable']=0;
                  $model['deduction_taxable']=0;
                  $model['jkk']=0;
                  $model['jkm']=0;
                  $model['jht_employee']=0;
                  $model['jht_company']=0;
                  $model['bpjsk_employee']=0;
                  $model['bpjsk_company']=0;
                  $model['jp_company']=0;
                  $model['jp_employee']=0;
                  $model['jp_employee_yearly']=0;
                  $model['gross_monthly']=0;
                  $model['gross_yearly']=0;
                  $model['position_cost']=0;
                  $model['jht_employee_yearly']=0;
                  $model['netto_yearly']=0;
                  $model['ptkp']=0;
                  $model['pkp']=0;
                  $model['pph_yearly']=0;
                  $model['pph_monthly']=0;
          }
          else{


              $param['tax_config']='nett';
              $ptkpStatus=$data->tax_status;

              $param['ptkp']=$listPtkp->$ptkpStatus;


              $model['ptkp']=$param['ptkp'];
              $param['npwp_date_company']=$param['company']->npwp_date;
              $lengthOfService=$this->lengthOfService($param);

              $param['years']=$lengthOfService['years'];
              $param['service_join']=$this->service($param);
              $param['employee_id'] = $data->id;
              $taxReguler=$this->calculatePayroll($param);
              foreach($taxReguler as $key =>$value){
                  $model[$key]=$value;
              }
            //    tax allowance
              if($param['tax_config']=='nett'&&$data['employment_tax_status']!=3){

                 $temp=$this->calculateTaxAllowance($param,$model);


                 foreach($temp as $key=> $value){
                     $model->$key=$value;
                 }
              }
          }
          // $allowance = $allowance + $overtime + $taxAllowance + $bonus + $thr + $jhtAllowance + $bpjskAllowance + $jpAllowance + $backpaySalary + $pphThr + $resignAllowance;
          // $deduction = $deduction + $pph21 + $bpjskEmployee + $jhtEmployee + $absence + $jpEmployee + $thr;

          $model->save();
        }
    }
    // calculate gross income
    // hitugan gross income per month
    // basic salary+jkk+jkm+bpjscompany+ allowance taxable +deduction taxable (if they are used)
    public function calculateGrossIncome($param){
      //Get Basic Salary
      $basicSalary= $param['basic_salary'];
      // set jkm
      $jkmReguler=$param['basic_salary']*$param['list_company_regulation']->jkm/100;
      // set JKK base on company jkk_type and always have
      $jkkReguler=$param['basic_salary']*$param['jkk']/100;
      // set bpjsKcompany
      $valueBpjsk=$param['basic_salary'];

      if($param['basic_salary']>$param['list_company_regulation']->max_salary_bpjsk){
        $valueBpjsk=$param['list_company_regulation']->max_salary_bpjsk;
      }
      $bpjskCompanyReguler=$valueBpjsk*$param['list_company_regulation']->bpjsk_company/100;
      $bpjskEmployeeReguler=$valueBpjsk*$param['list_company_regulation']->bpjsk_employee/100;
      //   $allowanceReguler belum ada sedia tempat dulu;

      $session=session()->get('payroll_component.'.$param['employee_id']);
      $allowanceAtSession = $deductionAtSession = $length = 0; //for taxable
      $allowanceAtSessionNT = $deductionAtSessionNT = 0; //for nontaxable
      if(sizeof($session)){
        $length=sizeof($session['payroll_name']);
      }

      //taxable
      for($i=0;$i<$length;$i++){
        //
       if($session['payroll_type'][$i] == 'allowance_t') $allowanceAtSession .= $session['payroll_amount'][$i];
       else if($session['payroll_type'][$i] == 'allowance_nt') $allowanceAtSessionNT.= $session['payroll_amount'][$i];
       else if($session['payroll_type'][$i] == 'deduction_t') $deductionAtSession .= $session['payroll_amount'][$i];
       else if($session['payroll_type'][$i] == 'deduction_nt') $deductionAtSessionNT .= $session['payroll_amount'][$i];
      }
      $allowanceReguler=PayrollComponentEmployee::getAllowanceEmployee($param['employee_id'], null, Constant::COMP_TYPE_TAXABLE) + $allowanceAtSession;
      $deductionReguler=PayrollComponentEmployee::getDeductionEmployee($param['employee_id'], null, Constant::COMP_TYPE_TAXABLE) + $deductionAtSession;

      $allowanceNT = PayrollComponentEmployee::getAllowanceEmployee($param['employee_id'], null, Constant::COMP_TYPE_NONTAXABLE) + $allowanceAtSessionNT;
      $deductionNT = PayrollComponentEmployee::getDeductionEmployee($param['employee_id'], null, Constant::COMP_TYPE_NONTAXABLE) + $deductionAtSessionNT;

      // grossMonthlyReguler
      $grossMonthlyReguler  = ($basicSalary + $jkkReguler + $jkmReguler + $bpjskCompanyReguler + $allowanceReguler) - ($deductionReguler);


      return ['grossMonthlyReguler'=>$grossMonthlyReguler
        ,'jkmReguler'=>$jkmReguler
        ,'jkkReguler'=>$jkkReguler
        ,'bpjskCompanyReguler'=>$bpjskCompanyReguler
        ,'bpjskEmployeeReguler'=>$bpjskEmployeeReguler
        ,'allowanceReguler'=>$allowanceReguler
        ,'deductionReguler'=>$deductionReguler
        ,'allowanceNT'=>$allowanceNT
        ,'deductionNT'=>$deductionNT];
    }
    /**
     * [calculatePayroll calculate all payroll= takehomepay and tax]
     * @param  [type] $param [description]
     * @return [type]        [description]
     */
    public function calculatePayroll($param){
      // 1. Penghasilan bruto per bulan = basic_salary+jkk+jkm+bpjsKcompany+ allowance_taxable -deduction_taxable (if they are used)
      $resultCalculateGrossIncome=$this->calculateGrossIncome($param);
      // 2. penghasilan bruto per tahun = bruto_per_bulan* service_join
      foreach($resultCalculateGrossIncome as $key=> $value){
        $$key=$value;
        $param[$key]=$value;
      }
      //BRUTO SETAHUN
      $grossYearlyReguler=$grossMonthlyReguler*$param['service_join'];

      if($grossYearlyReguler < 0)
      {
          $grossYearlyReguler = 0;
      }
      // 4. penghasilan jp employee per tahun= jp_employee*basic_salary*service_join
      // 5. penghasilan jht employee per tahun=jht_employee*basic_salary*service_join
      //   JHT JP MONTH
        $jhtEmployeeReguler=$param['basic_salary']*$param['list_company_regulation']->jht_employee/100;
        $jhtCompanyReguler=$param['basic_salary']*$param['list_company_regulation']->jht_company/100;
        $valuejp=$param['basic_salary'];
        if($param['basic_salary']>$param['list_company_regulation']->max_salary_jp){
            $valuejp=$param['list_company_regulation']->max_salary_jp;
        }
        $jpEmployeeReguler=$valuejp*$param['list_company_regulation']->jp_employee/100;
        $jpCompanyReguler=$valuejp*$param['list_company_regulation']->jp_company/100;

      //   JHT JP EMPLOYEE YEARD
        $jhtEmployeeYearlyReguler=$jhtEmployeeReguler*$param['service_join'];
        $jpEmployeeYearlyReguler=$jpEmployeeReguler*$param['service_join'];
        //POSITION COST (BIAYA JABATAN)
        $positionCost         = $this->positionCostValidation($grossYearlyReguler,$param);

        $positionCostReguler  = $positionCost['position_cost'];
      // 6. penghasilan netto per tahun= bruto_per_tahun - jp_employee_per_tahun - jp_employee_yearly - position_cost_per_tahun



      //NETTO
      $nettoYearlyReguler   = $grossYearlyReguler - $positionCostReguler - $jhtEmployeeYearlyReguler - $jpEmployeeYearlyReguler;
      // 7. pkp=netto tahunan - ptkp
      $pkpReguler = $nettoYearlyReguler - $param['ptkp'];
      $pkpRegulerFix        = $pkpReguler;
      if($pkpReguler > 1000)
      {
          $pkpRegulerFix = $pkpReguler - substr($pkpReguler,-3);
      }
      // 9. pph monthly= pphyearly/service_join

      //PPH REGULER
      $pphCalculate        = $this->pphCalculate($pkpRegulerFix);
      // 8. pph Yearly= trgantung dari nilai pkp -> liat rumus pph calculate
      $pphYearlyReguler    = doubleval(floor($pphCalculate['pphYearly']));
      $pph_due = $pphYearlyReguler;
      $pphMonthlyReguler = 0;
      if($param['service_join'] > 0){
         $pphMonthlyReguler   = round($pph_due/$param['service_join']);
      }
      if($pkpReguler <= 0){
        $pkpRegulerFix      = 0;
        $pphYearlyReguler   = 0;
        $pphMonthlyReguler  = 0;
      }
      //TAX ALLOWANCE FOR TYPE TAX GROSS
    //   hard code tax config
        $taxAllowance = 0;
        if($param['tax_config'] == 'nett')
        {
            $taxAllowance = round($pphMonthlyReguler,2);
        }
        if($param['employee']['salary_config'] == 'non_taxable' || ($param['cutoff_from'] < $param['npwp_date_company']))
        {
            $pphYearlyReguler       = 0;
            $pphMonthlyReguler      = 0;
            $positionCostReguler    = 0;
            $nettoYearlyReguler     = 0;
            $ptkp                   = 0;
            $pkpRegulerFix          = 0;
            $taxAllowance           = 0;
            $pph_due          = 0;
            $netto_total            = 0;
        }
      return array(
          'allowance_taxable'     => $allowanceReguler,
          'allowance_nontaxable'  => $allowanceNT,
          'deduction_taxable'     => $deductionReguler,
          'deduction_nontaxable'  => $deductionNT,
          'jkk'                   => $jkkReguler,
          'jkm'                   => $jkmReguler,
          'jht_employee'          => $jhtEmployeeReguler,
          'jht_company'           => $jhtCompanyReguler,
          'bpjsk_employee'        => $bpjskEmployeeReguler,
          'bpjsk_company'         => $bpjskCompanyReguler,
          'jp_company'            => $jpCompanyReguler,
          'jp_employee'           => $jpEmployeeReguler,
          'jp_employee_yearly'    => $jpEmployeeYearlyReguler,
          'gross_monthly'         => $grossMonthlyReguler,
          'gross_yearly'          => $grossYearlyReguler,
          'position_cost'         => $positionCostReguler,
          'jht_employee_yearly'   => $jhtEmployeeYearlyReguler,
          'netto_yearly'          => $nettoYearlyReguler,
          'tax_allowance'         => $taxAllowance,
          'pkp'                   => $pkpRegulerFix,
          'pph_yearly'            => $pphYearlyReguler,
          'pph_monthly'           => round($pphMonthlyReguler,2),
     );
    }
    // calculate tax allowance
    // must same with pph21
    public function calculateTaxAllowance($param,$nettoTaxEmployee)
    {
        $grossMonthlyReguler        = 0;
        $grossYearlyReguler         = 0;
        $positionCostReguler        = 0;
        $jhtEmployeeYearlyReguler   = 0;
        $jpEmployeeYearlyReguler    = 0;
        $nettoYearlyReguler         = 0;
        $pkp                        = 0;
        $pphYearly                  = 0;
        $pphMonthly                 = 0;
        $taxAllowance               = 0;
        $pph_due                    = 0;
        $netto_total                = 0;

        $grossMonthlyReguler     = $nettoTaxEmployee['gross_monthly'];
        $grossYearlyReguler      = $nettoTaxEmployee['gross_yearly'];
        $positionCostReguler     = $nettoTaxEmployee['position_cost'];
        $nettoYearlyReguler      = $nettoTaxEmployee['netto_yearly'];
        $pkp                     = $nettoTaxEmployee['pkp'];
        $pphYearly               = $nettoTaxEmployee['pph_yearly'];
        $pphMonthly              = $nettoTaxEmployee['pph_monthly'];
        $taxAllowance            = $nettoTaxEmployee['tax_allowance'];
        $pph21          = 0;

        $basicSalary                = $nettoTaxEmployee['basic_salary'];
        $jkk                        = $nettoTaxEmployee['jkk'];
        $jkm                        = $nettoTaxEmployee['jkm'];
        $jhtEmployeeYearlyReguler   = $nettoTaxEmployee['jht_employee_yearly'];
        $jpEmployeeYearlyReguler    = $nettoTaxEmployee['jp_employee_yearly'];
        $bpjskCompany               = $nettoTaxEmployee['bpjsk_company'];
        $allowance                  = $nettoTaxEmployee['allowance_taxable'];
        $deduction                  = $nettoTaxEmployee['deduction_taxable'];
        $allowanceDeduction         = $allowance-$deduction;
        $taxAllowance               = $nettoTaxEmployee['tax_allowance'];

        while($pph21 != $taxAllowance)
        {
            if($pph21 != 0)
            {
                $taxAllowance     = $pph21;
            }
            else
            {
                $taxAllowance     = $nettoTaxEmployee['tax_allowance'];
            }

            $grossMonthlyReguler  = doubleval(floor($basicSalary + $jkk + $jkm + $bpjskCompany + $allowanceDeduction + $taxAllowance));
            $grossYearlyReguler   = doubleval(floor($grossMonthlyReguler * $param['service_join']));
            //POSITION COST (BIAYA JABATAN)
            $positionCost         = $this->positionCostValidation($grossYearlyReguler,$param);
            $positionCostReguler  = $positionCost['position_cost'];

            $nettoYearlyReguler   = doubleval(floor($grossYearlyReguler - $positionCostReguler - doubleval(floor($jhtEmployeeYearlyReguler)) - doubleval(floor($jpEmployeeYearlyReguler))));

            $netto_total = $nettoYearlyReguler;


            //PKP
            $pkpValue             = doubleval(floor($nettoYearlyReguler - $param['ptkp']));
            $pkp = $pkpValue;
            if($pkpValue > 1000)
            {
                $pkp = $pkpValue - substr($pkpValue,-3);
            }
            else if($pkpValue <= 0)
            {
                $pkp = 0;
            }

            //PPH
            $pphCalculate = $this->pphCalculate($pkp);
            $pphYearly    = doubleval(floor($pphCalculate['pphYearly']));
            $pph_due = $pphYearly;
            $pphMonthly = 0;
            if($param['service_join'] > 0)
            {
              $pphMonthly   = round(($pph_due / $param['service_join']));
            }
            //PPH21
            $pph21 = $pphMonthly;

        }

        return array(
            'gross_monthly'         => $grossMonthlyReguler,
            'gross_yearly'          => $grossYearlyReguler,
            'position_cost'         => $positionCostReguler,
            'jht_employee_yearly'   => $jhtEmployeeYearlyReguler,
            'jp_employee_yearly'    => $jpEmployeeYearlyReguler,
            'netto_yearly'          => $nettoYearlyReguler,
            'pkp'                   => $pkp,
            'pph_yearly'            => $pphYearly,
            'pph_monthly'           => $pphMonthly,
            'tax_allowance'         => $taxAllowance,
       );
    }
    // get period
    public function getPeriodPayroll($dayStart,$dayEnd){
      $date=session('payrolldate');
      $periodStart=Carbon::create($date['year'],$date['month'],$dayStart)->toDateString();
      $periodEnd=Carbon::create($date['year'],$date['month'],$dayEnd)->toDateString();
      return ['start'=>$periodStart
        ,'end'=>$periodEnd];
    }
    public function deletePayrollByProcess($month,$year){
        EmployeePayroll::where('month_process',$month)->where('year_process',$year)->delete();
    }
    public function positionCostValidation($grossYearly, $param)
    {
        $valuePositionCost = 500000 * $param['service_join'];
        $positionCostCount = round(0.05 * $grossYearly);
        if($positionCostCount > $valuePositionCost)
        {
            $positionCost = $valuePositionCost;
        }
        else
        {
            $positionCost = round($positionCostCount);
        }

          if($param['employee']['employment_tax_status'] == 3)
        {
            $positionCost = 0;
        }

        return array(
            'position_cost' => $positionCost,
        );
    }
    // calculate pkp
    public function pphCalculate($pkp){
      $temp = "";
      if($pkp <= 50000000)
      {
         $temp = $pkp * 0.05;
      }
      else if($pkp >= 50000000 && $pkp <= 250000000)
      {
         $temp = 0.05*50000000 + (($pkp-50000000) * 0.15);
      }
      else if($pkp >= 250000000 && $pkp <= 500000000)
      {
         $temp = 0.05*50000000 + (0.15 * 200000000) + (($pkp-250000000)*0.25);
      }
      else if($pkp >= 50000000)
      {
         $temp = 0.05*50000000 + (0.15 * 200000000) + (0.25 * 250000000) + (($pkp-500000000)*0.30);
      }

      $pphYearly = $temp;

      return array(
         'pphYearly' => $pphYearly,
      );
    }


    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {


    }
}
