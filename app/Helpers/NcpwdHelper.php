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
use Modules\Account\Entities\CharterOfAccount;
use Validator;
use Redirect;
use App\SystemLog;

;
class NcpwdHelper
{

   public  static function ValidateRecord($number)
   {

  
      $encripted_token=self::generateToken();
        

      $accessDetails=Self::getNCPWDToken($encripted_token);
        
       $data=json_decode($accessDetails);
        if($data->success)
        {
           $access_token=$data->access_token;
        if(strlen( $access_token)>0)
        {
           $details=self::QueryDetails($access_token,$number);
           $personal_data=json_decode($details);
              if($personal_data->success==true)
              {
                return  $personal_data->Details;
              
              }else{
                return 0;
              }
            
        }

        }else{
          return 0;
        }
        
     

    
   }
   public static function getNCPWDToken($token)
   {
    try{
    $curl = curl_init("http://197.248.205.94:86/Apiapp/api/GetAccessToken");
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
         'token:'.$token
    ));

    $result = curl_exec($curl);
    curl_close($curl);
      ;
    return $result;

    }catch(\Exception $e)
    { 
      return  $e;

    }

   }

   public  static function generateToken()
   {
       try{

    $Secret_key="346733807198027";
    $API_key="5H6OQXODIFUNESYGVIQ795IVWFNQAC5PXUOVEGNDMZ61M5H3TKMAU1XDD8SPWULS";
    $token=base64_encode($Secret_key.":".$API_key);
       return $token;
        }catch(\Exception $e)
         {

           return false;

         }

   }


   public static  function QueryDetails($accessToken,$number)
   {
     try{
       $data = array(
       "number" =>$number,
       "access_token"=>$accessToken,
        );
    $data_string = json_encode($data);

    $curl = curl_init("http://197.248.205.94:86/Apiapp/api/GetDetails");
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Content-Length: ' . strlen($data_string))
    );

    $result = curl_exec($curl);
    curl_close($curl);

      
       
    return $result;

     }catch(\Exception $e)
     {

     }
          
   

   }






  
 
}