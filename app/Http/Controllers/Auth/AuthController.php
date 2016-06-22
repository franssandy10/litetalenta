<?php

namespace App\Http\Controllers\Auth;


use Validator;
use Redis;
use Artisan;
use Config;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Database\Schema\Blueprint;
use App\Http\Controllers\DatabaseController;
use App\Models\Company;
use App\Models\User;
use Carbon\Carbon;
use App\Models\Department;
use App\Models\DepartmentStructure;
use App\Models\JobPosition;
use App\Models\JobPositionStructure;
use App\Models\TaxPerson;
use App\Models\TimeOffPolicies;
use Illuminate\Support\ViewErrorBag;
use App\Models\UserAccessConnection;
use App\Models\Message;
use Sentinel;
use Redirect;
use Session;
class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;
    protected $loginPath = '/login';
    protected $redirectPath = '/dashboard';
    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'doLogout']);
    }
    /**
     * Handle an user to logout.
     * @param $email,$password
     * @return Response
     */
    protected function doLogout(Request $request){
      Sentinel::logout();
      return redirect('/');

    }

    /**
     * Handle an authentication attempt.
     * @param $email,Rpassword
     * @return Response
     */


    private function extractIdFromToken($id){
        // get digit of id dipaling belakang
        $getLengthId=(int)substr($id,-1);
        // get digit of random string
        $getLength=substr($id,-2,-1);
        $getFirstHash=substr($id,0,-2);
        $getPosition=(int)substr($getFirstHash,-$getLength);
        $getSecondHash=substr($getFirstHash,0,-$getLength);
        // get  string before id
        $firstString=substr($getSecondHash,0,$getPosition);
        // get  string after id
        $secondString=substr($getSecondHash,$getPosition+$getLengthId);
        // get id
        $getId=substr($getFirstHash,$getPosition,$getLengthId);
        // combine code
        $getCode=$firstString.$secondString;
        return ['id'=>$getId,'code'=>$getCode];
    }

    /** for viewing message via e-mail notification
      * user will be logged-in automatically
      */
    protected function doForceLogin($hashString)
    {
        //decode userID and code
        $arr = $this->extractIdFromToken($hashString);

        //get messageID
        $IDlength = substr($arr['code'],-1);
        $messageID = substr($arr['code'],31-$IDlength,-1);

        $message = Message::find($messageID);
        if ($message->receiver_id_fk == $arr['id']){
            $user = User::findOrFail($arr['id']);
            if(Sentinel::login($user)) {
              return redirect()->route('message',['trigger'=>$messageID]);
            }
            else return 'false';
        }else return;
    }

    protected function authenticate($email,$password)
    {
        if (Sentinel::authenticate(['email' => $email, 'password' => $password])) {
            // Authentication passed...
          return "success";
          // return redirect('home');
          // return redirect()->intended('dashboard');
        }
        else{
          return ["Email or Password is wrong"];
        }
    }
    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
     protected function doLogin(Request $request){
        $validator= Validator::make($request->all(), [
            'email' => 'required|email|max:255',
            'password' => 'required|min:6',
        ]);
        if ($validator->fails()) {
          return response()->json($validator->messages(),422);
        }
        else{
          $result=$this->authenticate($request->input('email'),$request->input('password'));
          if($result!=='success'){
            return response()->json([$result],422);
          }
          $user=Sentinel::getUser();
          $user->last_login=Carbon::now();
          $user->ip_address=$request->ip();
          $user->save();
          return response()->json(['status'=>'success','url'=>Redirect::intended('dashboard')->getTargetUrl()]);
        }
    }
    /**
     * validate register if request doesn't hijack by javascript.
     *
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function doRegister(Request $request){

      if($request->input('submitButton')=='true'){
        $this->create($request->all());
        return redirect('login');
      }
      else{
        return $this->validatorRegister($request->all());
      }
    }
    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validatorRegister(array $data)
    {
        $validator = Validator::make($data, [
            'name' => 'required|max:255',
            'company_name'=>'required|max:255',
            'email'=>'required|max:255',
            'password'=>'required|confirmed',
        ]);
        if ($validator->fails()) {
          return response()->json($validator->messages());
          // return redirect('/')
          //       ->withInput()
          //       ->withErrors($validator);
        }
        else{
          return response()->json(['status'=>'success']);
        }
    }

    /**
     * Create a new user instance after a valid registration.
     * doesn't use just for template for pushing database
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        $resultCompany=Companies::create([
            'name' => $data['company_name'],
            'token'=> str_random(40),
        ]);
        $result=User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone'=>$data['phone'],
            'last_login'=>Carbon::now(),
            'company_id_fk'=>$resultCompany->id,
            'password' => bcrypt($data['password']),
        ]);
        $role = Sentinel::findRoleBySlug('superadmin');
        $role->users()->attach($result);
         (new DatabaseController)->create($resultCompany->id);
    }
    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function doCreateAccount()
    {

      // print_r("masuk nih ke create account");
      $data=array();
      $flag_empty=false;
      // check data
      $data=$this->setValueGettingStartedOne($data);
      // set error
      if($data===false){
        return redirect()->route('index');
      }
      $data=$this->setValueGettingStartedThreeFourFiveSix($data);
      if($data===false){
        return redirect()->route('index');
      }
      $resultCompany=Company::create([
          'name' => $data['company_name'],
          'email' => $data['email'],
          'phone'=>$data['phone'],
          'postcode'=>"",
          'address'=> "",
          'token'=> str_random(40),
      ]);
      $result=Sentinel::registerAndActivate([
          'name' => $data['name'],
          'email' => $data['email'],
          'company_id_fk'=>$resultCompany->id,
          'phone'=>$data['phone'],
          'last_login'=>Carbon::now(),
          'ip_address'=>$data['ip_address'],
          'password' =>$data['password'],
      ]);
      // ketika insert massnya cuman 1 input lebih bagus dijadikan seperti ini
      $model=new UserAccessConnection();
      $model->user_access_id_fk=$result->id;
      $model->company_id_fk=$resultCompany->id;
      $model->save();
      Sentinel::login($result);
      $role = Sentinel::findRoleBySlug('superadmin');
      $role->users()->attach($result);

      (new DatabaseController)->create($resultCompany->id);
      // Login

      // Login



      // insert initial holiday and sick
      if($data['holiday']&&$data['sick']){
        $model=new TimeoffPolicies();
        $model->name="Holiday";
        $model->balance=$data['holiday'];
        $model->effective_date=Carbon::now();
        $model->unlimited_flag=false;
        $model->policy_code='AL';
        $model->save();
        $model=new TimeoffPolicies();
        $model->name="Sick";
        $model->balance=$data['sick'];
        $model->effective_date=Carbon::now();
        $model->unlimited_flag=false;
        $model->policy_code='SL';
        $model->save();
      }



      if($data['payroll_flag']===true){
        $data=$this->setValueGettingStartedSeven($data);
        $model=new TaxPerson;
        $model->branch_id=NULL;
        $model->tax_person_name=$data['tax_person_name'];
        $model->tax_person_npwp=$data['tax_person_npwp'];
        $model->company_npwp=$data['company_npwp'];
        $model->bpjstk_number=$data['company_bpjstk'];
        $model->jkk_type=$data['company_jkk'];
        $model->npwp_date=$data['npwp_date'];
        $model->save();
      }

      $rawText='ada yang baru register nih di LiteTalenta!
      nama: '.$result->name.'
      company: '.$resultCompany->name.'
      email: '.$result->email;
      if (isset($result->phone)){
        $rawText.='phone: '.$result->phone;
      }
      \Mail::raw($rawText, function ($m) use ($resultCompany) {
          $m->from('no-reply@talenta.co');
          $m->to('carlos@talenta.co', 'Carlos'); //testing
          $m->cc('freddy@talenta.co', 'Freddy Wijaya');
          // $m->cc('joshua@talenta.co', 'Joshua Kevin');
          // $m->cc('fandy@talenta.co', 'Fandy Wie');
          $m->subject('New User @ LiteTalenta : '.$resultCompany->name);
      });

      return redirect('dashboard');
      print_r("create account page nih abz itu pindah dah ke menu homenya sklian auto signinnya");
      exit;

    }
    protected function setValueGettingStartedOne(array $data){
      // check getting started 1
      // check data name
      $flag_empty=false;
      $temp=session('one');
      if($temp['name']){
        $data['name']=$temp['name'];
      }
      else{
        $flag_empty=true;
      }
      // check data company name
      if($temp['company_name']){
        $data['company_name']=$temp['company_name'];
      }
      else{
        $flag_empty=true;
      }

      // check email
      if($temp['email']){
        $data['email']=$temp['email'];
      }
      else{
        $flag_empty=true;
      }
      // check phone
      if($temp['phone']){
        $data['phone']=$temp['phone'];
      }
      else{
        $data['phone']=NULL;

      }

      // check password
      if($temp['password']){
        $data['password']=$temp['password'];
      }
      else{
        $flag_empty=true;
      }
      $data['ip_address']=$temp['ip_address'];
      if($flag_empty==true){
        // dibuang ke keluar karena dia hijack
        return false;
        print_r("test");exit;
      }
      Session::forget('one');
      // Redis::del('one');
      // end getting started 1
      return $data;
    }

    protected function setValueGettingStartedThreeFourFiveSix(array $data){

      // getting started two
      // holiday
      $flag_empty=false;
      $temp=session('two');

      if($temp['holiday']){
        $data['holiday']=$temp['holiday'];
      }
      else{
        $data['holiday']=null;
      }
      // sick
      if($temp['sick']){
        $data['sick']=$temp['sick'];
      }
      else{
        $data['sick']=null;
      }
      // Redis::del('five');

      // end getting started 5
      // getting started 6
      if(session('payroll_flag')){
        if(session('payroll_flag')==='yes'){
          $data['payroll_flag']=true;
        }
        else if(session('payroll_flag')==='no'){
          $data['payroll_flag']=false;
        }
        else{
          $flag_empty=true;
        }
      }
      else{
        $flag_empty=true;
      }
      // end getting started 6
      if($flag_empty==true){
        return false;
        // dibuang ke keluar karena dia hijack
        print_r("empty nih");exit;
      }
      // Redis::del('payroll_flag');

      Session::forget('two');
      Session::forget('payroll_flag');
      return $data;
    }
    protected function setValueGettingStartedSeven(array $data){
      // check data name
      $flag_empty=false;
      $temp=session('four');

      if($temp['tax_person_name']){
        $data['tax_person_name']=$temp['tax_person_name'];
      }
      else{
        $flag_empty=true;
      }
      // check tax_person_npwp
      if($temp['tax_person_npwp']){
        $data['tax_person_npwp']=$temp['tax_person_npwp'];
      }
      else{
        $flag_empty=true;
      }
      // check company_npwp
      if($temp['company_npwp']){
        $data['company_npwp']=$temp['company_npwp'];
      }
      else{
        $flag_empty=true;
      }
      // check company_bpjstk
      if($temp['company_bpjstk']){
        $data['company_bpjstk']=$temp['company_bpjstk'];
      }
      else{
        $flag_empty=true;
      }
      // check company_jkk
      if($temp['company_jkk']){
        $data['company_jkk']=$temp['company_jkk'];
      }
      else{
        $flag_empty=true;
      }
      // check npwp_date
      if($temp['npwp_date']){
        $data['npwp_date']=$temp['npwp_date'];
      }
      else{
        $flag_empty=true;
      }
      if($flag_empty==true){
        // dibuang ke keluar karena dia hijack
        print_r("empty nih");exit;
      }
         Session::forget('four');
      // Redis::del('seven');

      return $data;
    }
    
}
