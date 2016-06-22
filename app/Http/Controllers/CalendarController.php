<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\TimeOffTaken;
use Carbon\Carbon;

class CalendarController extends Controller
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
        return view('calendar/index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
     *  get time-off day list
     *  used for calendar
     *  @param $limitDays = limit data retrieved by n days onward
     *  @return json(array of dates) formatted for fullcalendar.js
     */
    public static function getTimeoffList($limitDays = null){
        $today=Carbon::today();
        $takens = TimeOffTaken::with(['employee','policy'])->orderby('date');
        if ($limitDays > 0){
            // only get timeoff taken in n days onward
            $takens->whereBetween('date', [$today, $today->copy()->addDays($limitDays)]);
            // $takens
            //         ->where('date','>=',$today)
            //        // ->where('date','!=',$today->copy()->addDays(2));
            //        ->where('date','<',$today->copy()->addDays($limitDays));
        }
        // dd($takens->get()->toArray());
        $timeoff = [];
        foreach($takens->get() as $taken){
            $temp['title']  = $taken->employee->first_name.' '.$taken->employee->last_name."'s time off";
            $temp['name']   = $taken->employee->first_name.' '.$taken->employee->last_name;
            $temp['start']  = $taken->date;
            $temp['policy'] = $taken->policy->name;
            $temp['avatar'] = $taken->employee->userAccessConnection->getAvatar();
            $temp['type']   = 'T';
            // $temp['start'] = $taken->date.'T12:00:00';
            // $temp['allDay'] = false;
            $timeoff[] = $temp;
        }
        if($limitDays > 0) return $timeoff;
        else return response()->json($timeoff);
        // return response()->json([
        //     [
        //         'title'  => 'event1',
        //         'start'  => '2016-06-25'
        //     ],
        //     [
        //         'title'  => 'event1',
        //         'start'  => '2016-05-25'
        //     ]
        // ]);
    }

    /**
     *  get birthday list
     *  used for calendar
     *  @return json(array of dates) formatted for fullcalendar.js
     */
    public function getBirthdayList(){
        $employees = Employee::whereNotNull('date_of_birth')->get(['first_name','last_name','date_of_birth']);
        $birthday = [];
        foreach ($employees as $employee){
            $birthday[] = [
                'title' => $employee->first_name.' '.$employee->last_name."'s birthday",
                'start' => $employee->date_of_birth,
                'type'  => 'B'
            ];
        }
        return response()->json($birthday);
    }

    public function timeoff(){
        return response()->json([
                        [
                            'title'  => 'Timeoff',
                            'start'  => '2016-06-25',
                            'end'    => '2016-06-27',
                            'type'   => 'T'
                        ],
                        [
                            'title'  => 'Holiday',
                            'start'  => '2016-06-26',
                            'type'   => 'H'
                        ],
                        [
                            'title'  => 'Birthday',
                            'start'  => '2016-06-26',
                            'type'   => 'B'
                        ],
                        [
                            'title'  => 'Birthday Timeoff',
                            'start'  => '2016-06-26',
                            'type'   => 'T'
                        ],
                        [
                            'title'  => 'Birthday Holiday',
                            'start'  => '2016-06-26',
                            'type'   => 'H'
                        ]
                    ]);

    }

    // public function getHolidayList() {
    //     $feedUrl = "http://www.google.com/calendar/feeds/en.usa%23holiday%40group.v.calendar.google.com/public/full?singleevents=true&futureevents=true&max-results=99&orderby=starttime&sortorder=a";
    //         //about the parameters fo this feed , you could look it up at google calendar 's api document
    //         //parameters I used , are to show 99 records , it should be enough for most cases


    //         //we don't get PTO on all holidays :( , so , this array is to define holidays I need
    //     $presetHoliday = array(
    //         "Labor Day",
    //         "Christmas Eve",
    //         "Christmas Day",
    //         "New Year's Day",
    //         "Memorial Day",
    //         "Independence Day",
    //         "Thanksgiving Day"
    //     );
    //     $holidays = array();
    //     $calendar = simplexml_load_file($feedUrl);
    //     foreach ($calendar->entry as $item) {
    //         if (in_array(trim((string) $item->title), $presetHoliday)) { // remove this condition if you need to get all holidays
    //             $ns_gd = $item->children('http://schemas.google.com/g/2005');
    //             $gCalDate = date("Y-m-d", strtotime($ns_gd->when->attributes()->startTime));
    //             $holidays[$gCalDate]=(string) $item->title;
                
    //             //harcoded , because we need to define black friday is also holiday , but google doesn't think so
    //             if((string) $item->title=="Thanksgiving Day")
    //             {
    //               $gCalDate = date("Y-m-d", strtotime($ns_gd->when->attributes()->startTime)+ 86400);
    //               $holidays[$gCalDate]="Black Friday";  
    //             }
                
    //         }
    //     }
    //    return $holidays;
    // }

    /* ===============================================================================================================================
                    HARAP MELAKUKAN PEMISAHAN EVENT, CONTOH TIME OFF DIBEDAKAN DENGAN HOLIDAY, BIRTHDAY dll...
    ================================================================================================================================ */
}
