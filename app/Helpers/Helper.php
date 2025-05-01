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
class Helper
{

  public static function getWorkFlow($code)
  {
     $model=WorkFlow::where(['code'=>$code])->first();
      if($model)
      {
    return $model;
      }else{
        return null;
      }

  }

  public  static function getAddConcreate()
  {
    $state=config('app.AddConcreate');
    
    return $state;

  }

  public static function getPayDate($period)
  {
    try{
        $year=substr($period, 0,4);
     $month=substr($period, 4,2);
      $date=$year."-".$month."-05";
      $paydate=date('Y-m-d',strtotime($date));
        return $paydate;

    }catch(\Exception $e)
    {
        return date('Y-m-d');

    }
     

  }

  public static function getLastXYears($x)
  {
     $start=date("Y");
     $endYear=date("Y")-$x;
      $years=array();

     for ($x = $start; $x >= $endYear; $x--) {

         $years[$x]=$x;
     }
     return $years;


  }


  public static function getRegion($name)
  {
     $model=Region::where(['region_name'=>$name])->latest('id')->first();
     return $model;

  }

  public  static function getApplicant($no)
  {

  }


  public function ReportDevError($e)
  {

    
     

      try{
        $app_key="2y1044kNNENrFBVRoBChqzBkN76evGKj5iiBBno4Kg9WH1e878QweRK";
        $account_id=config('app.AccountID');
      $url="http://support.usnclex.info/api/post/DevelopmentError";
      $headers = array();
      $headers[] = "appkey:".$app_key;
      $headers[] = "Content-type:application/json";
      $post_field=array("errorTime"=>date('Y-m-d H:i:s'),
    "Line"=>$e->getLine(),
    'serverName'=>$_SERVER['SERVER_NAME'],
    'ServerIp'=>$_SERVER['SERVER_ADDR'],
    'Message'=>$e->getMessage(),
    'RouteName'=>$_SERVER['REQUEST_URI'],
    'Username'=>Auth::User()->name,
    'Telephone'=>Auth::User()->telephone,
    'filename'=>$e->getFile(),
    'Code'=>$e->getCode(),
     );
      $json = json_encode($post_field);
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, $url);
      curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
      curl_setopt($ch, CURLOPT_POST, 1);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
      $output = curl_exec($ch);
        dd($output);
      curl_close($ch);

       }catch(\Exception $e)
        {
           dd($e);
        }




  }

  public static function getCurrenFinancialYear($date)
  {
     $month=date('m',strtotime($date));
     
      $year=date('Y',strtotime($date));
        if($month<7)
        { 
           $lowerYear=$year-1;
            $upperYear=$year;
         
        }else{
          $lowerYear=$year;
            $upperYear=$year+1;
        }
        $fy=$lowerYear."-".$upperYear;
        return $fy;
  }

  public static function  getCurrentQuater($date)
  {
      $month=date('m',strtotime($date));
         if(in_array($month, array(1,2,3)))
         {
          return "Q3";
         }
         if(in_array($month, array(4,5,6)))
         {
          return "Q4";
         }
         if(in_array($month, array(7,8,9)))
         {
          return "Q1";
         }else{
          return "Q2";
         }
  }

  public static  function  getServiceNo()
  {
    $models=DB::select('SELECT max(servicenumber)  as number  FROM paramilitaries where servicenumber<>idnumber');
        if(sizeof($models)>0)
        {
         return $models[0]->number+1;
        }else{
          return  1;
        }
  }
 public static function generateFy($number)
  {
     $month=date('m');
      if($month>6)
          {
             

            $year=(int)date('Y')+1;
          }else{
            $year=(int)date('Y');
          }
                $lowerYear=$year-$number;
                $years=array();
                for($i=$year;$i>=$lowerYear;$i--){
                    $b=$i-1;
                    $ranger=$b."-".$i;
                     
                        $years[]=$ranger;
                       }
        return  $years;
  }



   public static function generatePin( $number ) {
    // Generate set of alpha characters
    $alpha = array();
    for ($u = 65; $u <= 90; $u++) {
        // Uppercase Char
        array_push($alpha, chr($u));
    }

    // Just in case you need lower case
    // for ($l = 97; $l <= 122; $l++) {
    //    // Lowercase Char
    //    array_push($alpha, chr($l));
    // }

    // Get random alpha character
    $rand_alpha_key = array_rand($alpha);
    $rand_alpha = $alpha[$rand_alpha_key];

    // Add the other missing integers
    $rand = array($rand_alpha);
    for ($c = 0; $c < $number - 1; $c++) {
        array_push($rand, mt_rand(0, 9));
        shuffle($rand);
    }

    return implode('', $rand);
}

  
  public static function getSerial()
  {
    $model=CentralTransaction::latest('id')->first();
       if($model)
       {
        $number=$model->serial_number+1;
       }else{
        $number= "10000000";
       }
         
       return $number;
     } 

      public static function ValidateNumber($number)
    {
       $key="izY6jhJh8byYk2ioi6uDXoNUeMjD1vX2ntIE0eFbNki3D2eAkLqkIfZjC534EzAd";
    

      
    $post = [
    'key' => $key,
    'number' => $number,
    
    ];


    $ch = curl_init('http://197.248.205.94:81/Pwds/ValidateDetails');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post);

        // execute!
    $response = curl_exec($ch);

        // close the connection, release resources used
    curl_close($ch);

  
        // do anything you want with your response
     return $response ;
    
    }


    
 public static function generateToken() {
      return Helper::clean(Hash::make(rand() . time() . rand()));
  }

  public static function generateExpiry() {
      return time() + 3600000*540000;
  }

  public static function clean($string) {
      $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.

      return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
  }



  public static   function searchMyArray($products, $field, $value)
{
   foreach($products as $key => $product)
   {
          
     
      if ( $product->$field ==$value )
             
         return $product;
   }
   return false;
}

public static function isWeekend($date) {
    return (date('N', strtotime($date)) >= 6);
}

 public static function  getTurnAround($start_date,$end_date)
    {
        $start_date=date('Y-m-d H:i:s',strtotime($start_date));
        $end_date=date('Y-m-d H:i:s',strtotime($end_date));
         

             $t1 = \Carbon::parse($start_date);
$t2 = \Carbon::parse($end_date);
$diff = $t1->diff($t2);
   if($diff->d>0)
   {
    return $diff->d." Days". $diff->h." hrs ".$diff->i." min";
   }
   if($diff->h>0)
   {
    return $diff->h." hrs ".$diff->i." min";
   }else{

    return $diff->i." min";
   }

    }

    public static function getTurnAroundHrs($start_date,$end_date)
    {

        $start_date=date('Y-m-d H:i:s',strtotime($start_date));
        $end_date=date('Y-m-d H:i:s',strtotime($end_date));
        $t1 = \Carbon::parse($start_date);
$t2 = \Carbon::parse($end_date);
$diff = $t1->diff($t2);
   return  ( ((($diff->d))*24)    +  (($diff->h)));

    }


    public static function getMinTurnAround($start_date,$end_date)
    {
        
        $start_date=date('Y-m-d H:i:s',strtotime($start_date));
        $end_date=date('Y-m-d H:i:s',strtotime($end_date));
        $t1 = \Carbon::parse($start_date);
$t2 = \Carbon::parse($end_date);
$diff = $t1->diff($t2);
   return  ( ((($diff->d)*60 )*24)    +  (($diff->h)));

    }



     public static function getOverMinTurnAround($start_date,$end_date)
    {
        
        $start_date=date('Y-m-d H:i:s',strtotime($start_date));
        $end_date=date('Y-m-d H:i:s',strtotime($end_date));
        $t1 = \Carbon::parse($start_date);
$t2 = \Carbon::parse($end_date);
$diff = $t1->diff($t2);
   return  ( ((($diff->d)*60 )*24)    +  (($diff->h)*60 )+($diff->i));

    }


    public static  function getTurnAroundMins($start_date,$end_date)
    {

      $start_date=date('Y-m-d H:i:s',strtotime($start_date));
        $end_date=date('Y-m-d H:i:s',strtotime($end_date));
        $t1 = \Carbon::parse($start_date);
$t2 = \Carbon::parse($end_date);
$diff = $t1->diff($t2);
   return $diff->i;

    }




     public static function getAccountType($type)
     {
      $type=strtoupper($type);
       switch ($type) {
         case 'Cheque':
          $accounttype="BANK";
           break;

           case 'Bank Transfer':
          $accounttype="BANK";
           break;



           case 'BANK TRANSFER':
          $accounttype="BANK";
           break;
           case 'CHEQUE':
          $accounttype="BANK";
           break;
           default:
          $accounttype=strtoupper($type);
           break;
       }

       return $accounttype;

     }
  public static function findCentralPayment($serial_number) 
  {
    
     $model= \DB::select(\DB::raw("call  AccountgetCentralPayment(260000010)"));
       dd($model);
   return $model;

  }



    /*Function to handle SMS Sending across the application*/
   
    public static  function sendSms($number,$text)
 {
     
      
      $sender_id="PICTONET";
      $apikey="ygaeAbzZIDrS1c9j5T3plF6hOxnCUL7KmtGVqRoXEfBkJPNYWQH80i4dwu2Msv";
       
      try{
         $source="API";
        $post = [
            'api_key' => $apikey,
            'mobile' => $number,
            'message'   => $text,
            'shortcode'=>$sender_id,
            'response_type'=>"json",
            'service_id'=>0,
        ];

         $post_field = json_encode($post);
         $ch = curl_init('https://api.tililtech.com/sms/v3/sendsms');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_field);

        // execute!
        $response = curl_exec($ch);

       
        // close the connection, release resources used
        curl_close($ch);
         
           
        // do anything you want with your response
         
        return $response;
      }catch(\Exception $e)
      {
        return false;
      }

   
  }

  
  public static  function getPCMonth($year)
  {
   $months= \DB::select(\DB::raw("call  getPayrollCloseMonth($year)"));
   return $months;

     
  }

  public static function getEmpAllowances($id,$orgID)
  {
    $models= \DB::select(\DB::raw("call  getEmpAllowances($id,$orgID)"));
       if(sizeof($models)>0)
       {
        return  collect($models);
       }else{
    $models=Allowance::where(['organization_id'=>$orgID])->get();
        
      return $models;

        
       }

  }




  public static function getSupplierDetails($number)
  {


    
  


    $username='c5775b8be304b2e94e94b5bb05e91955';
$password='c6uurhm3wcshd37n4qfqeby45fr65hwt4ezgpozn3nelqcqmvzea====';
$URL='https://brs.ecitizen.go.ke/api/businesses?registration_number='.$number;

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,$URL);
curl_setopt($ch, CURLOPT_TIMEOUT, 30); //timeout after 30 seconds
curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
$result=curl_exec ($ch);


$status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);   //get status code
curl_close ($ch);
return  json_decode($result);


  }

  public static function PermissionStage($stage)
  {
    $model=PermissionStage::where(['stage'=>$stage])->first();

     if($model)
     {

     return  $model->permission;
     }else{
      return false;
     }
  }


  public static function PermissionPercentage($stage)
  {
    $model=PermissionStage::where(['stage'=>$stage])->first();
    

     if($model)
     {

     return  $model->percentage;
     }else{
      return false;
     }

  }




  public static  function sendBulkSms($message,$numbers){
    return true;

  }

  public static function getDays($start_date,$end_date){
    $date1 = new DateTime($start_date);
$date2 = new DateTime($end_date);

 $diff = $date2->diff($date1)->format("%a");
  return  $diff;

  }

   public static function getNHIF($amount){

    $models=Nhif::all();
      foreach($models as $model)
      {
        $min=$model->minsal;
        $max=$model->maxsal;


             if($max==0 && $amount>=$min)
            {
              $nhif=$model->deduction;
              return  $nhif;
            }
            else
            {
                if ($amount<=$max && $amount>=$min)
                {
                  $nhif=$model->deduction;
                   return $nhif;
                }
            }



    }
}

public static function custom_number_format($n, $precision = 3) {
    if ($n < 1000000) {
        // Anything less than a million
        $n_format = number_format($n);
    } else if ($n < 1000000000) {
        // Anything less than a billion
        $n_format = number_format($n / 1000000, $precision) . 'M';
    } else {
        // At least a billion
        $n_format = number_format($n / 1000000000, $precision) . 'B';
    }

    return $n_format;
}

public static function getNSSF($amount)
{
  $models=NssfRate::all();
    
      foreach($models as $model)
      {
        $min=$model->minsal;
        $max=$model->maxsal;


             if($max==0 && $amount>=$min)
            {
               
              return  $model;
            }
            else
            {
                if ($amount<=$max && $amount>=$min)
                {
                  return  $model;
                }
            }



    }

}

public static  function getMonthList()
{
     $months=array("1"=>"January","2"=>"February","3"=>"March","4"=>"April",
        "5"=>"May",'6'=>"June","7"=>"July","8"=>"August","9"=>"September",
        "10"=>"October","11"=>"November","12"=>"December"


             );
       return $months;

}

public static  function getYearsList()
{//this function to be changed once the data is sorted
     $years=array("2024"=>"2024");
       return $years;

}




public static function getOldNSSF($amount){
  $model=Nssf::find(1);

   $rate=$model->rate;
   $minmum_amount=9000;
   $maxmum_amount=36000;
   if($amount<$minmum_amount)
    {
      $nssf=0;
      return  $nssf;
    }
    elseif ($amount>=$maxmum_amount)
    {
      $value=$maxmum_amount*$rate/100;
      $nssf=$value;
      return  $nssf;
    }
    else
    {
      $value=ceil($amount*$rate/100);
      return $value;
    }

}

public static function OtherDeduction($model){
  $basic=$model->basic_salary;
  $allowances=$model->total_allowances;
  $gross=$basic+$allowances;
  $total_deductions=0;
  $models=OtherDeduction::all();
   foreach($models as $model){
    $type=$model->type;
     switch ($type) {
       case 'Percentage':
         $value=($model->value/100)*$basic;
          $total_deductions=$total_deductions+$value;
         break;
       
       default:
       $value=$model->value;
        $total_deductions=$total_deductions+$value;
         
     }


   }
   return $total_deductions;


}
public static function getCommition($id,$month,$year){
  $model=Commission::where(['user_id'=>$id])->whereYear('created_at','=',$year)
       ->whereMonth('created_at','=',$month)
       ->sum('amount');
  return $model;

}
public static function getMonthlyDeduction($id,$month){


  $now=date('Y-m-d');
   
   $deductions=MonthlyDeduction::where(['user_id'=>$id])
              ->where('end_date','>=',$now)
              ->where('start_date','<=',$now)
              ->where('status','Pending')
              ->get();

              
    $total_deduction=0;

    foreach($deductions as $deduction)
    {
       //dd($deduction);
      $model=EmployeeDeduction::where(['user_id'=>$id,
                         'deduction_id'=>$deduction->id,
                         'month'=>$month,
                         'year'=>date('Y')])->first();
         if(!$model){
          $model=new EmployeeDeduction();
          $model->user_id=$id;
          $model->deduction_id=$deduction->id;
          $model->month=$month;
          $model->year=date('Y');
          $model->dedication_name=$deduction->dedication_name;
          $model->amount=$deduction->amount;
          $model->date=$now;
           if($deduction->deduction_type=="Fixed"){
            $amount_deducted=$deduction->value;
            $total_contribution=EmployeeDeduction::where(['user_id'=>$id,'deduction_id'=>$deduction->id])->latest('id')->first();
             if($total_contribution){
              $total_contribution=$total_contribution->total_deduction;
             }else{
              $total_contribution=0;
             }
            $model->amount_deducted=$deduction->value;
            $model->total_deduction=$total_contribution+$amount_deducted;
            $amount_due=$deduction->amount;
            $model->balance=$amount_due-$model->total_deduction;
            $total_deduction=$total_deduction+$deduction->value;
            if($model->balance==0)
            {
              $deduction->status="Completed";
              $deduction->save();
            }




             $model->save();
           }

           else{

             $value=$deduction->value;
             $amount=Self::getDeductionValue($value,$id);
             $total_contribution=EmployeeDeduction::where(['user_id'=>$id,'deduction_id'=>$deduction->id])->latest('id')->first();
             if($total_contribution)
             {
              $balance=$total_contribution->balance;
              $total_contribution=$total_contribution->total_deduction;
             }else{
              $total_contribution=0;
              $balance=$deduction->amount;
             }
              
              if($balance>$amount)
              {
                 $amount=$amount;

              }else{
                $amount=$balance;
              }
            $model->amount_deducted=$amount;
            $model->total_deduction=$total_contribution+$amount;
            $amount_due=$deduction->amount;
            $model->balance=$amount_due-$model->total_deduction;
             if($model->balance==0){
              $deduction->status="Completed";
              $deduction->save();
             }
            $total_deduction=$total_deduction+$amount;
            $model->save();
           }
         }
    }
     return $total_deduction;

}
public static function createRepaymentRecord($loan,$year,$month,$orgID)
{
   try{
     $model=LoanRepayment::where(['loan_id'=>$loan->id,'month'=>$month,'year'=>$year])->first();

      if(!$model)
        {
          $model=new LoanRepayment();
          $model->loan_id=$loan->id;
          $model->user_id=$loan->user_id;
          $model->organization_id=$orgID;
          $model->repay_date=date('Y-m-d');
          $model->old_balance=$loan->total_amount-$loan->amount_paid;
          $model->amount=$loan->monthly_amount;
          $model->new_balance=$model->old_balance-$model->amount;
          $model->month=$month;
          $model->year=$year;
          $model->ref_number=self::getLoanRef();
          $model->save();
           $loanModel=Loan::find($loan->id);
           $loanModel->amount_paid=$loanModel->amount_paid+$model->amount;
           $loanModel->last_month_paid=$month;
           $loanModel->last_year_paid=$year;
           $loanModel->last_amount_paid=$loan->monthly_amount;
           $loanModel->save();

        }
      return $model->amount;

   }catch(\Exception $e)
   {
      dd($e);
     Self::sendEmailToSupport($e);
      return 0;
   }
  
  

}
public static function getLoanRef()
 {
  $model=LoanRepayment::latest('id')->first();
   if($model)
   {
    return $model->ref_number+1;
   }else{
    return 1000;
   }
 }
public static function processLoan($staff,$year,$month,$orgID)
{
   $loans= \DB::select(\DB::raw("call  getStaffLoan($staff->user_id)"));
     if(sizeof($loans)<1)
     {
      $amount=0;
     }else{
       $loan=(object)$loans[0];
        $amount=self::createRepaymentRecord($loan,$year,$month,$orgID);
       
     }
     return $amount;
    
}

public static function getLoanInterests($staff,$year,$month)
{

  //
   $models= \DB::select(\DB::raw("call  getStaffUserLoanInterest($staff->user_id,'$month','$year')"));


    return $models[0]->total_interst;


}

public static function processOtherDeductions($staff,$year,$month,$orgID)
 {
  $monthly_models= \DB::select(\DB::raw("call  GetEmpMonthLyDeductions($staff->user_id)"));
  $monthly_models=collect($monthly_models);
    $month_sum=0;
    
     foreach($monthly_models as $mod)
     {
      $month_sum=$month_sum+$mod->monthly_amount;
      $deduction=self::createDeductionPayment($mod,$year,$month,$orgID);
     }

     $overtime_models= \DB::select(\DB::raw("call  getEmpOverTimeDeductions($staff->user_id)"));
  $monthly_models=collect($overtime_models);

    foreach($monthly_models as $mod)
     {
      $month_sum=$month_sum+$mod->monthly_amount;
      $deduction=self::createDeductionPayment($mod,$year,$month,$orgID);
     }

  







    return $month_sum;

  

 }

 public  static function  AddMonthlyAllowances($staff,$year,$month,$orgID)
 {
    
   
  

        $list= \DB::select(\DB::raw("call  EmployeeMonthAllowances($year,'$month',$staff->user_id)"));
         $list=collect($list);

         if(sizeof($list)>0)
         {
             foreach($list as $allowance)  
             {
                 
                   
                  $allowanceModel=Allowance::find($allowance->allowance_id);

                 
               
                $model=MonthlyAllowance::where(['user_id'=>$staff->user_id,'month'=>$month,'year'=>$year,'allowance_id'=>$allowance->allowance_id])->first();
                   if(!$model)
                   {
                    $model=new MonthlyAllowance();
                    $model->user_id=$staff->user_id;
                    $model->month=$month;
                    $model->year=$year;
                    $model->allowance_id=$allowance->allowance_id;
                    $model->month_code=date('Ym',strtotime($year.$month));
                    $model->organization_id=$orgID;
                    $model->created_by=\Auth::user()->id;
                   }
                   $model->updated_by=\Auth::user()->id;
                   $model->amount=$allowance->amount;
                   $model->save();
                    
                       if($allowanceModel->allowance_type=="Once")
                       {
                          $empallowance=EmpAllowance::find($allowance->id);
                          $empallowance->allowance_status="PROCESSED";
                          $empallowance->save();

                       }

                   
                   

             }
         }
         $sum=$list->sum('amount');
          
        return $sum;
 }




 public static function createDeductionPayment($mod,$year,$month,$orgID)
 {
  try{
      

    $model=DeductionPayment::where(['user_id'=>$mod->user_id,'deduction_id'=>$mod->id,'month'=>$month,'year'=>$year])->first();
          if(!$model)
          {
             $model=new DeductionPayment();
             $model->user_id=$mod->user_id;
             $model->deduction_id=$mod->id;
             $model->month=$month;
             $model->year=$year;
             $model->organization_id=$orgID;
             $model->created_by=\Auth::user()->id;
          }else{
             $model->updated_by=\Auth::user()->id;
          }
    
   $model->amount=$mod->monthly_amount;
   $model->month_code=date('Ym',strtotime($year."-".$month));
   $model->save();

   $deduction=Deduction::find($model->deduction_id);
    $deduction->amount_paid=$deduction->amount_paid+$model->amount;
      if($mod->type=="Once" || $mod->type=="TimeFrame")
     {
         $deduction->balance=$deduction->total_amount-$deduction->amount_paid;
         $deduction->ded_status=($deduction->balance==0)?"Deducted":"Active";
     }
      $deduction->save();


  }catch(\Exception $e)
  {
     dd($e);
    Self::sendEmailToSupport($e);
  }
   
  
   

 }

public static function getDeductionValue($value,$id){
  $model=Employee::where(['user_id'=>$id])->first();
   $type=$model->employee_type;
   switch ($type) {
     case 'Non Salaried':
      $commission=Commission::where(['user_id'=>$id])
                 ->whereMonth('created_at','=',date('m'))
                 ->sum('amount');
      $amount=($value*$commission)/100;
      return $amount;
      break;
     
     default:
      $amount=($value*$model->basic_salary)/100;
        return $amount;
       
       break;
   }

}

public static function processSalaries(){

   $models=Employee::all();
   $total_payee=0;
   $total_nhif=0;
   $total_nssf=0;
   $total_salaries=0;
    $date=date('Y-m-');
    $date=($date."25");

    

     



   if( strtotime('now') > strtotime($date) ) {
     $Fullmonth=date('M');
     $month=date('m');
      $year=date('Y');
   } 
   else{
    $Fullmonth=date('M', strtotime('first day of last month'));
    $month=date('m', strtotime('first day of last month'));
   
   $year=date('Y', strtotime('first day of last month'));
   }
$id=array();


       foreach($models as $model){
         if($model->employee_type=="Non Salaried"){
          $basic_salary=0;
          $other_allowances=0;
          $nssf=0;
         }else{
          $basic_salary=$model->basic_salary;
          $other_allowances=$model->total_allowances;
          $nssf=200;
         }

         $commision=Self::getCommition($model->user_id,$month,$year);
         $total_allowances=0;
        $gross_income=$basic_salary+$other_allowances;
        //Helper::getNSSF($gross_income);
        
          $payment=MonthPayment::where(['month'=>$Fullmonth,'year'=>date('Y'),'employee_id'=>$model->id])->first();
           if(!$payment){
            $payment=new MonthPayment();
           }
        
        $payment->user_id=$model->user_id;
        $payment->employee_id=$model->id;
        $payment->basic_salary=$basic_salary;
        $payment->total_allowances=$model->total_allowances;
        $payment->commission=$commision;
        $pension=0;
        $taxable_income=$gross_income-$nssf-$pension;
        $payment->nssf=$nssf;
        $monthDeduction=Self::getMonthlyDeduction($model->user_id,$Fullmonth);
        $payment->monthly_deduction=$monthDeduction;
         $my_payee=Helper::payee($taxable_income)-config('app.personal_relief');
          if($my_payee<=0)
          {
            $my_payee=0;
          }else{
            $my_payee=$my_payee;
          }
        $payment->payee=$netpaye=$my_payee;
        $advanced=Self::advanced($model->user_id,$Fullmonth,$year);
        $other_deductions=Helper::OtherDeduction($model);
        if($model->employee_type=="Non Salaried"){
        $payment->nhif=$nhif=0;

      }else{
        $payment->nhif=$nhif=Helper::getNHIF($taxable_income);
      }
        $absent=0;

        $total_deductions=$netpaye+$nssf+$nhif+$advanced+$other_deductions+$absent+$monthDeduction;
        $payment->advanced=$advanced;
        $payment->year=$year;
        $payment->month=$Fullmonth;
        $payment->total_deductions=round($total_deductions,2);
        $payment->net_pay=$gross_income-$total_deductions+$commision;
        $payment->other_deductions=$other_deductions;
        $payment->total_earnings=$basic_salary+$commision+$model->total_allowances;
        $payment->save();

        $nhif=Helper::getNHIF($gross_income);
        $total_payee=$total_payee+$netpaye;
        $total_nhif=$total_nhif+$nhif;
        $total_nssf=$total_nssf+$nssf;
        $total_salaries=$total_salaries+$payment->basic_salary;
         
       }

       



       $model=Expense::where(['name'=>'Salaries'])->first();
       
       $expense=MonthlyExpense::where(['expense_name'=>'Salaries','monthy'=>$month,'year'=>$year])->first();
        if(!$expense){
          $expense=new MonthlyExpense();
        }
       $expense->expense_id=$model->id;
       $expense->expense_name=$model->name;
       $expense->monthy =$month;
       $expense->date_incured=date('Y-m-d');
       $expense->year=$year;
       $expense->amount_spent=$total_salaries;
       $expense->save();


       $expense=MonthlyExpense::where(['expense_name'=>'NHIF','monthy'=>$month,'year'=>$year])->first();

       $model=Expense::where(['name'=>'NHIF'])->first();
        if(!$expense){
          $expense=new MonthlyExpense();
        }
       $expense->expense_id=$model->id;
       $expense->expense_name=$model->name;
       $expense->monthy =$month;
       $expense->year=$year;
       $expense->date_incured=date('Y-m-d');
       $expense->amount_spent=$total_nhif;
       $expense->save();


        

       $model=Expense::where(['name'=>'NSSF'])->first();
       $expense=MonthlyExpense::where(['expense_name'=>'NSSF','monthy'=>$month,'year'=>$year])->first();

         if(!$expense){
           $expense=new MonthlyExpense();
         }
       $expense->expense_id=$model->id;
       $expense->expense_name=$model->name;
       $expense->monthy =$month;
       $expense->year=$year;
      $expense->date_incured=date('Y-m-d');
       $expense->amount_spent=$total_nssf;
       $expense->save();

        $model=Expense::where(['name'=>'PAYE'])->first();
       $expense=new MonthlyExpense();
       $expense->expense_id=$model->id;
       $expense->expense_name=$model->name;
        $expense->monthy =$month;
       $expense->year=$year;
        $expense->date_incured=date('Y-m-d');
       $expense->amount_spent=$total_payee;
       $expense->save();



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



public static function Payee($amount,$year){

    

 $models=Paye::where(['year'=>$year])->get();
   

$num=sizeof($models);
  $i=0;
  $paye2=0;
   foreach($models as $model){
     $min[$i]=$model->minsal;
     $max[$i]=$model->maxsal;
     $rate[$i]=$model->rate;
    $id[$i]=$model->id;
    if($max[$i]==0 && $amount>=$min[$i])
     {
     
      for ($j=0;$j<$num;$j++)
      {
        if($max[$j]==0)
        {
          $diff=$amount-$min[$j];
          $paye1=$diff*$rate[$j]/100;
          $paye2+=$paye1;
        }
        elseif ($min[$j]==0)
        {
          $diff=$max[$j]-$min[$j];
          $paye1=$diff*$rate[$j]/100;
          $paye2+=$paye1;
        }
        else
        {
          $diff=$max[$j]-$min[$j]+1;
          $paye1=$diff*$rate[$j]/100;
          $paye2+=$paye1;
        }
      }
      return  $paye2;
      break;
     }
     
     elseif ($amount<=$max[$i] && $amount>=$min[$i])
     {
       $t=$amount;

      for ($j=0;$j<$id[$i];$j++)
      {

      if(isset($max[$j]) && isset($min[$j]))
        {
            $d=$max[$j]-$min[$j];
        if($t<$d)
        {
          $paye1=$t*$rate[$j]/100;
          $paye2+=$paye1;
        
        }
        else
        {
          $diff=$max[$j]-$min[$j];
          
          $paye1=$diff*$rate[$j]/100;
          $paye2+=$paye1;
          $t=$t-$diff;
        }

           
             
           }else{
            continue;
           }
        

        
      }
      return $paye2;
      break;
     }
     $i++;
   }

}





    


   public static  function send($phone,$message)
    {
       
       
      // Specify your login credentials
      $username   = "flixxqueisy";
      $apikey     = "bcfe7f6137ef8541dc10ee99efe048ca0a23f45b5745c38cb8c854d16a3dc313";
      
      // Specify the numbers that you want to send to in a comma-separated list
      // Please ensure you include the country code (+254 for Kenya in this case)
      $recipients = $phone;
      $sendername='E-health Care System';
      // And of course we want our recipients to know what we really do
      $message    = $message;
      
        // Create a new instance of our awesome gateway class
      $gateway    = new AfricasTalkingGateway($username, $apikey);
      
      // Any gateway error will be captured by our custom Exception class below,
      // so wrap the call in a try-catch block
try
      {
        // Thats it, hit send and we'll take care of the rest.
        $results = $gateway->sendMessage($recipients, $message);
          
        foreach($results as $result) {
          // status is either "Success" or "error message"
          echo " Number: " .$result->number;
          echo " Status: " .$result->status;
          echo " MessageId: " .$result->messageId;
          echo " Cost: "   .$result->cost."\n";
        }
      }
      catch ( AfricasTalkingGatewayException $e )
      {
        echo "Encountered an error while sending: ".$e->getMessage();
      }

    }


 public static function permsUsers($permissionName)
{

$userList = User::whereHas('roles.perms', function($query) use ($permissionName) {
    $query->whereName($permissionName);
})->get();

  return $userList;
}


public static function createNotification($user,$message_body,$subject=null,$sendEmail=true)
 {
  
          $message=new Messaging();
          $message->sender_id =auth::user()->id;
          $message->receiver_id=$user->id;
          $message->subject=$subject;
          $message->content =$message_body;
          $message->status="Unread";
          $message->flag="notification";
          $message->key=str_random(13);
          $message->save();

          Self::sendEmail($user->email,$message_body,$subject);
           
          
   
 }


	


	public static function sendEmail($email, $message_body, $subject) 
	{
   
      
        try 
        {
          
            Mail::send('emails.Institution', array('mail_body' => $message_body), function ($message) use ($email, $subject) {
                $message->to($email)->subject($subject);
            });
        } 

        catch (Exception $e)
        {
             
            //\Log::error($e->getMessage());
            return false;
        }

    }

    public  static function sendBulkEmail($cc_emails,$body,$subject)
    {
      try{
        $email=config('app.support_email');
        
       Mail::send('emails.layout', array('mail_body' => $body), function ($message) use ($email, $subject,$cc_emails) {
                $message->to($email);
                 foreach($cc_emails as $key)
                 {
                    $message->cc($key);
                 }
                 $message->cc($email,"Admin");
                 $message->replyTo($email,"Admin");
                 $message->subject($subject);
            });
     }catch(\Exception $e)
     {
      return $e;
     }

    }






      public static function FindRoleDetails($param,$value){

        try{
          $role=Role::where($param,$value)->first();
          return $role;
          }catch(\Exception $e)
          {
            Self::sendEmailToSupport($e);

          }

    }
    public static function advanced($user_id,$month,$year){
       
      $advancedpayments=AdvancedPayment::where(['user_id'=>$user_id,'application_status'=>'Approved','month'=>$month,'year'=>$year])->first();
      if($advancedpayments){
        $advanced=$advancedpayments->amount_applied;
      }else{
       $advanced=0; 
      }
     return $advanced;
    }








    public static function emailCustomerCare($model){
      $email=config('app.email');
      $body=Auth::user()->name." has created a new inquery request with the folowing details<br> <b>Topic</b> :".$model->topic->title."<br> <b>Priority </b>:".$model->priority."<br> <strong>Description</strong> :".$model->description;
      ;
      $subject="New Inquery -Ticket No :".$model->ticket_number;
      Self::sendEmail($email,$body,$subject);



      

    }


        public static function sendEmailToSupport($body) 
       { 
        
         //return true;
        try 
        {

            $email=config('app.Support_Email');
            $subject="KENYA-HRIS-Development Error";

            Mail::send('emails.errors', array('e' => $body), function ($message) use ($email, $subject) {
                $message->to($email)->subject($subject);
            });
        } 

        catch (\Exception $e)
        {
          
            \Log::error($e->getMessage());
        }

    }

    public static  function age($dob){
      $dob=date('Y-m-d',strtotime($dob));
    $diff = (date('Y') - date('Y',strtotime($dob)));
    return ($diff==0)?1:$diff;

    }


    public static function getRation($a,$b){
      $var1=$a;
     $var2=$b;

for($x=$var2;$x>1;$x--) {
if(($var1%$x)==0 && ($var2 % $x)==0) {
$var1 = $var1/$x;
$var2 = $var2/$x;
}
 }
return "$var1 : $var2";

    }


    public static function processNumber($no){
     $sub_number=substr($no, 0,4);
        if(preg_match("/25/i", $sub_number)){
          return $no;
        }else{
          $sub_number=substr($no, 0,2);
          $other_option=substr($no, 0,1);
            if($sub_number==07){
              $add_number=substr($no, 1,20);
              $new_nmber="+254".$add_number;
               return $new_nmber;
              
            }
            else if($other_option=="7")
            {
               $add_number=substr($no, 0,20);
              $new_nmber="+254".$add_number;
               return $new_nmber;

            }

            else{

              ///from excel
                $sub_number=substr($no, 0,1);
               if(preg_match('/7/i',$sub_number )){
                $add_number=substr($no, 0,10);
              $new_nmber="+254".$add_number;
               return $new_nmber;
              

               }else{
                return $no;
               }
              
            }

           
           
        }
} 
public static function getStaffValue($profile,$year)
{
   $sum=Payment::where(['user_id'=>$profile->user_id,'year'=>$year])->sum('insurance_relief');
   $gov_amount=60000;
   $balance=$gov_amount-$sum;
    return $balance;
}

public  static function getInsuranceRelief($profile,$year)
{
    if($profile->insurance_premium==0)
    {
      return 0;
    }else{
        
        $remaining_value=self::getStaffValue($profile,$year);
        
       $amount=$profile->insurance_premium;
        $possible_value=0.15*$amount;
            if($remaining_value>$possible_value)
            {
              $value=$possible_value;
            }else{
              $value=$remaining_value;
            }
        return $value;
    }
  

}

public static function processUpload($photo,$user=null){
  
  if($user==null){
    $user=\Auth::user();
  }

  $name="profile_".$user->id;


    $id=$user->id;

    $file = array('image' => $photo);
    $rules = array('image' => 'required',); //mimes:jpeg,bmp,png and for max size max:10000
    $validator = Validator::make($file, $rules);
    if ($validator->fails()) {
      // send back to the page with the input data and errors
      return redirect()->back()->withInput()->withErrors($validator);
    }
    else {
     // checking file is valid.
      if ($photo->isValid()) {
     $destinationPath = base_path() . '/storage';; // upload path
        $extension = $photo->getClientOriginalExtension(); // getting 
        $fileName =$name.'_image.'.$extension; // renameing image
        $extenstion_names=array('jpeg','jpg','png');
         foreach($extenstion_names as $key){
           $start_name=substr($user->profile->profile_image,0,17).".".$key;
            
             @unlink(storage_path($start_name));
            
         }
        
      $photo->move($destinationPath, $fileName); // uploading file to 
        $name= $fileName;
         
       return $name;

       }
      else {
        return redirect()->back()->with('msg','File is Not valis');
      }
    }
  }

  public static function findExpenseAmount($expense_id,$month=null,$year=null,$column=null){

    if($month==null){
      $month=date('m', strtotime('first day of last month'));
    }
    if($year==null){
     $year=date('Y', strtotime('first day of last month')); 
    }

     if($column==null){
      $column="amount_spent";
     }

  $model=MonthlyExpense::where(['expense_id'=>$expense_id,'year'=>$year,'monthy'=>$month])->latest()->first();
      if($model){
        return $model->$column;
      }else{
        $expense=Expense::find($expense_id);
         if($expense->expense_type=="Fixed"){
            if($column=="date_incured"){
              return $expense->date_incured;
            }
          return $expense->amount;

         }else{
          return "";
         }
      }
     
       
  }

  public static function MonthName($month){
    $year=date('Y');
    $jd=gregoriantojd($month,13,$year);
return  jdmonthname($jd,0);
  }

   









public static function copyFile($copy,$old_directory,$new_directory){
         $name=$copy->other_meta_data;
         try{
            $exists = Storage::disk('local')->has($new_directory.'/'.$name);
             if($exists==false){
              Storage::copy($old_directory.'/'.$name, $new_directory.'/'.$name);
             }
           
        return true;

         }catch(\Exception $e){
            return true;
         }
        

    }

    public static function moveDocument($model,$old_directory,$new_directory){
        $name=$model->other_meta_data;
         try{
            $exists = Storage::disk('local')->has($new_directory.'/'.$name);
             if($exists==true){
              Storage::move($old_directory.'/'.$name, $new_directory.'/'.$name);
             }
           
        return true;

         }catch(\Exception $e){
            return true;
         }
    }

    public static function deleteDocument($model){
        $old_directory=$model->category->category;
         $name=$model->other_meta_data;
         
          try{
            $exists = Storage::disk('local')->has($old_directory.'/'.$name);
             if($exists==true){
                
              Storage::delete($old_directory.'/'.$name);
             }
           
        return true;

         }catch(\Exception $e){
            return true;
         }
    }

 public static function processDocument($photo,$name,$directory){
    $file = array('file' => $photo);
    $rules = array('file' => 'required',); //mimes:jpeg,bmp,png and for max size max:10000
    $validator = Validator::make($file, $rules);
    if ($validator->fails()) {
      // send back to the page with the input data and errors
      return redirect()->back()->withInput()->withErrors($validator);
    }
    else {
        
     // checking file is valid.
      if ($photo->isValid()) {
     $paths= '/uploads/docs/';

     $destinationPath = public_path().'/uploads/docs';
     $extension = $photo->getClientOriginalExtension(); // getting 
     $mime=$photo->getClientMimeType();
     $orginal=$photo->getClientOriginalName();
     $size=round($photo->getClientSize()/(1024*1024),2);
      $fileName =date('Ymdhis').'_doc.'.$extension; // renameing image
      $extension = $photo->getClientOriginalExtension();
     Storage::disk('local')->put($directory."/".$photo->getFilename().'.'.$extension,  File::get($photo));
     $file_name=$photo->getFilename().'.'.$extension;
     $name= $fileName;
         $a=array('name'=>$name,'type'=>$extension,'mime'=>$mime,'original'=>$orginal,'size'=>$size,'file_name'=>$file_name);

         
       return $a;

       }
      else {
        return redirect()->back()->with('msg','File is Not valis');
      }
}


}


public static function getRoleUsers($name,$orgID){
  $role=Role::where('name',$name)->first();
  $models=UserRole::join('users','users.id','=','role_user.user_id')
       ->select('users.id','email','phone','users.name')
        ->where(['role_id'=>$role->id,'users.organization_id'=>$orgID])->get();
   $users=array();
    foreach($models as $user){
    $users[]=$user;
    }
    return $users;
}
public static function getRoleUserClocked($name,$orgID,$clockStatus){
  $role=Role::where('name',$name)->first();
  $models=UserRole::join('users','users.id','=','role_user.user_id')
       ->select('users.id','email','phone','users.name')
        ->where(['role_id'=>$role->id,'users.organization_id'=>$orgID])->get();
   $users=array();
    foreach($models as $user){
    $users[]=$user;
    }
    return $users;
}
public static function getOrganization($id=null)
{
   if($id==null)
   {
    $id=auth::User()->organization_id;
   }
   $model=Organization::find($id);
  return ($model)?$model:null;
}

public static function UserRoles($user_id)
{
  $roles=UserRole::where(['user_id'=>$user_id])->pluck('role_id')->toArray();
   return $roles;
}


public static function UserRole($user_id)
{
  $roles=UserRole::join('roles','roles.id','=','role_user.role_id')
        ->where(['user_id'=>$user_id])->pluck('display_name')->first();
   return $roles;
}


public static function getEducationLevel($level,$field,$user_id){
  $model=StaffQualification::where(['user_id'=>$user_id,'qualification'=>$level])->first();
  return ($model)?$model->$field:'';
}


public static function getAllowance($user_id,$allowance){
  $model=EmployeeAllowance::where(['user_id'=>$user_id,'allowance_id'=>$allowance])->first();
  return ($model)?$model->amount:0;

}

public static function maskString ( $str, $start = 0, $length = null ) {
        $mask = preg_replace ( "/\S/", "*", $str );
        if( is_null ( $length )) {
            $mask = substr ( $mask, $start );
            $str = substr_replace ( $str, $mask, $start );
        }else{
            $mask = substr ( $mask, $start, $length );
            $str = substr_replace ( $str, $mask, $start, $length );
        }
        return $str;
    } 


public static  function getSettingDetails($type,$key)
{
  $model=Setting::where(['type'=>$type,'key'=>$key])->first();
  return ($model)?$model:null;

}  


public static  function getEligibleAmount($user_id=null)
{
  if($user_id==null)
  {
    $user_id=Auth::user()->id;
  }

  $profile=Profile::where(['user_id'=>$user_id])->first();
   if($profile)
   {
    $basic_salary=$profile->basic_salary;
    $allowed_percentage=SystemSetting::where(['Setting_Name'=>'Advanced-salary-percentage'])->first();
     if($allowed_percentage)
     {
      $percentage=$allowed_percentage->Setting_Value;
     $amount=($basic_salary*$percentage)/100;
      return $amount;

     }else{
      return false;
     }

   }



}

    

    
   
    
   

   
    


	


	

	

    
    

        

     



}