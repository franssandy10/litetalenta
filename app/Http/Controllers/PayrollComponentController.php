<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Http\Request;

use App\Http\Controllers\Controller;

use App\Http\Requests;
use App\Http\Requests\SalaryHistoryRequest;
use App\Http\Requests\PayrollComponentAdjustmentRequest;
use App\Http\Requests\PayrollComponentRequest;

use App\Models\EmployeeSalaryHistory;
use App\Models\TransactionComponent;
use App\Models\Employee;
use App\Models\PayrollComponent;
use App\Models\PayrollComponentEmployee;

use Sentinel;
use Carbon\Carbon;
use UserService;

class PayrollComponentController extends Controller
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
   * [transactionAdjustment description]
   * @return [type] [description]
   */
  public function transactionAdjustment()
  {
      $salaryTransactions = TransactionComponent::with(['salaryHistory'=>function($q){
            $q->with(['employee'=>function($q){
                $q->addSelect(['first_name','last_name','id']);
            }])->addSelect(['transaction_id_fk','employee_id_fk']);
        }])->where('type_transaction',1)
           ->get(['id','transaction_id','effective_date','changes'])
           ->toArray();

      $allowanceTransactions = TransactionComponent::with(['payrollComponentEmployee'=>function($q){
            $q->with(['employee'=>function($q){
                $q->addSelect(['first_name','last_name','id']);
            }])->addSelect(['transaction_id_fk','employee_id_fk']);
        }])->where('type_transaction',2)
           ->get(['id','transaction_id','changes'])
           ->toArray();

      $deductionTransactions = TransactionComponent::with(['payrollComponentEmployee'=>function($q){
            $q->with(['employee'=>function($q){
                $q->addSelect(['first_name','last_name','id']);
            }])->addSelect(['transaction_id_fk','employee_id_fk']);
        }])->where('type_transaction',3)
           ->get(['id','transaction_id','changes'])
           ->toArray();

      return view('payroll/component/transaction-adjustment',
        [
          'generalHeaderTitle1'=>'Payroll Changes',
          'salaryTransactions'=>$salaryTransactions,
          'allowanceTransactions'=>$allowanceTransactions,
          'deductionTransactions'=>$deductionTransactions,
        ]);
  }

  /**
   * [doAdjustSalary adjust salary]
   * @return [type] [description]
   */
  public function doAdjustSalary(Request $request){
    $inputs=$request->all();
    $model=new EmployeeSalaryHistory;
    $lastModel= EmployeeSalaryHistory::where('employee_id_fk',$inputs['employee_id_fk'])->orderBy('id','desc')->first();
    $model->old_salary=$lastModel->new_salary;
    $model->effective_date=Carbon::now();
     if (!$model->validate($inputs)) {
       return response()->json($model->errors());
     }
     $model->insertData($inputs);
     $model->save();
     return response()->json(['status'=>'success','url'=>route('myinfoindex',['#payrollinfo'])]);
  }
  public function doAddPayrollComponent(PayrollComponentRequest $request){

    $inputs=$request->all();

    // for set type
    if($inputs['component_type']=='allowance'){
      $inputs['component_type']=1;
    }
    else if($inputs['component_type']=='deduction'){
      $inputs['component_type']=2;
    }
    else{
      // ada yang nembak by component
      return response()->json(['error'=>'something wrong'],405);
    }
    // for check if type_occur not monthly
    if($inputs['component_type_occur']!=1){
      $inputs['prorate_flag']=0;
    }
    $model=new PayrollComponent;
    $model->insertData($inputs);
    if(isset($inputs['valid_for_all'])){
      // get all employeeadjust
      $employees=Employee::all();
      foreach($employees as $employee){
        $employeeComponent=new PayrollComponentEmployee;
        $employeeComponent->employee_id_fk=$employee->id;
        $employeeComponent->component_id_fk=$model->id;
        $employeeComponent->component_amount=$inputs['component_amount'];
        $employeeComponent->save();
      }
    }
    else{
      if(isset($inputs['employees'])){
        foreach($inputs['employees'] as $row ){
          $employeeComponent=new PayrollComponentEmployee;
          $employeeComponent->employee_id_fk=$row;
          $employeeComponent->component_id_fk=$model->id;
          $employeeComponent->component_amount=$inputs['component_amount'];
          $employeeComponent->save();
        }
      }

    }
    return response()->json(['status'=>'success', 'delete'=>route('payrollcomponent.delete', ['id'=>$model->id]), 'view'=>route('payrollcomponent.detail', ['id'=>$model->id])]);
  }
  public function doDeleteComponent($id){
    PayrollComponent::where('id',$id)->delete();
    return response()->json(['status'=>'success']);
  }
  public function detailComponent($id){
    $detail=PayrollComponent::where('id',$id)->get();
    if($detail){
        return response()->json($detail->toArray());
    }
    else{
      return response()->json(['status'=>'empty']);
    }
  }

  /**
   *  get new transaction ID
   *  @return id
   */
  public function getTransactionID($type){
    $today = Carbon::today();
    $str_yearmonth = $today->year;
    if (strlen($today->month)==2) $str_yearmonth .=$today->month;
    else $str_yearmonth .= '0'.$today->month;

    $id = $str_yearmonth.'0001';
    $latestTransaction = TransactionComponent::orderBy('id','DESC')->first();
    if($latestTransaction){
        $str_arr = str_split($latestTransaction->transaction_id,6);
        if($str_yearmonth == $str_arr[0]){
          $increment = (int)$str_arr[1] + 1;
          $id=$str_yearmonth.sprintf('%04d', $increment);
        } 
    }

    switch ($type) {
      case 'allowance':
        return response()->json(['id'=>$id,'component'=>UserService::listComponent(true,1)]);
        break;

      case 'deduction':
        return response()->json(['id'=>$id,'component'=>UserService::listComponent(true,2)]);
        break;

      default:
        return response()->json(['id'=>$id]);
        break;
    }
  }


  /**
   * [doCreateNewSalary create new salary]
   * @return success || invalid
   */
  public function doCreateNewSalary(SalaryHistoryRequest $request){
    $inputs=$request->all();

    if($inputs['selectForEmployee']=='yesAllEmployee'){
        $inputs['employees']=Employee::lists('id')->toArray();
    }

    /// create transaction component
    $transaction = new TransactionComponent();
    $transaction->type_transaction = $this->getTransactionType($inputs['type']);
    if(strlen($inputs['percent-amount'])>0){
        $transaction->changes = $inputs['percent-addsub'].$inputs['percent-amount'].'%';
        $transaction->insertData($inputs);
        $inputs['transaction_id_fk']=$transaction->id;

        if ($inputs['percent-addsub']=='-') $minusFlag= -1;
        else $minusFlag = 1;

        foreach($inputs['employees'] as $employee_id){
            // get salaryHistory
            $lastModel= EmployeeSalaryHistory::where('employee_id_fk',$employee_id)
                                             ->orderBy('id','desc')
                                             ->first();
            if($lastModel) $current_salary = $lastModel['new_salary'];
            else $current_salary = 0;

            // calculate new salary
            $changes = $current_salary*$inputs['percent-amount']/100;
            $new_salary = $current_salary + ($minusFlag*$changes);

            $model=new EmployeeSalaryHistory;
            $model->employee_id_fk=$employee_id;
            $model->old_salary=$current_salary;
            $model->new_salary=$new_salary;
            $model->insertData($inputs);
        }

    } else {
        $transaction->changes = $inputs['exact-addsub'].$inputs['exact-amount'];
        $transaction->insertData($inputs);
        $inputs['transaction_id_fk']=$transaction->id;

        if ($inputs['exact-addsub']=='-') $minusFlag= -1;
        else $minusFlag = 1;

        foreach($inputs['employees'] as $employee_id){
            // get salaryHistory
            $lastModel= EmployeeSalaryHistory::where('employee_id_fk',$employee_id)
                                             ->orderBy('id','desc')
                                             ->first();
            if($lastModel) $current_salary = $lastModel['new_salary'];
            else $current_salary = 0;

            // calculate new salary
            $new_salary = $current_salary + ($minusFlag*$inputs['exact-amount']);

            $model=new EmployeeSalaryHistory;
            $model->employee_id_fk=$employee_id;
            $model->old_salary=$current_salary;
            $model->new_salary=$new_salary;
            $model->insertData($inputs);
        }
    }
    return response()->json(['status'=>'success','url'=>route('payrollcomponenttrxadjust')]);
  }
  /**
   * [doEditSalary edit existing salary changes]
   * @return [type] [description]
   */
  public function doEditAdjustment(SalaryHistoryRequest $request){
    $inputs=$request->all();

    $salaryChanges = EmployeeSalaryHistory::where('transaction_id_fk', $inputs['transaction_id'])
                                    ->get();

    $transaction=TransactionComponent::find($inputs['transaction_id']);

    if(strlen($inputs['percent-amount'])>0){

        $transaction->changes = $inputs['percent-addsub'].$inputs['percent-amount'].'%';
        $transaction->save();

        if ($inputs['percent-addsub']=='-') $minusFlag= -1;
        else $minusFlag = 1;
        
        foreach($salaryChanges as $lastModel){
            $current_salary = $lastModel['old_salary'];

            // calculate new salary
            $changes = $current_salary*$inputs['percent-amount']/100;
            $new_salary = $current_salary + ($minusFlag*$changes);

            $lastModel->new_salary=$new_salary;
            $lastModel->save();
        }

    } else {
        $prevChanges=$transaction->changes;
        $transaction->changes = $inputs['exact-addsub'].$inputs['exact-amount'];
        $transaction->save();

        if ($inputs['exact-addsub']=='-') $minusFlag= -1;
        else $minusFlag = 1;


        if(count($salaryChanges)==0){
            $componentChanges = PayrollComponentEmployee::where('transaction_id_fk', $inputs['transaction_id'])
                                            ->get();
            $prevChangesAmount = (int) substr($prevChanges,1);
            if($prevChanges[0]!='-') $prevChangesAmount *= -1;

            foreach($componentChanges as $lastModel){
                $current_amount = $lastModel['component_amount'];

                // calculate new salary
                $new_amount = $current_amount + $prevChangesAmount + ($minusFlag*$inputs['exact-amount']);
                
                $lastModel->component_amount=$new_amount;
                $lastModel->save();
            }
        } else {
            foreach($salaryChanges as $lastModel){
                $current_salary = $lastModel['old_salary'];

                // calculate new salary
                $new_salary = $current_salary + ($minusFlag*$inputs['exact-amount']);
                $lastModel->new_salary=$new_salary;
                $lastModel->save();
            }
        }
    }

    return response()->json(['status'=>'success','url'=>route('payrollcomponenttrxadjust')]);
  }

  /**
   * [doDeleteSalary delete existing salary changes]
   * @return [type] [description]
   */
  public function doDeleteAdjustment($id){
    $check=EmployeeSalaryHistory::where('transaction_id_fk',$id)->count();
    if($check==0) PayrollComponentEmployee::where('transaction_id_fk',$id)->delete();
    else EmployeeSalaryHistory::where('transaction_id_fk',$id)->delete();
    TransactionComponent::destroy($id);
    return response()->json(['status'=>'success']);
  }

  ///////////////////COMPONENT

  /**
   * [doCreateNewSalary create new salary]
   * @return success || invalid
   */
  public function doCreateAdjustComponent(PayrollComponentAdjustmentRequest $request){
    $inputs=$request->all();

    if ($inputs['exact-addsub']=='-') $minusFlag= -1;
    else $minusFlag = 1;

    if($inputs['selectForEmployee']=='yesAllEmployee'){
        $inputs['employees']=Employee::lists('id')->toArray();
    }

    /// create transaction component
    $transaction = new TransactionComponent();
    $transaction->type_transaction=$this->getTransactionType($inputs['type']);

    $transaction->changes = $inputs['exact-addsub'].$inputs['exact-amount'];
    $transaction->insertData($inputs);
    $inputs['transaction_id_fk']=$transaction->id;

    foreach($inputs['employees'] as $employee_id){
        // get salaryHistory
        $lastModel= PayrollComponentEmployee::where('employee_id_fk',$employee_id)
                                         ->where('component_id_fk',$inputs['component_id_fk'])
                                         ->orderBy('id','desc')
                                         ->first();
        if($lastModel) $current_amount = $lastModel['component_amount'];
        else $current_amount = 0;

        // calculate new salary
        $inputs['component_amount'] = $current_amount + ($minusFlag*$inputs['exact-amount']);

        $model=new PayrollComponentEmployee;
        $model->employee_id_fk=$employee_id;
        $model->insertData($inputs);
    }

    return response()->json(['status'=>'success','url'=>route('payrollcomponenttrxadjust')]);
  }

  // /**
  //  * [doEditSalary edit existing salary changes]
  //  * @return [type] [description]
  //  */
  // public function doEditComponentAdjustment(PayrollComponentAdjustmentRequest $request){
  //   $inputs=$request->all();

  //   if ($inputs['exact-addsub']=='-') $minusFlag= -1;
  //   else $minusFlag = 1;

  //   $componentChanges = PayrollComponentEmployee::where('transaction_id_fk', $inputs['transaction_id'])
  //                                   ->get();

  //   $transaction=TransactionComponent::find($inputs['transaction_id']);
  //   $prevChanges=$transaction->changes;
  //   $transaction->changes = $inputs['exact-addsub'].$inputs['exact-amount'];
  //   $transaction->save();

  //   $prevChangesAmount = (int) substr($prevChanges,1);
  //   if($prevChanges[0]!='-') $prevChangesAmount *= -1;

  //       foreach($componentChanges as $lastModel){
  //           $current_amount = $lastModel['component_amount'];

  //           // calculate new salary
  //           $new_amount = $current_amount + $prevChangesAmount + ($minusFlag*$inputs['exact-amount']);
            
  //           $lastModel->component_amount=$new_amount;
  //           $lastModel->save();
  //       }

  //   return response()->json(['status'=>'success','url'=>route('payrollcomponenttrxadjust')]);
  // }

  // /**
  //  * [doDeleteSalary delete existing salary changes]
  //  * @return [type] [description]
  //  */
  // public function doDeleteComponentAdjustment (Request $request){
  //   $id = $request['id'];
  //   PayrollComponentEmployee::where('transaction_id_fk',$id)->delete();
  //   TransactionComponent::destroy($id);
  //   return response()->json(['status'=>'success']);
  // }

  protected function getTransactionType($type){
    switch ($type) {
      case 'salary':
        return 1;
        break;    
      case 'allowance':
        return 2;
        break;
      case 'deduction':
        return 3;
        break;
      default:
        return 4;
        break;
    }
  }

}
