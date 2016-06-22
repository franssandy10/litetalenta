<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use PDF;
use Excel;
use App\Models\Employee;
use App\Http\Controllers\Controller;
use Sentinel;
use App\Models\EmployeePayroll;

class ReportController extends Controller
{

  /**
   * Create a new authentication controller instance.
   *
   * @return void
   */
  public function __construct()
  {
      $this->middleware('auth');
      $this->middleware('role');
  }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($month,$year)
    {
        $totalEmployeePayroll=count(EmployeePayroll::where('month_process',$month)->where('year_process',$year)->get());
        return view('report/index',['generalHeaderTitle1'=>'Report List','month'=>$month,'year'=>$year,'total_employee_payroll'=>$totalEmployeePayroll]);
    }
    /**
     * Display a listing of the employee payslip.
     *
     * @return \Illuminate\Http\Response
     */
    public function payslipIndex($month,$year)
    {
        $employeeList=Employee::all();
        return view('report/payslip/index',['generalHeaderTitle1'=>'Payslip List','employee_list'=>$employeeList,'month'=>$month
          ,'year'=>$year]);
    }
    public function dataPayslip($id,$month,$year,$forPDF=false){
      $temp['employee']=Employee::where('id',$id)->first();
      $temp['detail_payroll']=EmployeePayroll::where('employee_id_fk',$id)->where('month_process',$month)->where('year_process',$year)->first();

      if($forPDF) {
        //set detail allowance
        $detailAllowance['Allowance_Taxable'] = $temp['detail_payroll']->allowance_taxable;
        $detailAllowance['Allowance_Nontaxable'] = $temp['detail_payroll']->allowance_nontaxable;
        $detailAllowance['Tax_Allowance'] = $temp['detail_payroll']->tax_allowance;
        $temp['detailAllowance'] = $detailAllowance;

        //set detail deduction
        $detailDeduction['Deduction_Taxable'] = $temp['detail_payroll']->deduction_taxable;
        $detailDeduction['Deduction_Nontaxable'] = $temp['detail_payroll']->deduction_nontaxable;
        $detailDeduction['Jaminan_Pensiun_Employee'] = $temp['detail_payroll']->jp_employee;
        $detailDeduction['BPJS_K_Employee'] = $temp['detail_payroll']->bpjsk_employee;
        $detailDeduction['JHT_Employee'] = $temp['detail_payroll']->jht_employee;
        $detailDeduction['PPH_21'] = $temp['detail_payroll']->pph_monthly;
        $temp['detailDeduction'] = $detailDeduction;
      }

      // set total variable;

      // set total allowance
      $total['allowance']=$temp['detail_payroll']->allowance_taxable+$temp['detail_payroll']->allowance_nontaxable+=$temp['detail_payroll']->tax_allowance;
      // set total deduction;
      $total['deduction']=$temp['detail_payroll']->jp_employee+$temp['detail_payroll']->bpjsk_employee+$temp['detail_payroll']->jht_employee+$temp['detail_payroll']->pph_monthly+$temp['detail_payroll']->deduction_taxable+$temp['detail_payroll']->deduction_nontaxable;
      // set takehomepay
      $total['takehomepay']=$temp['detail_payroll']->basic_salary+$total['allowance']-$total['deduction'];

      $temp['total']=$total;
      return $temp;
    }

    /**
     * [payslipDetail detail of payslip per user]
     * @param  [type] $id [employee_id]
     * @return [view]     [payroll detail]
     */
    public function payslipDetail($id,$month,$year)
    {
      if($id!=NULL&&$month!=NULL&&$year!=NULL){

        $result=$this->dataPayslip($id,$month,$year);
        return view('report/payslip/detail',['generalHeaderTitle1'=>'Payslip','result'=>$result['employee'],'detail_payroll'=>$result['detail_payroll'],'total'=>$result['total']]);
      }

    }
    /**
     * [payslipPdf show payslip pdf]
     * @param  string $type [description]
     */
    public function payslipPdf($type="STREAM",$id,$month,$year){
      $data=[];
      $result=$this->dataPayslip($id,$month,$year,true);
      //return view('report/payslip/pdf',['result'=>$result['employee'],'detail_payroll'=>$result['detail_payroll'],'total'=>$result['total']]);

      // dd($result['employee']->userAccessConnection);
      $pdf = PDF::loadView('report/payslip/pdf',['result'=>$result['employee'],
                            'detail_payroll'=>$result['detail_payroll'],
                            'total'=>$result['total'],
                            'detailAllowance'=>$result['detailAllowance'],
                            'detailDeduction'=>$result['detailDeduction']
                          ]);


      if($type=="STREAM"){
        return $pdf->stream();
      }
      else{
        return $pdf->download(strtolower("payslip".$month.$year.'_'.$result['employee']->first_name.' '.$result['employee']->last_name.'_'.$result['employee']->employee_id.'.pdf'));
      }

    }
    public function xlsReport(){
      $dataNameColumn=[
        '* CPF Account No (SXXXXXXXA)',
        '* Name of Employee',
        '* CPF to be paid($)',
        '* Ordinary Wage($)',
        '* Additional Wage ($)',
        'Agency Fund ($)',
        'Agency (CDAC/ MBMF/ SINDA/ ECF)',
        '* Employment Status (Existing / Left / New / New & Leaving)',
        'Date Left Employment (DD.MMM.YYYY)',
    ];
    $data['name_column']=$dataNameColumn;
      // For cleaning whitespace dan hal ga jelas
      ob_end_clean();
      ob_start(); //At the very top of your program (first line)
      Excel::create('clases', function($excel) use($data) {
        // Set the title
        $excel->setTitle('Our new awesome title');

        // Chain the setters
        $excel->setCreator('Maatwebsite')
              ->setCompany('Maatwebsite');
        // Call them separately
        $excel->setDescription('A demonstration to change the file properties');
        $excel->sheet('First name', function($sheet) use ($data) {
          $sheet->row(1, $data['name_column']);
            // Sheet manipulation
        // $sheet->cell('A1', function($cell) {
        //     $cell->setValue('this is the cell value.');
        //       // manipulate the cell
        //
        // });


        });
      })->export('xls');
      ob_flush();
    }

    public function salaryDetailPDF($month_process,$year_process)
    {
      return $this->salaryDetail($month_process,$year_process,true);
    }
    /**
     * [salaryDetail report salary detail]
     * @return [type] [description]
     */
    public function salaryDetail($month_process,$year_process,$forPDF=false)
    {
      // $this->dispatch((new SendEmail($data))->onQueue('emails'));
      // $job = (new \App\Jobs\SalaryDataQueue())->onQueue('salary');
      // $this->dispatch($job);
      $payroll=EmployeePayroll::where('month_process',$month_process)->where('year_process',$year_process)->get();
      $salaryDetail=[];
      $columns=[
        'employee_id'       => 'Employee ID',
        'full_name'         => 'Full Name',
        'job_title'         => 'Job Title',
        'basic_salary'      => 'Basic Salary',
        'tax_allowance'     => 'Tax Allowance',
        'total_allowance'   => 'Total Allowance',
        'jp_employee'       => 'Jaminan Pensiun Employee',
        'bpjsk_employee'    => 'BPJSK Employee',
        'jht_employee'      => 'JHT Employee',
        'pph21'         => 'PPH 21',
        'total_deduction'   => 'Total Deduction',
        'takehomepay'       => 'Take Home Pay',

      ];
      $total=[];
      foreach($columns as $key=>$value){
        $total[$key]=0;
      }
      unset($total['employee_id']);
      unset($total['full_name']);
      unset($total['job_title']);
      foreach($payroll as $data){
        $temp=[];
        $temp['employee_id']=$data->employeeDetail->employee_id;
        $temp['full_name']=$data->employeeDetail->first_name." ".$data->employeeDetail->last_name;
        $temp['job_title']="";
        $temp['basic_salary']=$data['basic_salary'];
        $temp['tax_allowance']=$data['tax_allowance'];
        $temp['total_allowance']=$data['allowance_taxable'] + $data['allowance_nontaxable'] + $data['tax_allowance'];
        $temp['jp_employee']=$data['jp_employee'];
        $temp['bpjsk_employee']=$data['bpjsk_employee'];
        $temp['jht_employee']=$data['jht_employee'];
        $temp['pph21']=$data['pph_monthly'];
        $temp['total_deduction']=$data['jp_employee']+$data['bpjsk_employee']+$data['jht_employee']+$data['pph21']+$data['deduction_taxable']+$data['deduction_nontaxable'];;
        $temp['takehomepay']=$temp['basic_salary']+$temp['total_allowance']-$temp['total_deduction'];
        // for total

        $total['basic_salary']+=$temp['basic_salary'];
        $total['tax_allowance']+=$temp['tax_allowance'];
        $total['total_allowance']+=$temp['total_allowance'];
        $total['jp_employee']+=$temp['jp_employee'];
        $total['bpjsk_employee']+=$temp['bpjsk_employee'];
        $total['jht_employee']+=$temp['jht_employee'];
        $total['pph21']+=$temp['pph21'];
        $total['total_deduction']+=$temp['total_deduction'];
        $total['takehomepay']+=$temp['takehomepay'];

        $salaryDetail[]=$temp;
      }

      if($forPDF) {

        $pdf = PDF::loadView('report/salary-detail-pdf',['columns'=>$columns
            ,'salary'=>$salaryDetail
            ,'total'=>$total]);

        return $pdf->setPaper('a4', 'landscape')->download('salary-detail-'.$month_process.'-'.$year_process.'.pdf');
      }

        return view('report/salary-detail'
        ,['generalHeaderTitle1'=>'Salary Detail'
        ,'columns'=>$columns
        ,'salary'=>$salaryDetail
        ,'total'=>$total
        ,'month_process'=>$month_process
        ,'year_process'=>$year_process
        ,'generalHeaderTitle2'=>Sentinel::getUser()->userCompany->name]);
    }

    public function tax1721a1($type="stream",$id){
      $data=[];
      $result=Employee::find($id);
      $pdf = PDF::loadView('report/tax/1721-a1',['result'=>$result] )->setPaper([0, 0, 612.283, 935.432], 'portrait');
      if($type=="stream"){
        return $pdf->stream();
      }
      else{
        return $pdf->download('1721-a1.pdf');
      }

    }

    public function tax1721vi($type="stream",$id){
      $data=[];
      $result=Employee::find($id);
      $pdf = PDF::loadView('report/tax/1721-vi',['result'=>$result] )->setPaper([0, 0, 612.283, 935.432], 'portrait');
      if($type=="stream"){
        return $pdf->stream();
      }
      else{
        return $pdf->download('1721-vi.pdf');
      }

    }

    public function tax1721vii($type="stream",$id){
      $data=[];
      $result=Employee::find($id);
      $pdf = PDF::loadView('report/tax/1721-vii',['result'=>$result] )->setPaper([0, 0, 612.283, 935.432], 'portrait');
      if($type=="stream"){
        return $pdf->stream();
      }
      else{
        return $pdf->download('1721-vii.pdf');
      }

    }

}
