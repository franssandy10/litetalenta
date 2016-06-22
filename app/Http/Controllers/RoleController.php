<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Sentinel;
class RoleController extends Controller
{
    public function setRole(){
      $role = Sentinel::findRoleById(1);

      $role->permissions = [
          'user.update' => true,
          'user.view' => true,
      ];

      $role->save();
    }
}
