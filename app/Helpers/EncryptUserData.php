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
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Collection;
use DB;
class EncryptUserData
{


  public  static function  Enctypt($fieldData,$OrgID)
  {
    $UnEncryptedString="ODOA-".date("Ymdhis")."-".$fieldData."-".$OrgID;
    $EncryptedStyring=base64_encode($UnEncryptedString);
    return $EncryptedStyring;
  }



  public  static function  Dectypt($fieldData)
  {
    $descriptedString=base64_decode($fieldData);
    $splitString=explode("-", $descriptedString);
      if(is_array($splitString)&& sizeof($splitString)>=2)
      {
        $payrollnumber=$splitString[2];
        $date=$splitString[1];
        $postdate=date('Ymd',strtotime($date));
        $todate=date('Ymd');

           if($todate==$postdate)
           {
            return $payrollnumber;
           }else{
            return 2;
           }

        
      }else{
        return "1";
      }



    

  }


}