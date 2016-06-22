<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Auth;
use Department;
use Organization;
use App\Models\CustomModel;
class Company extends CustomModel
{
  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'company';
  protected $rules=array(
    'name' => 'required|max:255',
    'email'=>'required|email|max:255',
    'address'=>'required',
    'phone'=>'required|min:6',
    'postcode'=>'required|numeric',
    'province_id_fk'=>'required',
    'city'=>'required');
  protected $attributeNames=[
    'name'=>'Company Name',
    'email'=>'Email',
    'address'=>'Address',
    'phone'=>'Phone',
    'postcode'=>'Postcode',
    'province_id_fk'=>'Province',
    'city'=>'City'
  ];
  protected $messages=[];
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = ['name','email','address','phone','postcode','province_id_fk','city', 'token'];

}
