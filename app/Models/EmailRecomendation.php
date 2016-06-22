<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailRecomendation extends CustomModel
{
    protected $fillable =[
    	'name',
    	'email'
    ];
}
