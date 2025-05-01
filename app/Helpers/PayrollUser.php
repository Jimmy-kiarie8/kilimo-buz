<?php // Code within app\Helpers\Helper.php

namespace App\Helpers;
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
use Input;
use DB;
class PayrollUser
{

   public  static function SaveUser($user,$data)
   {


            try{
                  
                  

               
                $KOperationflag=1;
                $kActiveStatus=1;
                $StaffDetails=Self::getStaffDetailsFromStaffRegister($data['username'],Auth::User()->org_id);
                  
                  $dateApproved=date("Y-m-d");



                $startDate=date('Y-m-d');
                 $models=DB::connection("sqlsrv")->select('SET NOCOUNT ON  exec  [dbo].[Proc_InsertUpdateInactivate_Users] 
                               @kPayrollNum=?,
                               @kUserVoteCode =?,
                               @kRoleId =?,
                               @kIDNum=?,
                               @kSurname=?,
                               @kFirstName=?,
                               @kOtherNames =?,
                               @kStaffRegisterVoteCode =?,
                               @kApprovedBy=?,
                               @kApprovedDate=?,
                               @kApprovalAttachment=?,
                               @kStartDate=?,
                               @kEndDate=?,
                               @kActiveStatus=?,
                               @KOperationflag=?,
                               @KCombinedKey=?,
                               @pyreturn=? ',
                               array(
                                $data['username'],
                                $data['org_id'],
                                $data['role_id'],
                                $StaffDetails->IDNum,
                                $StaffDetails->Surname,
                                $StaffDetails->FirstName,
                                $StaffDetails->OtherNames,
                                $StaffDetails->VoteCode,
                                $user->created_by,
                                $dateApproved,
                                $data['AttachmentName'],
                                $startDate,
                                null,
                                $kActiveStatus,
                                1,
                                 $data['username'].$data['org_id'].$data['role_id'],
                                 null)
                                    );
                   

             if(sizeof($models)>0 && is_array($models))
             {
                 $resultId=$models[0]->ResultID;

                   if($resultId==1)
                   {
                     $message="User Created Successfully";

                   }else{
                     $message="User  Not Created";

                   }

             }else{
                $resultId=0;
                $message="Error While Saving Earning Details.Please Contact System Admin";

             }



           }catch(\Exception $e)
               {
                 dd($e);

                 $resultId=0;
                $message="Error While Approving Earning Details.Please Contact System Admin";
              }
             $response['MessageID']=$resultId;
             $response['MessageBody']=$message;
              return $response; 

  
      
        
     

    
   }


   public static function getStaffDetailsFromStaffRegister($personalNo,$orgID)
   {
      if(\Auth::User()->hasRole(['Administrator','Payroll Data Administrator']))
      {
         
          
          try{
        $procedurename="proc_List_Users_One_Global";
        $staffDetails= DB::connection("sqlsrv")->select('exec  [dbo].['.$procedurename.']@kPayrollNum=?',array($personalNo) );
          return  $staffDetails[0];
           }catch(\Exception $e)
           {
        //Incase of an error,let it fall gracefully.
        return null;
         }
      




      }else{
        $model=DataProcessor::getStaffByUpn($personalNo,$orgID);
        return $model[0];

      }

   }


   public static function UploadUserAuthorizationLetter($user,$data)
   {


        if(isset($data['authorization_letter'])){
        $paths= base_path() . '/storage/app/AuthorityLetter/';
        $destinationPath = base_path() . '/public/AuthorityLetter/';; // upload path
        $extension = Input::file('authorization_letter')->getClientOriginalExtension(); // getting 
         
            if($extension=="pdf")
            {
            $fileName =$user->org_id."user".$user->username."Authority".date('Ymd').'.'.$extension; // renameing image
         
            Input::file('authorization_letter')->move($destinationPath, $fileName); // uploading file to
            $name= $fileName;
             $result=array("Success"=>1,
                 "fileName"=>$fileName,
                 "Message"=>"UploadedSuccessfully",
             );
           }else{
            $result=array("Success"=>0,
                 "fileName"=>"Failed",
                 "Message"=>"Wrong File Format",
             );

           }
          
       }else{
        $result=array("Success"=>0,
                 "fileName"=>"Failed",
                 "Message"=>"No File Attached",
             );

       }
       return $result;

   }
   
          
   

   






  
 
}