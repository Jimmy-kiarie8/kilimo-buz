<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Auth;
use Modules\Usermanagement\Entities\Institution;

class FirstTimeeLogIn
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
    	 $user=Auth::User();
    	   if(Auth::User()->hasRole(['Organization Manager','Organization Staff']))
    	   {
    	   	  $institution=Institution::where(['Registration_number'=>$user->org_id])->first();
    	   	      if($institution)
    	   	      {
    	   	      	$status=$institution->Verified;
    	   	      	  if($status=="0")
    	   	      	  {
    	   	      	  	$data['page_title']="Account Pending Verification";
    	   	      	  	return redirect('/InstitutionModule/Institution/AccountVerification');
    	   	      	  }else{
    	   	      	  	 $Statuslevel=$institution->Statuslevel;
    	   	      	  	   if($Statuslevel==2)
    	   	      	  	   {
    	   	      	  	   	$data['page_title']="Complete Institution Registration";
    	   	      	  	    return redirect('/InstitutionModule/Institution/InstitutionRegistration');

    	   	      	  	   }

                           else if($Statuslevel==3)
                           {
                            $data['page_title']="Account Pending Review";
                            return redirect('/InstitutionModule/Institution/PendingReview');

                           }

    	   	      	  	 
    	   	      	  }



    	   	      }


    	   }

        return $next($request);
    }
}
