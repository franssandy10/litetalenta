<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\UserAccessRoleStructure;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Facades\Route;
use Sentinel;

class RoleMiddleware
{
    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth;

    /**
     * Create a new filter instance.
     *
     * @param  Guard  $auth
     * @return void
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

      // $result=$this->auth->user()->userAccessRole->userAccessRoleStructures->where('access_route',Route::getCurrentRoute()->getName())->first();
      // jika user login is superadmin
      if(Sentinel::inRole('superadmin')){

      }
      // if(!$result){
      //   // if doesn't have privilege move to dashboard
      //   return redirect('/dashboard');
      // }

      return $next($request);
    }
}
