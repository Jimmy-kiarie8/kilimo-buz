<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use User;

use Session;
use Modules\Usermanagement\Entities\Organization;
class SetUp
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
          if(Auth::User()->hasRole(['Organization']))
          {
            $user=Auth::user();
            $organization=Organization::find($user->org_id);
              
               if($organization && ($organization->Status==0))
               {
                Session::flash("info_msg","You have to complete your Organization profile before using this portal");
                return redirect('/System/Profile/BasicDetails');

               }
             
             
                 

          }
         
        return $next($request);
    }
}
