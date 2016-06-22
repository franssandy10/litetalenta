<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ServiceController;
// use App\Http\Controllers\TimeoffController;
use App\Models\Attendance;
use App\Models\Employee;
use App\Models\TimeOffTaken;
use Sentinel;
class AttendanceController extends Controller
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
    public function index()
    {
        $list=Attendance::where('employee_id_fk',Sentinel::getUser()->userAccessConnection->employee_id_fk)->get();
        return view('attendance/index',['list'=>$list]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function doCreateAttendance(Request $request)
    {
        $inputs=$request->all();
        // $inputs['date'] = ServiceController::parseDate($inputs['date'],1);
        // dd($inputs);
        $attendance = [];
        $data = [];
        $timeoff = [];

        $j=0; // individual counter for attendance
        for($i=0; $i<count($inputs['employee_id_fk']); $i++){
            $data['employee_id_fk'] = $inputs['employee_id_fk'][$i];

            // check is there any time off for this employee and this date
            
            // validate inputs
            if($inputs['timeoff'][$i]==0){
                $ci_H = $inputs['checked_in_hour'][$j];
                $ci_M = $inputs['checked_in_minute'][$j];
                $co_H = $inputs['checked_out_hour'][$j];
                $co_M = $inputs['checked_out_minute'][$j];
                $data['checked_in_hour'] = $ci_H;
                $data['checked_in_minute'] = $ci_M;
                $data['checked_out_hour'] = $co_H;
                $data['checked_out_minute'] = $co_M;
                $attendance[$j] = new Attendance();
                if (!$attendance[$j]->validate($data)) {
                   return response()->json($attendance[$j]->errors());
                }
                // declare checked in & out and prepare for saving data
                $inputs['checked_in_at'] = $ci_H.':'.$ci_M;
                $inputs['checked_out_at'] = $co_H.':'.$co_M;
                $data[$j]=$inputs;
                $data[$j]['employee_id_fk'] = $inputs['employee_id_fk'][$i];
                $j++;
            } else {
                $timeoff[]=array(
                    'policy'=> $inputs['timeoff'][$i],
                    'employee'=> $data['employee_id_fk'],
                );
            }
        }

        //create timeoff taken here
        for($k=0; $k<count($timeoff);$k++){
                $taken = TimeOffTaken::where('employee_id_fk',$timeoff[$k]['employee'])
                                     ->where('date',$inputs['date'])->first();
                if (!$taken) $taken = new TimeOffTaken;
                $taken->fk_ref = 0;
                $taken->employee_id_fk = $timeoff[$k]['employee'];
                $taken->policy_id_fk = $timeoff[$k]['policy'];
                $taken->day_amount = 1;
                $taken->has_approver= 0; //inputted by admin
                $taken->date = $inputs['date'];
                $taken->save();
        }

        //create attendance
        for($i=0; $i<count($attendance); $i++){
            $taken = TimeOffTaken::where('employee_id_fk',$data[$i]['employee_id_fk'])
                                 ->where('date',$inputs['date'])->first();
            if($taken){
              $taken->deleted_by = Sentinel::getUser()->id;
              $taken->save();
              $taken->delete();
            }
            $checkmodel = Attendance::where('date',$inputs['date'])
                                    ->where('employee_id_fk',$data[$i]['employee_id_fk'])
                                    ->first();
            if ($checkmodel) $checkmodel->insertData($data[$i]);
            else $attendance[$i]->insertData($data[$i]);
        }
        return response()->json(['status'=>'success']);
    }

    public function doMassInsert(Request $request){
        $inputs=$request->all();

        // if user not yet inputted start_date / end_date
        if (!$inputs['start_date'] || !$inputs['end_date']){
            return response()->json(['date'=>['Start and End Date is required.']]);
        }

        // start_date must be smaller than end_date
        $daysamount = ServiceController::countDays($inputs['start_date'],$inputs['end_date']);
        if ($daysamount<1){
            return response()->json(['date'=>['End Date must be larger than Start Date.']]);
        }

        // get employee id
        if ($inputs['employee_id_fk']=='all') { //get all employee id
            $temp=Employee::all();
            $list= $temp->pluck('id');
        } else {
            $list=explode(',',$inputs['employee_id_fk']);
        }
        $inputs['employee_id_fk'] = $list[0];

        //validate the 1st data in the array
        $attendance = new Attendance();
        if (!$attendance->validate($inputs)) {
           return response()->json($attendance->errors());
        }

        // validation success, save that 1st data
        // format 19:30
        $data['checked_in_at'] = $inputs['checked_in_hour'].':'.$inputs['checked_in_minute'];
        $data['checked_out_at'] = $inputs['checked_out_hour'].':'.$inputs['checked_out_minute'];
        $data['employee_id_fk'] = $list[0];

        // prepare starting-point for saving attendance in those span days
        $dateincrement = $inputs['start_date'];

        // as the model has been formed, save the first day manually
        $data['date'] = $dateincrement;

        // check is there any time off taken by this employee for this day 
        // if yes, DO NOT record attendance
        $taken = TimeOffTaken::where('employee_id_fk',$data['employee_id_fk'])
                             ->where('date',$data['date'])->first();
        if (!$taken){
            // check if this employee already has an attendance record for this day
            $checkmodel = Attendance::where('date',$data['date'])
                                    ->where('employee_id_fk',$data['employee_id_fk'])
                                    ->first();
            if ($checkmodel) $checkmodel->insertData($data);
            else $attendance->insertData($data);
        }
        // then loop for the remaining days
        for ($i=1; $i< $daysamount; $i++){
          $dateincrement = date('Y-m-d H:i:s', strtotime($dateincrement . ' +1 day'));
          $data['date'] = $dateincrement; //increment 1st, then insert

          // check is there any time off taken by this employee for this day
          $taken = TimeOffTaken::where('employee_id_fk',$data['employee_id_fk'])
                               ->where('date',$data['date'])->first();
          if (!$taken){
            $checkmodel = Attendance::where('date',$data['date'])
                                    ->where('employee_id_fk',$data['employee_id_fk'])
                                    ->first();
            if ($checkmodel) $checkmodel->insertData($data);
            else {
              $attendance = new Attendance();
              $attendance->insertData($data);
            }
          }
        }

        // and loop for the remaining employees
        for($i=1; $i<count($list); $i++){
            if ($list[$i]!=null) { // index terakhir bisa null kalo pake explode (,)
                $data['employee_id_fk'] = $list[$i];
                $dateincrement = $inputs['start_date']; //reset start_date
                // loop for the whole span days
                for ($j=0; $j< $daysamount; $j++){
                  $data['date'] = $dateincrement; //insert 1st, then increment
                  $dateincrement = date('Y-m-d H:i:s', strtotime($dateincrement . ' +1 day'));

                  // check is there any time off taken by this employee for this day
                  $taken = TimeOffTaken::where('employee_id_fk',$data['employee_id_fk'])
                                       ->where('date',$data['date'])->first();
                  if (!$taken){
                    $checkmodel = Attendance::where('date',$data['date'])
                                            ->where('employee_id_fk',$data['employee_id_fk'])
                                            ->first();
                    if ($checkmodel) $checkmodel->insertData($data);
                    else {
                      $attendance = new Attendance();
                      $attendance->insertData($data);
                    }
                  }
                }
            }
        }
        return response()->json(['status'=>'success']);
    }

    /**
     * Display the specified resource.
     *
     * @param  Request $request: {start_date, end_date}
     * @return \Illuminate\Http\Response
     */
    public function getAttendanceInRange(Request $request)
    {
        $employee = Employee::with(['employeeAttendance','employeeTimeOffTaken'])->get(['id','employee_id','first_name','last_name','job_position_id_fk'])->toArray();

        for($i=0; $i<count($employee);$i++) {
            for($j=0; $j<count($employee[$i]['employee_attendance']);$j++){
                $exp = explode(':',$employee[$i]['employee_attendance'][$j]['checked_in_at']);
                $employee[$i]['employee_attendance'][$j]['checked_in_hour']   = (strlen($exp[0])==1)? '0'.$exp[0] : $exp[0];
                $employee[$i]['employee_attendance'][$j]['checked_in_minute'] = (strlen($exp[1])==1)? '0'.$exp[1] : $exp[1];
    
                $exp = explode(':',$employee[$i]['employee_attendance'][$j]['checked_out_at']);
                $employee[$i]['employee_attendance'][$j]['checked_out_hour']   = (strlen($exp[0])==1)? '0'.$exp[0] : $exp[0];
                $employee[$i]['employee_attendance'][$j]['checked_out_minute'] = (strlen($exp[1])==1)? '0'.$exp[1] : $exp[1];
    
                unset($employee[$i]['employee_attendance'][$j]['checked_in_at']);
                unset($employee[$i]['employee_attendance'][$j]['checked_out_at']);
            }
        }
        return response()->json($employee);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function detail()
    {
        return view('attendance/detail');
    }
}
