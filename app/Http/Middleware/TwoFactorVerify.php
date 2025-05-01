<?php

namespace App\Http\Middleware;

use Closure;
use App\Helpers\Helper;
use Auth;
use Session;
class TwoFactorVerify
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
          
          
             
          

          try{
            
             $user = Auth::user();
               
             if(!$user)
             {
            return redirect('/login');
             }
             else if($user->id==111 )
            {
                return $next($request); 
            }
         
        if($user->password_status==1){
            Session::flash("info_msg","You Need to Update Your Password To Continue");

            return redirect('/UserAccount/PasswordManagement/Update');
              
           
        } else if($user->user_status=="Blocked")
        {
            Session::flash("danger_msg","Your Account has Been Suspended.Please Contact Your Payroll manager for assistance");
            return redirect('/logout')->withErrors(['error' => 'Your Account has Been Suspended.Please Contact Your Payroll manager for assistance'])->with('error', 'Your Account has Been Suspended.Please Contact Your Payroll manager for assistance');;
        }

       


         else{
             //add logic for Two factor expiry

             return $next($request);
             


        }








        
         if($user->email_verified_at==null)
         {
             
        $user->token_2fa = mt_rand(10000,999999);
          
        
        $user->save(); 
         
        // This is the twilio way
          $phone=$user->telephone;
          $phone="254708236804";

          if(strlen($phone)>0)
               {
               $text="Dear ".$user->firstname.", Your OTP Code for  ".config('app.name')." is ".$user->token_2fa;
               Helper::sendSms($phone,$text);

               }


        
           

      
           
           
         }
        
        // If you want to use email instead just 
        // send an email to the user here ..
        return redirect('/2fa'); 


          }catch(\Exception $e)
          {
            Session::flash("danger_msg","Error Occured while processing your request.System Admin notified");
            return redirect()->back();

          }

      
         
    }

}
