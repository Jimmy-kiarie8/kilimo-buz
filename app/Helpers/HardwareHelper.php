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
class HardwareHelper
{

  public static function getDeviceSerialNumber()
  {
    
      try{

        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
    // Windows
            exec('wmic bios get serialnumber 2>&1', $output);
    // The serial number should be in the second element of the output array
    $serialNumber = trim($output[1]);
        } else {
    // Linux, Unix, macOS
        exec('sudo dmidecode -s system-serial-number 2>&1', $output);
    // The serial number should be in the first element of the output array
        $serialNumber = trim($output[0]);
          }

             return $serialNumber;
         }catch(\Exception $e)
      {

        return 0;

      }

     

  }
  }




























