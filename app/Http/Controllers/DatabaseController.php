<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Config;
use DB;
use Artisan;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class DatabaseController extends Controller
{
    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('guest', ['except' => 'getLogout']);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id){
      DB::statement("CREATE DATABASE IF NOT EXISTS ".Config::get('app.database_name_company').$id);
      Config::set('database.connections.company.database',Config::get('app.database_name_company').$id);
      Artisan::call('migrate', [
        '--path'     => "database/migrations/company",
        '--database' => "company"
        ]);
      return "finish";
    }
}
