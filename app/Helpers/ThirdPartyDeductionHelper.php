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
class ThirdPartyDeductionHelper
{


  public  static function  HROperator_EmployeeApprovedList($staffPayrollNumber)
  {
    $procedurename="proc_List_Payroll_EmployeeAllThirdpartyDeductions_Approved";
    try{
         $Approved_third_deductions= DB::connection("sqlsrv")->select('exec  [dbo].['.$procedurename.']@kPayrollNum=?', array($staffPayrollNumber));
          return $Approved_third_deductions;
        }catch(\Exception $e)
        {
          dd($e);
         }

   }



   public  static function  HRSupervisor_EmployeePendingApprovalList($staffPayrollNumber)
  {
    $procedurename="proc_List_Payroll_HrSupervisorEmployeeThirdpartyDeductions";
    try{
         $pendingApproval_third_deductions= DB::connection("sqlsrv")->select('exec  [dbo].['.$procedurename.']@kPayrollNum=?', array($staffPayrollNumber));
          return $pendingApproval_third_deductions;
        }catch(\Exception $e)
        {
          dd($e);
         }

   }



   public static function HrOperatorGetAllEmployeeThirdParty($staffPayrollNumber)
   {

     $procedurename="proc_List_Payroll_EmployeeAllThirdpartyDeductions";
    try{
         $pendingApproval_third_deductions= DB::connection("sqlsrv")->select('exec  [dbo].['.$procedurename.']@kPayrollNum=?', array($staffPayrollNumber));
          return $pendingApproval_third_deductions;
        }catch(\Exception $e)
        {
          dd($e);
         }

   }


  
}