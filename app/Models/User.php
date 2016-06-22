<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use App\Models\Employee;
use App\Models\UserAccessRole;
use App\Models\Company;
use App\Models\CustomModel;
use App\Models\UserAccessConnection;
use Cartalyst\Sentinel\Users\EloquentUser;
use Validator;
use Sentinel;
use Illuminate\Database\Eloquent\SoftDeletes;
class User extends EloquentUser
{
    /**
     * The Eloquent roles model name.
     *
     * @var string
     */
    protected static $rolesModel = 'App\Models\SentinelRole';

    /**
     * The Eloquent persistences model name.
     *
     * @var string
     */
    protected static $persistencesModel = 'App\Models\SentinelPresistence';

    /**
     * The Eloquent activations model name.
     *
     * @var string
     */
    protected static $activationsModel = 'App\Models\SentinelActivations';

    /**
     * The Eloquent reminders model name.
     *
     * @var string
     */
    protected static $remindersModel = 'Cartalyst\Sentinel\Reminders\EloquentReminder';

    /**
     * The Eloquent throttling model name.
     *
     * @var string
     */
    protected static $throttlingModel = 'App\Models\SentinelThrottle';
    protected $connection="mysql";
    public $timestamps=false;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'user_access';

     /**
      * The attributes that are mass assignable.
      *
      * @var array
      */
     private $company;

     protected $fillable = ['name', 'email', 'password','company_id_fk','phone','last_login','ip_address','permissions'];
     /**
      * The attributes excluded from the model's JSON form.
      *
      * @var array
      */
     protected $hidden = ['password', 'remember_token'];
     protected $dates=['last_login'];
     /**
      * redeclare variable
      * @var [type]
      */
    protected $rules=[
      'name' => 'required|alpha_spaces|max:255',
      'email'=>'required|email|max:255',
      'password'=>'required|confirmed',
      'phone'=>'min:6'];

    protected $attributeNames=[
      'name'=>'Full Name',
      'email'=>'Email',
      'password'=>'Password',
      'phone'=>'Phone',
      'company_name'=>'Company Name'
    ];
    protected $messages=[
      'g-recaptcha-response.required' => 'Captcha is Required'
    ];
    /********************************************************* FOR DEFAULT FUNCTION ******************************************************************************/

    /**
     * validator base on rules
     * @param  array $data that want to validate
     * @return boolean
     */
    public function validate(array $data)
    {
       // make a new validator object
       $v = Validator::make($data, $this->rules,$this->messages);
       $v->setAttributeNames($this->attributeNames);
       // check for failure
        if ($v->fails())
        {
            // set errors and return false
            $this->errors = $v->errors();
            return false;
        }
        return true;
    }
    /**
     * insert data if validator true
     * @param  array $data
     */
    protected function insertData(array $data){
      foreach($this->rules as $key=>$value){
        if(array_key_exists($key,$data)){
          $this->$key=$data[$key];
        }
      }
      $this->save();
    }
    /**
     * getter error after validation
     * @return object errors
     */
    public function errors()
    {
       return $this->errors;
    }
    public function getAttributeNames(){
      return $this->attributeNames;
    }
    /********************************************************* FOR RELATIONSHIP ******************************************************************************/

    /**
     * get relationship employee data
     * @return object employee
     */
    protected function userAccessConnection(){
      return $this->belongsTo('App\Models\UserAccessConnection','id','user_access_id_fk');
    }
    /**
     * get relationship with employee department link by userEmployee
     * @return object department
     */
    protected function userDepartment(){
        return $this->userEmployee->employeeDepartment;
    }

    /**
     * get relationship with user company
     * @return object company
     */
    protected function userCompany(){
      return $this->belongsTo('App\Models\Company','company_id_fk','id');
    }

    /**
     * get relationship with message sender
     * @return object message
     */
    protected function userMessageSender(){
      return $this->hasMany('App\Models\Message','sender_id_fk','id');
    }

    /**
     * get relationship with message sender
     * @return object message
     */
    protected function userMessageReceiver(){
      return $this->hasMany('App\Models\Message','receiver_id_fk','id');
    }

    /********************************************************* FOR SET CUSTOM RULES ******************************************************************************/
    /**
     * set rules for change password
     */
    public function setRulesChangePassword(){
      $this->rules=array(
        'current_password'=>'required|current_password',
        'new_password'=>'required|password_validator|confirmed',

      );
      $this->attributeNames=[
        'current_password'=>'Current Password',
        'new_password'=>'New Password'
      ];
    }
    /**
     * set rules for change avatar
     */
    public function setRulesChangeAvatar(){
      $this->rules=array(
        'file_name'=>'file_type',
      );
      $this->attributeNames=[
        'file_name'=>'File Type',
      ];
    }
    public function setRulesForgotPassword(){
      $this->rules=[
        'email'=>'required|email|max:255',
        'g-recaptcha-response' => 'required|captcha'
      ];
      $this->attributeNames=[
        'email'=>'Email',
      ];

    }
    public function setRulesResetPassword(){
      $this->rules=array(
        'new_password'=>'required|password_validator|confirmed'

      );
      $this->attributeNames=[
        'new_password'=>'New Password'
      ];
    }
    /********************************************************* FOR CUSTOM FUNCTION ******************************************************************************/
    /**
     * get full name
     * @return string full_name
     */
    public function getFullName(){
      $employeeDetail=$this->userAccessConnection->userEmployee;
      if($employeeDetail){
        $full_name=$employeeDetail->first_name." ".$employeeDetail->last_name;
      }
      else{
        $full_name=$userDetail['full_name']=$this->name;
      }
      return $full_name;
    }
    /**
     * get detail user access
     * @return array userDetail
     */
    public function getDetailUserAccess(){
      // Get detail from user access
      $userDetail=array();

      $userDetail['full_name']= $this->getFullName();
      $userDetail['name_access']=$this->getRoles()[0]->name;
     $userDetail['slug']=$this->getRoles()[0]->slug;
      return $userDetail;
    }

    /**
     * [changeAvatar change avatar user is login]
     * @param  [string] $filename [name for file want to upload]
     */
    public function changeAvatar($filename){
      $model=UserAccessConnection::where('user_access_id_fk',$this->id)->update(['avatar'=>$filename]);
      return true;
    }
    /**
     * [getData get data with company_id_fk]
     * @return [type] [description]
     */
    public function getData(){
      return $this->where('company_id_fk',Sentinel::getUser()->company_id_fk)->where('id','!=',Sentinel::getUser()->id)->get();
    }


}
