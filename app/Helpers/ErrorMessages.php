<?php // Code within app\Helpers\Helper.php

namespace App\Helpers;
use Illuminate\Support\Facades\Input;
use Auth;
use Response;
use App\User;
use Session;
use Hash;
use DateTime;
use Mail;
use Validator;
use Redirect;

;
class  ErrorMessages
{

   public  static function getMessageDescription($resultID)
 {
     switch ($resultID) {
      
         case '1':
           $message="Approved Successfully";
             break;

         case '2':
           $message="Duplicate Entry.User Error Code:".$resultID;
             break;
             case '3':
           $message="You Cannot Approve A Record You have Submitted.It Has To Be A different Person To Approve.User Error Code:".$resultID;
             break;
             case '200':
             $message="Not Successful.Active Request Pending Approval.User Error Code: ".$resultID;
             break;


         
         default:
             $message="Message NoT Defined".$resultID;
             break;
     }

     return $message;
  
 }

 


  
 
}