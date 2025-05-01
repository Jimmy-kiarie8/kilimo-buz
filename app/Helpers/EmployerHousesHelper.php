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

     public static function getAgentCountiesZoneList($AgentCountyCode)
   {
    try{
       
          $procedurename="proc_List_Global_EmployerHouses_Zones";
            $designmodels= $models= DB::connection("sqlsrv")->select('exec  [dbo].['.$procedurename.']@kOperationFlag=?,@KCombinedKey=?',array(6,$AgentCountyCode) );
          $models=(collect($designmodels)->pluck('HouseZoneName','HouseZoneCode'));
        return  $models->toArray();
        }catch(\Exception $e)
        {
            return array();
        }

   }



   public static function getAgentZoneHouseList($AgentZoneCode)
   {
      try{
       
          $procedurename="proc_List_Global_EmployerHouses_inaZone";
            $designmodels= $models= DB::connection("sqlsrv")->select('exec  [dbo].['.$procedurename.']@kOperationFlag=?,@KCombinedKey=?',array(6,$AgentZoneCode) );
          $models=(collect($designmodels)->pluck('HouseDesc','HouseCode'));
        return  $models->toArray();
        }catch(\Exception $e)
        {
         
            return array();
        }

   }



 
  }
