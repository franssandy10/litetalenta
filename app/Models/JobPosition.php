<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Config;
use App\Models\CustomModelCompany;
class JobPosition extends CustomModelCompany
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'job_position';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name','parent_id_fk'];
    protected $messages=[];
    protected $rules=array(
      'name' => 'required|max:255',
      'parent_id_fk'=>'numeric'
      );
    protected $attributeNames=[
      'name'=>'Job Name',
    ];
}
