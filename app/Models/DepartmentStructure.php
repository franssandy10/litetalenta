<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Auth;
use Config;
use App\Models\CustomModelCompany;
class DepartmentStructure extends CustomModelCompany
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'department_structure';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = ['parent_id_fk', 'child_id_fk'];
    /**
     *
     * DOCUMENTATION FOR DATABASE HIRARCHI DepartmentStructure
     * parent_id_FK is the first parent if doesn't have parent then parent is 0
     *
     */
     protected $rules=array(
       'department_id_fk' => 'required|numeric',
       'child_id_fk' => 'required|numeric',

       );
     protected $attributeNames=[];
}
