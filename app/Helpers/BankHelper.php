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
use App\AfricasTalkingGateway;
use App\SystemModule;
use App\ProviderModule;
use Modules\Usermanagement\Entities\WorkFlow;
use Modules\Usermanagement\Entities\Role;
use Validator;
use Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Collection;
use App\Models\Message;
use App\CentralTransaction;
use App\Messaging;
use App\Profile;
use DB;
use Modules\Account\Entities\CentralPayment;
use Modules\Usermanagement\Entities\Region;
class BankHelper
{

  public static function getBankBranches($bankCode)
  {
    
      try{
          $procedurename="proc_List_BankBranches";
        $models=DataProcessor::getFullList($procedurename);
         
        $filteredlist=Helper::search_revisions($models,$bankCode,'BankCode');
        $models=(collect($filteredlist)->pluck('KeyName','KeyCode'));
        
     return  $models->toArray();





      }catch(\Exception $e)
      {

        //Incase of an error,let it fall gracefully.
        return array();

      }

     //sample
      //$test=DataProcessor::getSelectMenu("proc_List_VoteSiteCategories");


  }

  public static function getBranchesinBank($bankCode)
  {
    try
    {
      $procedurename="proc_List_BankBranches_inBank";
      $branches= DB::connection("sqlsrv")->select('exec  [dbo].['.$procedurename.']@kOperationFlag=?,@KCombinedKey=?',array(8,$bankCode) );
      $models=(collect($branches)->pluck('KeyName','KeyCode'));
      return  $models->toArray();
    }
    catch(\Exception $e)
    {
      //Incase of an error,let it fall gracefully.
      return array();
    }
  }

 









}




























