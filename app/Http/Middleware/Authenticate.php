<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use Sentinel;
use Illuminate\Support\Facades\Route;
use Illuminate\Contracts\Auth\Guard;
use App\Models\UserAccessRoleStructure;

class Authenticate
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

      //for authenticate if guest and access page must authenticate
      if (Sentinel::guest()) {
          if ($request->ajax()) {
              return response('Unauthorized.', 401);
          } else {

              return redirect()->guest('login');
          }
      }





        return $next($request);
    }
}
