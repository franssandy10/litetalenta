<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
use app\Models\UserAccess;
use Illuminate\Http\Request;

// Route::get('/',['uses'=>'Auth\AuthController@index']);
// For Testing
Route::get('testing',['uses'=>'ServiceController@testing','as'=>'testing']);
Route::get('thanks-approval',['uses'=>'ServiceController@thanksApproval','as'=>'thanks-approval']);

// LOGIN
// Route to show view for login
Route::get('login',['uses'=>'ServiceController@login','as'=>'login']);
// Route to validate and register new user
Route::post('login',['uses'=>'Auth\AuthController@doLogin','as'=>'login']);
// Route for logout
// LOGIN
Route::get('user-access',['uses'=>'ServiceController@getUserLoginJson','as'=>'json.useraccess']);
//Route::post('dummy-data',['uses'=>'PayrollSystemController@getDummyData','as'=>'json.dummydata']);
Route::get('dummy-data',['uses'=>'PayrollSystemController@getDummyData','as'=>'json.dummydata']);
Route::post('invitation',['uses'=>'ServiceController@doSendInvitation','as'=>'invitation']);
Route::post('remove-access',['uses'=>'ServiceController@doRemoveAccess','as'=>'access.remove']);
Route::post('change-access',['uses'=>'ServiceController@doChangeAccess','as'=>'access.change']);


// SERVICES
Route::get('/',['uses'=>'ServiceController@index','as'=>'index']);
Route::get('dashboard',['uses'=>'ServiceController@dashboard','middleware' => 'auth','as'=>'dashboard']);
Route::get('error/{reason}',['uses'=>'ServiceController@errorPage','as'=>'errorPage']);
Route::get('forgot-password',['uses'=>'ServiceController@forgotPassword','as'=>'forgotpassword']);
Route::post('forgot-password',['uses'=>'ServiceController@doForgotPassword','as'=>'forgotpassword']);
Route::get('reset-password/{id}',['uses'=>'ServiceController@resetPassword','as'=>'resetpassword']);
Route::post('reset-password/{id}',['uses'=>'ServiceController@doResetPassword','as'=>'resetpassword']);

Route::get('logout', ['uses'=>'Auth\AuthController@doLogout','as'=>'logout']);
Route::post('/change-password',['uses'=>'SettingController@doChangePassword','as'=>'settingchangepassword']);
Route::post('/validate-avatar',['uses'=>'SettingController@doValidateAvatar','as'=>'settingvalidateavatar']);
Route::post('/change-avatar',['uses'=>'SettingController@doChangeAvatar','as'=>'settingchangeavatar']);
// SERVICES

/* GETTING STARTED */
Route::get('get-started-1',['uses'=>'GetStartedController@pageOne','as'=>'getstarted.one']);
Route::post('get-started-1',['uses'=>'GetStartedController@doStartedOne','as'=>'getstarted.one']);

Route::get('get-started-2',['uses'=>'GetStartedController@pageTwo','as'=>'getstarted.two']);
Route::post('get-started-2',['uses'=>'GetStartedController@doStartedTwo','as'=>'getstarted.two']);

Route::get('get-started-3',['uses'=>"GetStartedController@pageThree",'as'=>'getstarted.three']);
Route::post('get-started-3',['uses'=>'GetStartedController@doStartedThree','as'=>'getstarted.three']);

Route::get('get-started-4',['uses'=>'GetStartedController@pageFour','as'=>'getstarted.four']);
Route::post('get-started-4',['uses'=>'GetStartedController@doStartedFour','as'=>'getstarted.four']);

Route::get('get-started-5',['uses'=>'GetStartedController@pageFive','as'=>'getstarted.five']);
Route::post('get-started-5',['uses'=>'GetStartedController@doStartedFive','as'=>'getstarted.five']);

Route::get('get-started-6',['uses'=>'GetStartedController@pageSix','as'=>'getstarted.six']);
Route::post('get-started-6',['uses'=>'GetStartedController@doStartedSix','as'=>'getstarted.six']);

Route::get('get-started-7',['uses'=>'GetStartedController@pageSeven','as'=>'getstarted.seven']);
Route::post('get-started-7',['uses'=>'GetStartedController@doStartedSeven','as'=>'getstarted.seven']);

// REGISTER
// Route Show View For Register
// Route::get('register', function () {
//     return view('services/register');
// });

// Route to validate and register new user
Route::get('register',['uses'=>'Auth\AuthController@doCreateAccount','as'=>'register']);
// Route::get('register',['middleware'=>'guest','uses'=>'Auth\AuthController@doCreateAccount','as'=>'register']);

// REGISTER
// EMPLOYEE
Route::get('on-boarding',function(){
  return view('employee/on-boarding');
});
Route::get('employee',['uses'=>'EmployeeController@employeeList','as'=>'employeeindex']);

Route::get('employee/create',['uses' => 'EmployeeController@create', 'as' => 'employeecreate']);
Route::post('employee/create/validatePersonal',['uses'=>'EmployeeController@validatePersonal','as'=>'validatepersonal']);
Route::post('employee/create/validateCompanyDetail',['uses'=>'EmployeeController@validateCompanyDetail','as'=>'validatecompanydetail']);
Route::post('employee/create/validatePayrollDetail',['uses'=>'EmployeeController@validatePayrollDetail','as'=>'validatepayrolldetail']);
Route::get('employee/schedule',['uses' => 'EmployeeController@schedule', 'as' => 'employeeschedule']);
Route::get('employee/detail-schedule',['uses' => 'EmployeeController@detailSchedule', 'as' => 'employeedetailschedule']);
Route::get('employee/{id}',['uses'=>'EmployeeController@update','as'=>'employeeinfo']);
Route::put('employee/employment/{id}',['uses'=>'EmployeeController@doUpdateEmploymentData','as'=>'employee.employmentdata']);
Route::put('employee/personal/{id}',['uses'=>'EmployeeController@doUpdatePersonalData','as'=>'employee.personaldata']);
Route::put('employee/payroll/{id}',['uses'=>'EmployeeController@doUpdatePayrollData','as'=>'employee.payrolldata']);
Route::post('employee/insertstructure',['uses'=>'EmployeeController@doInsertStructure','as'=>'employee.insert_structure']);
//My Info
Route::get('my-info',['uses'=>'MyinfoController@index','as'=>'myinfoindex']);
Route::put('my-info/employment',['uses'=>'MyinfoController@doUpdateEmploymentData','as'=>'myinfo.employmentdata']);
Route::put('my-info/personal',['uses'=>'MyinfoController@doUpdatePersonalData','as'=>'myinfo.personaldata']);
Route::put('my-info/payroll',['uses'=>'MyinfoController@doUpdatePayrollData','as'=>'myinfo.payrolldata']);


//Payroll
Route::get('payroll',['uses'=>'PayrollController@index','as'=>'payrollindex']);
Route::post('payroll/date',['uses'=>'PayrollController@doSetDate','as'=>'payrolldate']);
Route::get('payroll/configure',['uses'=>'PayrollController@configure','as'=>'payrollconfigure']);
Route::post('payroll/configure/tax-person',['uses'=>'PayrollController@doSetPayrollDetail','as'=>'payrollconfigure.payrolldetail']);
Route::post('payroll/configure/payroll-cutoff',['uses'=>'PayrollController@doSetPayrollCutoff','as'=>'payrollconfigure.payrollcutoff']);

// Payroll Component
Route::get('payroll/component/transaction-adjustment',['uses'=>'PayrollComponentController@transactionAdjustment','as'=>'payrollcomponenttrxadjust']);
Route::post('payroll/component/salary/adjust',['uses'=>'PayrollComponentController@doAdjustSalary','as'=>'salary.adjust']);
Route::post('payroll/component/add',['uses'=>'PayrollComponentController@doAddPayrollComponent','as'=>'payrollcomponent.add']);
Route::post('payroll/component/delete/{id}',['uses'=>'PayrollComponentController@doDeleteComponent','as'=>'payrollcomponent.delete']);
Route::get('payroll/component/detail/{id}',['uses'=>'PayrollComponentController@detailComponent','as'=>'payrollcomponent.detail']);
Route::get('payroll/component/getID/{type?}',['uses'=>'PayrollComponentController@getTransactionID','as'=>'payroll.adjustment.getid']);
Route::post('payroll/component/salary/new',['uses'=>'PayrollComponentController@doCreateNewSalary','as'=>'salary.new']);
Route::post('payroll/component/adjustment/new',['uses'=>'PayrollComponentController@doCreateAdjustComponent','as'=>'payroll.adjustment.new']);
Route::post('payroll/component/adjustment/edit',['uses'=>'PayrollComponentController@doEditAdjustment','as'=>'payroll.adjustment.edit']);
Route::post('payroll/component/adjustment/delete/{id?}',['uses'=>'PayrollComponentController@doDeleteAdjustment','as'=>'payroll.adjustment.delete']);

// Payroll System
Route::get('payroll/system/import-payroll',['uses'=>'PayrollSystemController@importPayroll','as'=>'payrollsystemimport']);
Route::get('payroll/system/run-payroll',['uses'=>'PayrollSystemController@runPayroll','as'=>'payrollsystemrun']);
Route::get('payroll/call-data',['uses'=>'PayrollSystemController@callDataPayroll','as'=>'payroll.calldata']);
Route::get('payroll/system/payroll-detail/{id}',['uses'=>'PayrollSystemController@doGetPayrollDetail','as'=>'payrollgetdetail']);
Route::post('payroll/system/payroll-detail/',['uses'=>'PayrollSystemController@doSubmitEditPayroll','as'=>'payrolleditdetail']);

Route::get('payroll/system/salary-detail',['uses'=>'PayrollSystemController@salaryDetail','as'=>'payrollsystemsalarydetail']);

Route::get('payroll/system/process-payroll',['uses'=>'PayrollSystemController@processPayroll','as'=>'payrollsystemprocess']);
// Route to show view for list Employee
Route::get('getdataemployee',['uses'=>'EmployeeController@getData','as'=>'getemployee']);
// Route::get('fortesting',['uses'=>'Auth\AuthController@forTesting']);
// Route to validate and save employee
// Route to delete employee
// EMPLOYEE



// SETTINGS
Route::get('setting/personal',['uses' => 'SettingController@personal', 'as' => 'settingpersonal']);
Route::get('setting/useraccess',['uses' => 'SettingController@useraccess', 'as' => 'settinguseraccess']);
Route::get('setting/recommendation',['uses'=>'SettingController@recommendation','as'=>'settingrecommendation']);
//Sending Email Via Setting/Recomendation
Route::post('setting/sendemail',['uses'=>'SettingController@doSentMail','as'=>'sendemailrecomendation']);
//Update Acces Role
Route::post('setting/updaterole',['uses'=>'SettingController@doUpdateAccessRole','as'=>'updateaccessrole']);

Route::get('setting/company-information',['uses'=>'SettingController@companyInfo','as'=>'settingcompanyinfo']);
Route::post('setting/update-company-detail',['uses'=>'SettingController@doUpdateCompanyDetail','as'=>'setting.update.company-detail']);

Route::post('setting/add-department',['uses'=>'SettingController@doAddDepartment','as'=>'setting.department.add']);
Route::post('setting/add-jobposition',['uses'=>'SettingController@doAddJobPosition','as'=>'setting.job.add']);
Route::post('setting/delete-department',['uses'=>'SettingController@doDeleteDepartment','as'=>'setting.department.delete']);
Route::post('setting/update-department',['uses'=>'SettingController@doUpdateDepartment','as'=>'setting.department.update']);
Route::post('setting/update-job',['uses'=>'SettingController@doUpdateJobPosition','as'=>'setting.job.update']);
Route::post('setting/update-text-department',['uses'=>'SettingController@doUpdateTextDepartment','as'=>'setting.department.update-text']);
Route::post('setting/update-text-job',['uses'=>'SettingController@doUpdateTextJobPosition','as'=>'setting.job.update-text']);

Route::post('setting/delete-jobposition',['uses'=>'SettingController@doDeleteJobPosition','as'=>'setting.job.delete']);
Route::get('setting/company-configuration',['uses'=>'SettingController@companyConfig','as'=>'settingcompanyconfig']);
Route::get('setting/payroll-configuration',['uses'=>'SettingController@payrollConfig','as'=>'settingpayrollconfig']);
Route::get('setting/ess-configuration',['uses'=>'SettingController@essConfig','as'=>'settingessconfig']);

Route::post('setting/personaless',['uses'=>'SettingController@doPersonalESS','as'=>'settingpersonaless']);
Route::post('setting/working-shift',['uses'=>'SettingController@doUpdateWorkingShift','as'=>'setting.workingshift']);
// SETTINGS


// FOR SERVICES GET DATA
Route::get('services/get-city/{name}',['uses'=>'ServiceJsonController@getCityJson','as'=>'getcityjson']);
// FOR SERVICES GET DATA

// ATTENDANCE
Route::get('attendance',['uses'=>'AttendanceController@index','as'=>'attendance']);
Route::get('attendance/range',['uses'=>'AttendanceController@getAttendanceInRange','as'=>'attendance.range']);
Route::get('attendance-detail',['uses'=>'AttendanceController@detail','as'=>'attendancedetail']);

Route::post('attendance/create',['uses'=>'AttendanceController@doCreateAttendance','as'=>'attendance.create']);
Route::post('attendance/create-mass',['uses'=>'AttendanceController@doMassInsert','as'=>'attendance.massinsert']);

// APPROVEMENT
Route::get('emailapprove/{type_ref}/{fk_ref}/{receiver}/{status?}',['uses'=>'ApprovementController@approveFromEmail','as'=>'approve.fromemail']);
Route::post('approve',['uses'=>'MessageController@doApprove','as'=>'approverequest']);
Route::post('reject',['uses'=>'MessageController@doReject','as'=>'rejectrequest']);

// TIME OFF
Route::get('timeoff',['uses'=>'TimeoffController@index','as'=>'timeoff']);
Route::post('timeoff/create',['uses'=>'TimeoffController@doCreate','as'=>'timeoff.create']);
Route::get('timeoff/report-by-employee',['uses'=>'TimeoffController@reportByEmployee','as'=>'timeoffreportbyemployee']);
Route::get('timeoff/setting',['uses'=>'TimeoffController@setting','as'=>'timeoffsetting']);
Route::post('timeoff/request',['uses'=>'TimeoffController@doRequest','as'=>'timeoff.request']);
Route::get('timeoff/transaction',['uses'=>'TimeoffController@transaction','as'=>'timeofftransaction']);
Route::get('timeoff/transaction-detail',['uses'=>'TimeoffController@transactionDetail','as'=>'timeofftransactiondetail']);
Route::get('timeoff/policy/detail/{id?}',['uses'=>'TimeoffController@getPolicyDetail','as'=>'timeoffpolicydetail']);
Route::post('timeoff/policy/delete',['uses'=>'TimeoffController@doDeletePolicy','as'=>'timeoffdeletepolicy']);
Route::get('timeoff/detail/{id?}',['uses'=>'TimeoffController@getRequestDetail','as'=>'timeoffdetail']);
Route::get('timeoff/detail/history/{id?}',['uses'=>'TimeoffController@getHistoryDetail','as'=>'timeoffhistorydetail']);
Route::get('timeoff/history/{month?}/{year?}',['uses'=>'TimeoffController@getHistoryList','as'=>'timeoffhistory']);
// Route::get('timeoff?month={month?}&year={year?}',['uses'=>'TimeoffController@getHistoryList','as'=>'timeoffhistory']);
Route::post('timeoff/approve',['uses'=>'TimeoffController@doApprove','as'=>'timeoffapprove']);
Route::post('timeoff/reject',['uses'=>'TimeoffController@doReject','as'=>'timeoffreject']);
Route::get('timeoff/balance-list/{id?}',['uses'=>'TimeoffController@getTimeOffBalances','as'=>'timeoffbalancelist']);
Route::get('timeoff/edit/{id?}',['uses'=>'TimeoffController@getTimeOffAssign','as'=>'timeoff.edit.assign']);
Route::post('timeoff/edit',['uses'=>'TimeoffController@editTimeOffAssign','as'=>'timeoff.edit.assign']);
Route::post('timeoff/editbalance',['uses'=>'TimeoffController@editQuota','as'=>'timeoff.edit.balance']);
Route::get('timeoff/employees/{$id}',['uses'=>'TimeoffController@getEmployeeAssign','as'=>'timeoff.employees.assign']);
// MESSAGE
Route::get('message/index/{trigger?}',['uses'=>'MessageController@index','as'=>'message']);
Route::get('message/list/{boxType}/{searchKey?}',['uses'=>'MessageController@loadMessages','as'=>'loadmessages']);
Route::post('message/send',['uses'=>'MessageController@sendMessage','as'=>'sendmessage']);
Route::get('message/r/{messageID}/{isInbox?}/{checkValidity?}',['uses'=>'MessageController@readMessage','as'=>'readmessage']);
Route::get('message/read/{hashString}',['uses'=>'Auth\AuthController@doForceLogin','as'=>'readfromemail']);
Route::post('message/delete/{isInbox?}',['uses'=>'MessageController@deleteMessage','as'=>'deletemessage']);
Route::get('message/getrecipient',['uses'=>'MessageController@getRecipient','as'=>'getmessagerecipient']);
Route::get('message/countnotif',['uses'=>'MessageController@countEachUnreadMessage','as'=>'countmessagenotif']);
Route::get('message/sendemail',['uses'=>'MessageController@sendEmailNotification','as'=>'sendemailnotification']);

//Report
Route::get('report/{month}/{year}',['uses'=>'ReportController@index','as'=>'reportindex']);
Route::get('report/salary-detail/{month}/{year}',['uses'=>'ReportController@salaryDetail','as'=>'report.salarydetail']);
Route::get('report/salary-detail/pdf/{month}/{year}',['uses'=>'ReportController@salaryDetailPDF','as'=>'report.salarydetail.pdf']);
Route::get('report/payslip/{month}/{year}',['uses'=>'ReportController@payslipIndex','as'=>'reportpayslip']);
Route::get('report/payslip/{id}/{month}/{year}',['uses'=>'ReportController@payslipDetail','as'=>'report.payslip.detail']);
Route::get('report/xls',['uses'=>'ReportController@xlsReport','as'=>'report.xls']);
Route::get('report/payslip/pdf/{type}/{id}/{month}/{year}',['uses'=>'ReportController@payslipPdf','as'=>'reportpayslippdf']);
// Report - Tax
Route::get('report/tax/1721-a1/{type}/{id}',['uses'=>'ReportController@tax1721a1','as'=>'reporttax1721a1']);
Route::get('report/tax/1721-vi/{type}/{id}',['uses'=>'ReportController@tax1721vi','as'=>'reporttax1721vi']);
Route::get('report/tax/1721-vii/{type}/{id}',['uses'=>'ReportController@tax1721vii','as'=>'reporttax1721vii']);

// REIMBURSEMENT
Route::get('reimbursement',['uses'=>'ReimbursementController@index','as'=>'reimbursement.index']);
Route::post('reimbursement/create',['uses'=>'ReimbursementController@doCreate','as'=>'reimbursement.create']);
Route::get('reimbursement/balance-list/{policy_id_fk?}',['uses'=>'ReimbursementController@getReimbursementBalance','as'=>'reimbursementbalancelist']);
Route::get('reimbursement/edit/{id?}',['uses'=>'ReimbursementController@getReimbursementAssign','as'=>'reimbursement.edit.assign']);
Route::post('reimbursement/edit',['uses'=>'ReimbursementController@editReimbursementAssign','as'=>'reimbursement.edit.assign']);
Route::post('reimbursement/editbalance',['uses'=>'ReimbursementController@editQuota','as'=>'reimbursement.edit.balance']);
Route::post('reimbursement/request',['uses'=>'ReimbursementController@doRequest','as'=>'reimbursement.request']);
Route::post('reimbursement/policy/expired',['uses'=>'ReimbursementController@doExpire','as'=>'reimbursement.policy.expire']);
Route::post('reimbursement/request/approve',['uses'=>'ReimbursementController@doApprove','as'=>'reimbursement.approve']);
Route::post('reimbursement/request/reject',['uses'=>'ReimbursementController@doReject','as'=>'reimbursement.reject']);
Route::get('reimbursement/policy/detail',['uses'=>'ReimbursementController@getPolicyDetail','as'=>'reimbursement.policy.detail']);
Route::get('reimbursement/request/detail',['uses'=>'ReimbursementController@getRequestDetail','as'=>'reimbursement.request.detail']);
Route::get('reimbursement/history/detail',['uses'=>'ReimbursementController@getHistoryDetail','as'=>'reimbursement.history.detail']);

// CALENDAR
Route::get('calendar',['uses'=>'CalendarController@index','as'=>'calendar.index']);
Route::get('calendar/events/timeoff/{limitDays?}',['uses'=>'CalendarController@getTimeoffList','as'=>'calendar.events.timeoff']);
Route::get('calendar/events/birthday',['uses'=>'CalendarController@getBirthdayList','as'=>'calendar.events.birthday']);

// ACCESS TOKEN
Route::get('access/{token}/{status?}',['uses'=>'AccessTokenController@access','as'=>'access.token']);
Route::get('testing',['uses'=>'ServiceController@testing','as'=>'testingPage']);
Route::get('test', function () {
  	// this checks for the event
});
