<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Config;
use Auth;
use App\Models\CustomModelCompany;
class TimeOffPolicies extends CustomModelCompany
{

    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'time_off_policies';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name','balance','effective_date','unlimited_flag','policy_code','default_flag'];
    protected $messages=[];
    protected $rules=array(
      'policy_code' => 'required|max:255',
      'name'=>'required',
      'effective_date'=>'required|date',
      'balance'=>'required|numeric',
      'assign_date'=>'required|date',
      );
    protected $attributeNames=[
      'policy_code'=>'Policy Code',
      'name'=>'Policy Name',
      'effective_date'=>'Effective Date',
      'balance'=>'Balance',
      'assign_date'=>'Assign Date',
    ];
    /**
     * get relationship with sender user
     * @return object user
     */
    
}
