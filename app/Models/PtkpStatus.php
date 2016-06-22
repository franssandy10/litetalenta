<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\CustomModel;
class PtkpStatus extends CustomModel
{
    //
    protected $fillable=['effective_date','tk0','tk1','tk2','tk3','k0','k1','k2','k3'];
}
