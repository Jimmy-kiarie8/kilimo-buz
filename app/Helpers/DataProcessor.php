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
class DataProcessor
{

  public static function getSelectMenu($procedurename)
  {
     /*
     Author:Isanya Hillary
     Date:9th Nov 2023
     Function Dynamically Loads to drop down to reduce lines of codes
     params: stored procedure name


     */
      try{
        $categories= DB::connection("sqlsrv")->select('exec  [dbo].['.$procedurename.']');

              

     $models=(collect($categories)->pluck('KeyName','KeyCode'));

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


  public static function getYearPaymonthList($votesite,$year)
  {
    try{
        $procedurename="Proc_ZP_Rpt_Payslip_Paymonth";
        $monthlist= DB::connection("sqlsrv")->select('exec  [dbo].['.$procedurename.']@KVotesite=?,@kcurrent=?,@kYear=?',array($votesite,1,$year) );
         
       
       return $monthlist;

      }catch(\Exception $e)
      {
         dd($e);
        return array();

      }

  }


  public static function getCurrentPayrollProcessMonth($votesite)
  {

    try{
        $procedurename="proc_List_PayrollProcessMonth";
        $models= DB::connection("sqlsrv")->select('exec  [dbo].['.$procedurename.']@kuserVoteCode=?',array($votesite) );
         
         
         
      return  $models[0]->ProcessMonth;

      }catch(\Exception $e)
      {

        //Incase of an error,let it fall gracefully.
        return array();

      }

  }


  public static  function getPaymonth($votesite)
  {


     try{
        $procedurename="proc_List_PayrollProcessMonth_Arrears_HrSupervisor";
        $categories= DB::connection("sqlsrv")->select('exec  [dbo].['.$procedurename.']@kuserVoteCode=?',array($votesite) );
      return  $categories[0]->ArrearProcessMonth;

      }catch(\Exception $e)
      {

        //Incase of an error,let it fall gracefully.
        return array();

      }

  }

 
  public static function getVoteSelectMenu($votecode)
  {

    $procedurename="proc_List_Votesites";
       $models=DataProcessor::getFullList($procedurename);
          
        $filteredlist=self::search_revisions($models,$votecode,'VoteCode');
        $models=(collect($filteredlist)->pluck('VoteName','VoteCode'));
     return  $models->toArray();


  }


  public static function getSubVoteheads($subvote)
  {
    $procedurename="proc_List_VoteHeads_PerSubvote";
    $filteredlist=  DB::connection("sqlsrv")->select('exec  [dbo].['.$procedurename.']@KOperationFlag=?, @KCombinedKey=?',array(8, $subvote) );

     $models=(collect($filteredlist)->pluck('HeadDescription','VHeadCode'));
     return  $models->toArray();
   }


   public static function getVoteheadsSubHead($votehead)
   {
     
             $procedurename="proc_List_SubHeads_PerHead";
            $filteredlist=  DB::connection("sqlsrv")->select('exec  [dbo].['.$procedurename.']@KOperationFlag=?, @KCombinedKey=?',array(8, $votehead) );
            

     $models=(collect($filteredlist)->pluck('SubheadDescription','SubHCode'));

     return  $models->toArray();

   }

  public static function getEngagementTermsSelectMenu($procedurename)
  {
     /*
     Author:Isanya Hillary
     Date:9th Nov 2023
     Function Dynamically Loads to drop down to reduce lines of codes
     params: stored procedure name


     */
      try{
        $categories= DB::connection("sqlsrv")->select('exec  [dbo].['.$procedurename.']@kOperationFlag=?,@KCombinedKey=?',array(5,null) );

     $models=(collect($categories)->pluck('EngagementDesc','EngageCode'));
     return  $models->toArray();

      }catch(\Exception $e)
      {

        //Incase of an error,let it fall gracefully.
        return array();

      }

     //sample
      //$test=DataProcessor::getSelectMenu("proc_List_VoteSiteCategories");


  }

  public static function GetVoteDetails($voteCode)
  {

      try{
        $procedurename="Proc_ZP_Rpt_VoteDetails";
        $models= DB::connection("sqlsrv")->select('exec  [dbo].['.$procedurename.'] @KVotesite=?',array($voteCode) );

     
     return  $models[0];

      }catch(\Exception $e)
      {
         return null;

      }

  }

  public static function SubmitToHrSupervisorForApproval($payrollNo,$UserId)
  {

    try{
    $procedurename="Proc_InsertUpdateInactivate_StaffReg_Workflow_SubmitToPayrollSupervisor";
        $models= DB::connection("sqlsrv")->select('exec  [dbo].['.$procedurename.']@pyreturn=?,@KCombinedKey=?,@KCreatedby=?',array(null,$payrollNo,$UserId) );
         if(is_array($models) && sizeof($models)>0 )
         {
            $model=$models[0];
            $result=$model->ResultID;
              if($result==2)
              {
                return false;
              }else{
                return true;
              }

         }else{
            return 0;
         }


     
     return  $models->toArray();

      }catch(\Exception $e)
      {

        //Incase of an error,let it fall gracefully.
        return array();

      }

  }


  public  static function getStaffPendingSupervisorSubmission($payrollNo,$votesite)
  {

     try{
          
           $procedurename="proc_List_StaffRegisterUPN_Events_HrPayrollSupervisor";
        $models= DB::connection("sqlsrv")->select('exec  [dbo].['.$procedurename.']@KOperationFlag=?,@kUserVoteCode=?,@Kpayrollnum=?',array(6,$votesite,$payrollNo) );
         
         

     
     return  $models;

      }catch(\Exception $e)
      {
        

        //Incase of an error,let it fall gracefully.
        return array();

      }

  }





  public static function getDesignationSelectMenu($procedurename)
  {
     /*
     Author:Isanya Hillary
     Date:9th Nov 2023
     Function Dynamically Loads to drop down to reduce lines of codes
     params: stored procedure name


     */
      try{
        $categories= DB::connection("sqlsrv")->select('exec  [dbo].['.$procedurename.']@kOperationFlag=?,@KCombinedKey=?',array(5,null) );

     $models=(collect($categories)->pluck('DessignationDesc','CombinedKey'));
     return  $models->toArray();

      }catch(\Exception $e)
      {

        //Incase of an error,let it fall gracefully.
        return array();

      }

     //sample
      //$test=DataProcessor::getSelectMenu("proc_List_VoteSiteCategories");


  }

  public static function getSubVoteSelectMenu($procedurename)
  {
     /*
     Author:Isanya Hillary
     Date:9th Nov 2023
     Function Dynamically Loads to drop down to reduce lines of codes
     params: stored procedure name


     */
      try{
        $categories= DB::connection("sqlsrv")->select('exec  [dbo].['.$procedurename.']@kOperationFlag=?,@KCombinedKey=?',array(8,Auth::user()->org_id) );

     $models=(collect($categories)->pluck('SubvoteDescription','SubVCode'));
     return  $models->toArray();

      }catch(\Exception $e)
      {

        //Incase of an error,let it fall gracefully.
        return array();

      }

     //sample
      //$test=DataProcessor::getSelectMenu("proc_List_VoteSiteCategories");


  }


  public static function getPensionSchemeSelectMenu($procedurename)
  {
     /*
     Author:Isanya Hillary
     Date:9th Nov 2023
     Function Dynamically Loads to drop down to reduce lines of codes
     params: stored procedure name


     */
      try{
        $categories= DB::connection("sqlsrv")->select('exec  [dbo].['.$procedurename.']@kOperationFlag=?,@KCombinedKey=?',array(5,null) );

     $models=(collect($categories)->pluck('PensionSchemeDesc','AgentCode'));
     return  $models->toArray();

      }catch(\Exception $e)
      {

        //Incase of an error,let it fall gracefully.
        return array();

      }

     //sample
      //$test=DataProcessor::getSelectMenu("proc_List_VoteSiteCategories");


  }


  public static function getVoteDescription($procedurename , $vote)
  {
     /*
     Author:Isanya Hillary
     Date:9th Nov 2023
     Function Dynamically Loads to drop down to reduce lines of codes
     params: stored procedure name


     */
      try{
        $categories= DB::connection("sqlsrv")->select('exec  [dbo].['.$procedurename.']@kOperationFlag=?,@KCombinedKey=?',array(6, $vote) );

     $models=(collect($categories)->pluck('VoteDesc'));
     return  $models;

      }catch(\Exception $e)
      {

        //Incase of an error,let it fall gracefully.
        return array();

      }

     //sample
      //$test=DataProcessor::getSelectMenu("proc_List_VoteSiteCategories");


  }

  public static function getVoteValue($procedurename , $vote)
  {
     /*
     Author:Isanya Hillary
     Date:9th Nov 2023
     Function Dynamically Loads to drop down to reduce lines of codes
     params: stored procedure name


     */
      try{
        $categories= DB::connection("sqlsrv")->select('exec  [dbo].['.$procedurename.']@kOperationFlag=?,@KCombinedKey=?',array(6, $vote) );

     $models=(collect($categories)->pluck('VoteCode'));
     return  $models;

      }catch(\Exception $e)
      {

        //Incase of an error,let it fall gracefully.
        return array();

      }

     //sample
      //$test=DataProcessor::getSelectMenu("proc_List_VoteSiteCategories");


  }

  public static function getItemsBySpecifVotesite($procedurename,$votesite)
  { 
       try{
             
        $models= DB::connection("sqlsrv")->select('exec  [dbo].['.$procedurename.']@kOperationFlag=?,@KCombinedKey=?,@mUserVoteCode=?',array(8,$votesite,$votesite) );
         return $models;
       }catch(\Exception $e)
      {
          array();

      }
      
  }


  public static function getVoteSubHeads($votesite)
  {

    try{
        $procedurename="proc_List_SubHeads_PerVotesite";
             
        $models= DB::connection("sqlsrv")->select('exec  [dbo].['.$procedurename.']@VoteSiteKey=?',array($votesite) );
         return $models;
       }catch(\Exception $e)
      {

        return array();

      }

  }

  
  public static function getItemsByVotesite($procedurename,$votesite)
  { 
       try{
             
        $models= DB::connection("sqlsrv")->select('exec  [dbo].['.$procedurename.']@kOperationFlag=?,@KCombinedKey=?,@mUserVoteCode=?',array(9,$votesite,$votesite) );
         return $models;
       }catch(\Exception $e)
      {
        return array();

      }
      
  }


  public static  function getEarningsList()
  {
    $models=DataProcessor::getFullList("proc_List_EarningDeductions");
     $code=1;
         $filteredlist=DataProcessor::search_revisions($models,$code,'EDCategory');
           $models=(collect($filteredlist)->pluck('KeyName','KeyCode'))->toArray();
            
         return $models;


  }


  public static function getArrearEarning()
  {

     try{

        $models=DataProcessor::getFullList("proc_List_EarningDeductions");
     $code=1;
         $filteredlist=DataProcessor::search_revisions($models,$code,'EDCategory');
           $models=(collect($filteredlist)->pluck('KeyName','KeyCode'))->toArray();
            
         return $models;
       



       }catch(\Exception $e)
      {
       
           return null;

      }

  }

  public static function getArrears()
  {

     try{
      $procedurename = 'proc_List_PayrollExplicitEarningArrears';
      $filteredlist= DB::connection("sqlsrv")->select('exec  [dbo].['.$procedurename.']',array() );
           $models=(collect($filteredlist)->pluck('KeyName','KeyCode'))->toArray();
            
         return $models;
       



       }catch(\Exception $e)
      {
       
           return null;

      }

  }


  public static function getStaffEarningsPendingSubmissionList($payrollNo,$votesite)
  {
    

     try{
        $procedurename="Proc_List_Payroll_AllIndividualEarning_HrOperative";
        
             
        $models= DB::connection("sqlsrv")->select('exec  [dbo].['.$procedurename.']@KPayrollnum=?',array($payrollNo) );
        return $models;
       }catch(\Exception $e)
      {
       
           return array();

      }

  }
          
  
  
  
   public static function getItemsByVotesites($procedurename,$votesite)
  {
       try{
        $models= DB::connection("sqlsrv")->select('exec  [dbo].['.$procedurename.']@kOperationFlag=?,@KCombinedKey=?,@mUserVoteCode=?',array(5,$votesite,$votesite) );
         return $models;
       }catch(\Exception $e)
      {
        //Incase of an error,let it fall gracefully by returning null.
        return array();

      }
      
  }

  public static function getSiteVotehead($votesite)
  {
    try{
        $procedurename="proc_List_VoteHeadsByVote";
        $models= DB::connection("sqlsrv")->select('exec  [dbo].['.$procedurename.']@KCombinedKey=?',array($votesite) );
         return $models;
       }catch(\Exception $e)
      {
        //Incase of an error,let it fall gracefully by returning null.
        return array();

      }

  }

          
   public static function getItemByCode($procedurename,$code)
   {

    /*
     Author:Isanya Hillary
     Date:9th Nov 2023
     Function :returns a single Entity from the database by using table primary key
     params: stored procedure name


     */
      try{
        $models= DB::connection("sqlsrv")->select('exec  [dbo].['.$procedurename.']@kOperationFlag=?,@KCombinedKey=?',array(6,$code) );
         return (sizeof($models)>0)?(object)  $models[0]:null;
       }catch(\Exception $e)
      {
        //Incase of an error,let it fall gracefully by returning null.
        return null;

      }

   }

    public static function getItemListByCode($procedurename,$KCombinedKey)
   {

    /*
     Author:Isanya Hillary
     Date:14th Nov 2023
     Function :returns a list of Items with a given key
     */
      try{
           
         $models= DB::connection("sqlsrv")->select('SET NOCOUNT ON exec  [dbo].['.$procedurename.']@KOperationflag=?,@KCombinedKey=?',array(8,$KCombinedKey) );
         return $models;


       }catch(\Exception $e)
      {
          

         
         //Helper::sendEmailtoSupport(e);
        //Incase of an error,let it fall gracefully by returning null.
        return array();

      }



   }

   public static function getFullList($procedurename)
  {
     /*
     Author:Isanya Hillary
     Date:ith Dec 2023
     Function Dynamically Loads to drop down to reduce lines of codes
     params: stored procedure name


     */
      try{

        $models= DB::connection("sqlsrv")->select('exec  [dbo].['.$procedurename.']@kOperationFlag=?,@KCombinedKey=?',array(5,null) );

    
     return  $models;

      }catch(\Exception $e)
      {
         dd($e);
        
         return array();
      }

    


  }

  public static function getExemptionTypeslist($code)
  {
    $procedurename = 'proc_List_EarningDeductions_Exemptions';
    try{

      $models= DB::connection("sqlsrv")->select('exec  [dbo].['.$procedurename.']@kEdtype=?',array($code) );

  
   return  $models;

    }catch(\Exception $e)
    {
       dd($e);
      
       return array();
    }
  }


   public static function GetWardsByConstituency($code)
    {
         $procedurename="proc_List_Constituency";

        $models=DataProcessor::getFullList($procedurename);
         
          
        $filteredlist=self::search_revisions($models,$code,'CountyCode');

        $models=(collect($filteredlist)->pluck('ConstituencyName','ConstituencyCode'));
     return  $models->toArray();
 }



  public static function getJobCadre($code)
   {

    
      try{

           
           $procedurename="proc_List_Cadre";
         $models= DB::connection("sqlsrv")->select('exec  [dbo].['.$procedurename.']@KOperationflag=?,@KCombinedKey=?',array(5,$code) );

         return $models;


       }catch(\Exception $e)
      {
          dd($e);
        return array();

      }



   }


 public static function GetWardsByCounty($countyCode)
 {
    $procedurename="proc_List_Wards";

        $models=DataProcessor::getFullList($procedurename);
        $filteredlist=self::search_revisions($models,$countyCode,'CountyCode');

        $models=(collect($filteredlist)->pluck('CWardName','CWardCode'));
     return  $models->toArray();

 }

 public static  function getStationsByVotesite($votesite)
 {

    $procedurename="proc_List_GlobalStations";
       $models=DataProcessor::getFullList($procedurename);
        $filteredlist=self::search_revisions($models,$votesite,'VoteCode');
        $models=(collect($filteredlist)->pluck('StationName','StationCode'));
     return  $models->toArray();
 }

 public static function getCouncilBYCountyCode($code)
 {
    $procedurename="proc_List_Council";
        $models=DataProcessor::getFullList($procedurename);
        $filteredlist=self::search_revisions($models,$code,'CountyCode');
         $models=(collect($filteredlist)->pluck('CouncilName','CouncilCode'));
     return  $models->toArray();
 }

 public static function getSubHeadsByHeads($code)
 {
    $procedurename="proc_List_SubHeads";
    $models=DataProcessor::getFullList($procedurename);
    $filteredlist=self::search_revisions($models,$code,'VHeadCode');
    $models=(collect($filteredlist)->pluck('SubHName','SubHCode'));
    return  $models->toArray();
}


public static function getSubCountiesByCounty($countyCode)
{
    $procedurename="proc_List_SubCounty";
    $models=DataProcessor::getFullList($procedurename);
    $filteredlist=self::search_revisions($models,$countyCode,'CountyCode');
    $models=(collect($filteredlist)->pluck('SCountyName','SCountyCode'));
    return  $models->toArray();

}

public static   function getDivisonBySubCountyCode($subcountycode)
{
    $procedurename="proc_List_Divisions";
        $models=DataProcessor::getFullList($procedurename);
        $filteredlist=self::search_revisions($models,$subcountycode,'SubCountyCode');
         $models=(collect($filteredlist)->pluck('DivisionName','DivisionCode'));
    return  $models->toArray();

}

public static function getLocationsBySubCountes($subcountycode)
{

     $procedurename="proc_List_Locations";
        $models=DataProcessor::getFullList($procedurename);
    $filteredlist=self::search_revisions($models,$subcountycode,'SubCountyCode');
         $models=(collect($filteredlist)->pluck('LocationName','LocationCode'));
    return  $models->toArray();

}
public static function getSubLocationsBySubCountes($subcountycode)
{
     $procedurename="proc_List_SubLocations";
        $models=DataProcessor::getFullList($procedurename);
    $filteredlist=self::search_revisions($models,$subcountycode,'SubCountyCode');
         $models=(collect($filteredlist)->pluck('SubLocationName','SubLocationCode'));
    return  $models->toArray();

    
}

 public static  function getSubVotesByVotesites($votesite)
 {
    $procedurename="proc_List_SubVote";
        $models=DataProcessor::getFullList($procedurename);
        $filteredlist=self::search_revisions($models,$votesite,'VoteCode');
         $models=(collect($filteredlist)->pluck('SubVName','SubVCode'));
     return  $models->toArray();

 }

 public static function getVoteHeadBySubVote($Combine)
 {
 

   try{
     $procedurename="proc_List_VoteHeads_PerSubvote";
        $models= DB::connection("sqlsrv")->select('exec  [dbo].['.$procedurename.']@KOperationflag=?,@KCombinedKey=?',array(8,$Combine) );
        $models=(collect($models)->pluck('VHeadName','VHeadCode'));
         return  $models->toArray();

         }catch(\Exception $e)
   {
    $models=array();
      return  array();

   }
      
    
    

 }



      public static  function GetWards($code)
    {
        $procedurename="proc_List_Wards";
        $models=DataProcessor::getFullList($procedurename);
         
          
        $filteredlist=self::search_revisions($models,$code,'ConstituencyCode');

         
         $models=(collect($filteredlist)->pluck('CWardName','CWardCode'));
     return  $models->toArray();
        

    }
    public static  function GetWardspersubcounty($code)
    {
        $procedurename="proc_List_Wards";
        $models=DataProcessor::getFullList($procedurename);
         
          
        $filteredlist=self::search_revisions($models,$code,'SCoutyCode');

         
         $models=(collect($filteredlist)->pluck('CWardName','CWardCode'));
     return  $models->toArray();
        

    }



    public  static function getStaffPendingSupervisor($votesite)
    {
        try{
          
           
         $procedurename="proc_List_StaffRegisterUPN_HrPayrollSupervisorGrid";
        $models= DB::connection("sqlsrv")->select('exec  [dbo].['.$procedurename.']@kOperationFlag=?,@mUserVoteCode=?',array(5,$votesite) );
        return $models;
           
        }catch(\Exception $e)
      {
        return array();
    }

    }


    public static function getSupervisorStaffNModel($payrollNo,$votesite)
    {
        try{
          

           
         $procedurename="proc_List_StaffRegisterUPN_HrPayrollSupervisorSpecific";
        $models= DB::connection("sqlsrv")->select('exec  [dbo].['.$procedurename.']@KOperationFlag=?,@kUserVoteCode=?,@KCombinedKey=?',array(6,$votesite,$payrollNo) );
       

          if(sizeof($models)>0 and is_array($models))
          {
            $model=(object)$models[0];

          }else{
            $model=null;
          }
            
          return $model;

        
           
        }catch(\Exception $e)
      {
        
        return array();
    }


    }




    public static function getWorkFlowADS($payrollNo,$votesite)
    {
        try{
          
           
         $procedurename="proc_List_StaffRegisterUPN_WorkflowADS";
        $models= DB::connection("sqlsrv")->select('exec  [dbo].['.$procedurename.']@KOperationFlag=?,@kUserVoteCode=?,@KCombinedKey=?',array(6,$votesite,$payrollNo) );

          if(sizeof($models)>0 and is_array($models))
          {
            $model=(object)$models[0];

          }else{
            $model=null;
          }
          return $model;

        
           
        }catch(\Exception $e)
      {

        
        return array();
    }


    }







    public static function getSupervisorView($upnNo)
    {
         try{
            $procedurename="Proc_Staffregister_approval_supervisor";
            $models= DB::connection("sqlsrv")->select('exec  [dbo].['.$procedurename.']@CombinedKey=?',array($upnNo) );
               if(sizeof($models)>0 && is_array($models))
               {
                return (object)$models[0];
               }else{
                return null;
               }
        }catch(\Exception $e)
        { 
              dd($e);
            return array();
        }

    }
    public  static function getStaffPendingOPeratorSubmission($upnNo,$votesite)
    {
        try{
          
           
         $procedurename="proc_List_StaffRegisterUPN_Events_HrPayrollOperative";
        $models= DB::connection("sqlsrv")->select('exec  [dbo].['.$procedurename.']@kOperationFlag=?,@Kpayrollnum=?,@kUserVoteCode=?',array(6,$upnNo,$votesite) );
          
        return $models;
           
        }catch(\Exception $e)
      {
          dd($e);
         
         
         return array();
    }

    }

    public static function getStaffByUpn($upnNo ,$votesite)
    {
    try{
         

         $procedurename="proc_List_StaffRegisterUPN_HrPayrollOperative";

        $models= DB::connection("sqlsrv")->select('exec  [dbo].['.$procedurename.']@kOperationFlag=?,@KCombinedKey=?,@mUserVoteCode=?',array(6,$upnNo,$votesite) );
          

       
        return $models;
           
        }catch(\Exception $e)
      {
          return array();
    }


    }



    public static  function StaffRegisterADS($upnNo ,$votesite)
    {
        try{
         

         $procedurename="proc_List_StaffRegister_ADS_Global";

        $models= DB::connection("sqlsrv")->select('exec  [dbo].['.$procedurename.']@kPayrollNum=?,@kUserVoteCode=?,@KOperationFlag=?',array($upnNo,$votesite,6) );
          

       
        return $models;
           
        }catch(\Exception $e)
      {
          return array();
    }

    }


    public static function getGlobalStaffByUpn($upnNo)
    {
    try{
         

         $procedurename="proc_List_Users_One_Global";
        $models= DB::connection("sqlsrv")->select('exec  [dbo].['.$procedurename.']@kPayrollNum=?',array($upnNo) );
       
        return $models;
           
        }catch(\Exception $e)
      {
          

         return array();
    }


    }


    public static function getStaffByUpnADS($upnNo ,$votesite)
    {
    try{
        // if(Auth::User()->hasRole(['Hr-Payroll-Operative']))
        // {
        //   $status=1;
        // }else{
        //   $status="2;"
        // }
         

         $procedurename="proc_List_StaffReg_StaffRegister_Interface_ADS";
        $models= DB::connection("sqlsrv")->select('exec  [dbo].['.$procedurename.']@kOperationFlag=?,@mPayrollNum=?,@mUserVoteCode=?',array(6,$upnNo,$votesite) );
       
        return $models;
           
        }catch(\Exception $e)
      {
        // dd($e);
         return array();
    }


    }


    public static function getEventMenus()
    {

         $procedurename="proc_List_StaffRegister_EventsCategory";
        $models= DB::connection("sqlsrv")->select('exec  [dbo].['.$procedurename.']@kOperationFlag=?',array(5) );
        return $models;

    }

public static function saveItem($procedurename, $data)
{
    /*
    Author: muimi Jacob
    Date: 11th Dec 2023
    Function: Saves data using the provided stored procedure
    Params: stored procedure name, data to be saved
    */

    try {
        $result = DB::connection("sqlsrv")->select('exec [dbo].['.$procedurename.']@KOperationFlag=?, @KCombinedKey=?', array(2));

        return $result; // Return any success message or identifier upon successful save
    } catch (\Exception $e) {
        // Log or handle the error as needed
        return null; // Return null or an error message upon failure
    }
}


     public static  function GetVillages($code)
    {
        
        $procedurename="proc_List_Villages";
        $models=DataProcessor::getFullList($procedurename);
        $filteredlist=self::search_revisions($models,$code,'CWardCode');
        $models=(collect($filteredlist)->pluck('VilageName','VilageCode'));
     return  $models->toArray();
        

    }



    public static function search_revisions($dataArray, $search_value, $key_to_search) {
        // This function will search the revisions for a certain value
        // related to the associative key you are looking for.

            if(is_array($dataArray)&&sizeof($dataArray)>0)
            {
                $keys = array();
        foreach ($dataArray as $key => $cur_value) {

            if ($cur_value->$key_to_search == $search_value) {
                $keys[] =$cur_value;
            }
        }

        return $keys;

            }else{
              return array();
            }

       
    }

    public static function getHouseAgentsSelectMenu($procedurename)
    {

      try
      {
        $list= DB::connection("sqlsrv")->select('exec  [dbo].['.$procedurename.']@KOperationflag=?,@KCombinedKey=?',array(5,null) );
      }
      catch(\Exception $e)
      {
       //Incase of an error,let it fall gracefully by returning null.
       return null;
      }

        $models=(collect($list)->pluck('HouseOwnerName','HouseOwnerCode'));
     return  $models->toArray();
 }
    public static function getHouseZonesSelectMenu($procedurename)
    {

      try
      {
        $list= DB::connection("sqlsrv")->select('exec  [dbo].['.$procedurename.']@KOperationflag=?,@KCombinedKey=?',array(5,null) );
      }
      catch(\Exception $e)
      {
       //Incase of an error,let it fall gracefully by returning null.
       return null;
      }

        $models=(collect($list)->pluck('HouseZoneName','HouseOwnerCode'));
     return  $models->toArray();
 }

    public static function getHousesSelectMenu($procedurename)
    {

      try
      {
        $list= DB::connection("sqlsrv")->select('exec  [dbo].['.$procedurename.']@KOperationflag=?,@KCombinedKey=?',array(5,null) );
      }
      catch(\Exception $e)
      {
       //Incase of an error,let it fall gracefully by returning null.
       return null;
      }

        $models=(collect($list)->pluck('HouseDesc','HouseCode'));
     return  $models->toArray();
 }

 public static function GetSalaryScaleMenu($pgjg)
 {
     $procedurename="proc_List_SalarySCales";
     $filteredlist=  DB::connection("sqlsrv")->select('exec  [dbo].['.$procedurename.']@KOperationFlag=?, @KCombinedKey=?',array(7, $pgjg) );
         
         
    //  $employee = DB::connection("sqlsrv")->select('exec  [dbo].['.$Employeeprocedurename.']@mPayrollNum=?, @mUserVoteCode=?, @KOperationFlag=?, @KCombinedKey=?',array($payrollNum, $code, 6, null) ); 
     
     
     if(sizeof($filteredlist)>0)
     {
         $data=(collect($filteredlist)->pluck('SSPAmount','ScalePoint')->toArray());
         return $data;
     }else{
       return array();
     }
     
 }

 public static function getHouseDetails($houseCode)
 {
  try
  {
  $procedurename="proc_List_HouseDetails";
  $filteredlist=  DB::connection("sqlsrv")->select('exec  [dbo].['.$procedurename.']@houseCode=?',array($houseCode));
  return $filteredlist;
  }
  catch(\Exception $e)
  {
      return array();
  }
 }

 public static function getOneThird($pno)
 {
  try
  {
  $procedurename="proc_List_Payroll_AmountAvailable_toCommit";
  $models=  DB::connection("sqlsrv")->select('exec  [dbo].['.$procedurename.']@kPayrollNum=?',array($pno));
  return $models[0];
  }
  catch(\Exception $e)
  {
      return array();
  }
 }










}




























