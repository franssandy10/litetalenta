<?php

namespace App\Models;
use Config;
use App\Models\CustomModelCompany;
class Department extends CustomModelCompany
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'department';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = ['name','parent_id_fk'];

    protected $messages=[];
    protected $rules=array(
      'name' => 'required|max:255',
      );
    protected $attributeNames=[
      'name'=>'Department Name',
    ];
    
}
