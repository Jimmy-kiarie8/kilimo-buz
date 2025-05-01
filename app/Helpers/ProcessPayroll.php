<?php // Code within app\Helpers\Helper.php

namespace App\Helpers;
use Illuminate\Support\Facades\Input;
use Auth;
use Response;
use DB;
class ProcessPayroll
{

  


   public static function RunPayollProcessing($data)
   {
    try{
      
        set_time_limit(0);
          $PayrollNum=$data['PayrollNum'];
          $Votecode=$data['VoteCode'];
          $UserBrowser=$data['UserBrowser'];
          $IpAddress=$data['IpAddress'];
          $procedurename="Proc_ZP_Payroll";
           $model= DB::connection("sqlsrv")->select('SET NOCOUNT ON  SET ANSI_NULLS ON exec  [dbo].['.$procedurename.']
              @KUserpayrollnum =?,
              @Kuservotecode=?,
              @kPyReturn=?',
              array($PayrollNum,$Votecode,null) );

               

               return  $model;
        }catch(\Exception $e)
        {
            dd($e);


           return 0;
        }

   }


   public static function publishPayroll($data)
   {
      try{


         $paymonth=DataProcessor::getCurrentPayrollProcessMonth($data['VoteCode']);
           
        
         set_time_limit(0);
           
          $PayrollNum=$data['PayrollNum'];
          $Votecode=$data['VoteCode'];
          $year=substr($paymonth, 0,4);
          $month=substr($paymonth, 4,2);
          $procedurename="Proc_ZP_Payroll_PublishPayroll";
           $model= DB::connection("sqlsrv")->select('SET NOCOUNT ON   exec  [dbo].['.$procedurename.']
              @KUserpayrollnum =?,
              @Kuservotecode=?,
              @kyear=?,
              @kmonth=?,
              @kPyReturn=?',
              array($PayrollNum,$Votecode,$year,$month,null) );
            

               return  $model[0]->ResultID;
        }catch(\Exception $e)
        {
           dd($e);
          
          
           return 0;
        }

   }

   public static function CheckPayrollRunStatus($data)
   {
      try{
          $Votecode=$data['VoteCode'];
          $Paymonth=$data['paymonth'];
          $procedurename="Proc_ZP_Payroll_Check_if_Processed_for_Current_Month";
           $model= DB::connection("sqlsrv")->select('exec  [dbo].['.$procedurename.']
              @kVoteCode=?',
              array($Votecode) );
          return  $model[0];
        }catch(\Exception $e)
        {
           return  $e;
        }

   }

  







 









}




























