<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\CustomModelCompany;

class WorkingShift extends CustomModelCompany
{
    protected $fillable = ['start_hour','start_minute','end_hour','end_minute','day'];

    protected $messages=[];
    protected $rules=array(
      'start_hour' => 'required|numeric|max:23',
      'start_minute'=>'required|numeric|max:59',
      'end_hour' => 'required|numeric|max:23',
      'end_minute'=>'required|numeric|max:59',
      'working_days'=>'required',
      );
    protected $attributeNames=[
      'start_hour' => 'Start Hour',
      'start_minute'=>'Start Minute',
      'end_hour' => 'End Hour',
      'end_minute'=>'End Minute',
      'working_days'=>'Working Day',
    ];
}
