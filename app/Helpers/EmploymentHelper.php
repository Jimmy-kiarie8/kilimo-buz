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
class EmploymentHelper
{

  public static function getPayGroupDesignations($PayGroupCode)
  {
    
      try{
          $procedurename="proc_List_Designations";

        $designmodels=DataProcessor::getItemListByCode($procedurename,$PayGroupCode);
        $models=(collect($designmodels)->pluck('DessignationDesc','PGJobDesigDesc'));
        return  $models->toArray();
        }catch(\Exception $e)
        {
         
          return array();
        }
   }

   public static function getAgentCountiesList($AgentCode)
   {

      try{
          $procedurename="proc_List_Global_EmployerHouses_OwnerinCounty";
             
          $designmodels= $models= DB::connection("sqlsrv")->select('exec  [dbo].['.$procedurename.']@kOperationFlag=?,@mAgentCode=?',array(6,$AgentCode) );

          $models=(collect($designmodels)->pluck('CountyName','CountyCode'));
        return  $models->toArray();
        }catch(\Exception $e)
        {

          return array();
        }

   }

   

    public static function getAllDesignations($procedurename)
  {
     
      try{
        $categories= DB::connection("sqlsrv")->select('exec  [dbo].['.$procedurename.']@kOperationFlag=?,@KCombinedKey=?',array(5,null) );

              

     $models=(collect($categories)->pluck('KeyName','CombinedKey'));

     return  $models->toArray();

      }catch(\Exception $e)
      {
          dd($e);

        //Incase of an error,let it fall gracefully.
        return array();

      }

     //sample
      //$test=DataProcessor::getSelectMenu("proc_List_VoteSiteCategories");


  }



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

   public static function getAgentCountiesZoneHouseList($AgentCountyZoneCode)
   {
    try{
       
          $procedurename="proc_List_Global_EmployerHouses_inaZone";
            $designmodels= $models= DB::connection("sqlsrv")->select('exec  [dbo].['.$procedurename.']@KOperationFlag=?, @KCombinedKey=?',array(6, $AgentCountyZoneCode) );
          $models=(collect($designmodels)->pluck('HouseDesc','HouseCode'));
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




   public static function getJopGroups($PayGroupCode)
   {
     try{
        $procedurename="proc_List_Designations";
        $designmodels=DataProcessor::getFullList($procedurename);
          //dd($designmodels);
           
        $filteredlist=Helper::search_revisions($designmodels,$PayGroupCode,'PayGroup');
        $models=(collect($filteredlist)->pluck('JobGroup','JobGroup'));
        return  $models->toArray();
        }catch(\Exception $e)
        {return array();
        }

   }

   public static function getDesignationJobGroup($id)
   {
    try{
          $procedurename="proc_List_Designations";
        $designmodels=DataProcessor::getFullList($procedurename);
           
        $filteredlist=Helper::search_revisions($designmodels,$id,'CombinedKey');
        $models=(collect($filteredlist)->pluck('JobGroup','JobGroup'));
          
        return  $models->toArray();
        }catch(\Exception $e)
        {return array();
        }

   }

   public static function getDesignationDetails($CombineKey)
   {

    try{

          $procedurename="proc_List_Designations";
        $designmodel=DataProcessor::getItemByCode($procedurename,$CombineKey);
        
      
          
        return  $designmodel;
        }catch(\Exception $e)
        {return array();
        }


   }

    public static function getDesignationPayGroup($id)
   {
    try{
        
          $procedurename="proc_List_Designations";
        $designmodels=DataProcessor::getFullList($procedurename);
        $filteredlist=Helper::search_revisions($designmodels,$id,'CombinedKey');
        $models=(collect($filteredlist)->pluck('PayGroupDesc','PayGroup'));

          
        return  $models->toArray();
        }catch(\Exception $e)
        {return array();
        }

   }


   public  static function GetJobDesignationMeta($id)
   {

    try{
          $procedurename="proc_List_Designations";
        $designmodels=DataProcessor::getFullList($procedurename);
         
        $filteredlist=Helper::search_revisions($designmodels,$id,'CombinedKey');
        

          
        return  $filteredlist;
        }catch(\Exception $e)
        {return array();
        }

   }


   public static function getSubHeadsByHeads($CombineKey)
   {

     try{
        $procedurename="proc_List_SubHeads_PerHead";
         

            
        $designmodels= $models= DB::connection("sqlsrv")->select('exec  [dbo].['.$procedurename.']@KOperationflag=?,@KCombinedKey=?',array(8,$CombineKey) );
       
        $models=(collect($designmodels)->pluck('KeyName','KeyCode'));
        return  $models->toArray();
        }catch(\Exception $e)
        {
          
          return array();
        }

   }



   public static function getJobScale($PayGroupCode,$jg)
   {
     try{
        $procedurename="proc_List_SalarySCales";
         $combine=$PayGroupCode.$jg;


            
        $designmodels= $models= DB::connection("sqlsrv")->select('exec  [dbo].['.$procedurename.']@kOperationFlag=?,@KCombinedKey=?',array(8,$combine) );
       
        $models=(collect($designmodels)->pluck('SSPAmount','ScalePoint'));
        return  $models->toArray();
        }catch(\Exception $e)
        {
          return array();
        }

   }
   public static  function getJobScaleNumber($PayGroupCode,$jg)
   {
    try{
       $combinekey=$PayGroupCode.$jg;
         

        $procedurename="proc_List_Payrollsalaryscales";
        $models=DataProcessor::getItemListByCode("proc_List_Payrollsalaryscales",$combinekey);

          $models=(collect($models)->pluck('SSPDesc','ScalePoint'));

         

        return  $models->toArray();
        }catch(\Exception $e)
        {
           dd($e);

          return array();
        }

   }



   public static function getPayGroups()
   {
     try{
          $filteredlist=DataProcessor::getFullList('proc_List_PayGroups');
            
            
        $models=(collect($filteredlist)->pluck('PayGroupDesc','PayGroup'));
        return  $models->toArray();
        }catch(\Exception $e)
        {return array();
        }

   }







 









}




























