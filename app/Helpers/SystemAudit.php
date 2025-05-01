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
class SystemAudit
{

   public  static function CreateEvent($user,$event_name,$description,$serverity,$ip_address,$module,$agent=null,$payrollNum=null,$ActionName=null,$ActionStatus=null)
   {
      try{
       
       $model=new SystemLog();
       $model->user_id=$user->id;
       $model->event_name=strtoupper($event_name);
       $model->module_name=$module;
       $model->event_date=date('Y-m-d H:i:s');
       $model->ip_address=$ip_address;
       $model->event_description=$description;
       $model->severity=$serverity;
       $model->user_agent=$agent;
       $model->financial_year=Helper::getCurrenFinancialYear($model->event_date);
       $model->quarter_name=Helper::getCurrentQuater($model->event_date);
       $model->PayrollNum=$payrollNum;
       $model->votesite=($user)?$user->org_id:null;
       $model->user_role=($user)?$user->role_id:null;
       $model->ActionName=$ActionName;
       $model->ActionStatus=$ActionStatus;
       $model->Monthcode=date('Ym');
       //$model->MachineSerialNumber=HardwareHelper::getDeviceSerialNumber();
       $model->save();
        return 1;


      }catch(\Exception $e)
      {
        return 0;
      }
       
    
   }




  
 
}