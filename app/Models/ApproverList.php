<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\CustomModelCompany;

class ApproverList extends CustomModelCompany
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['policy_type','policy_id_fk','approver_id_fk'];
    // Relationship for approver
    protected function getApprover(){
       return $this->belongsTo('App\Models\User','approver_id_fk','id');
    }
}
