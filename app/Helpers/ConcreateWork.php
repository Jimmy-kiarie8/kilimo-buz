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
use Modules\Usermanagement\Entities\UnitRateItem;
use DB;
;
class ConcreateWork
{

   public  static function CreateConcreateSubTotal($rate,$rateItem,$levelone)
   {
      
       $sum=self::getPrimaryTotal($rate,$rateItem);

        
     $subtotalModel=UnitRateItem::where(['rate_id'=>$rate->id,'classification'=>"Primary","item_name"=>"Subtotal",'item_unitratecode'=>$rate->unit_rate_code,"preprimarycode"=>$rateItem->preprimarycode,'item_subcategory'=>$rateItem->preprimarycode])->first();

           //CReate SubTotal Row
            if(!$subtotalModel)
             {
                  $subtotalModel=new UnitRateItem();
                  $subtotalModel->rate_id=$rate->id;
                  $subtotalModel->item_id=null;
                  $subtotalModel->item_subcategory=$rateItem->preprimarycode;
                  $subtotalModel->classification="Primary";
                  $subtotalModel->item_name="Subtotal";
                  $subtotalModel->price_year=$rate->year;
                  $subtotalModel->org_id=$rate->org_id;
                  $subtotalModel->item_unitratecode=$rate->unit_rate_code;
                  $subtotalModel->units=null;
                  $subtotalModel->type=null;
                  $subtotalModel->unit_price="";
                  $subtotalModel->productivity_quantity=null;
                  $subtotalModel->preprimarycode=$rateItem->preprimarycode;
                }
              $subtotalModel->summation=0;
              $subtotalModel->total_amount=$sum;
              $subtotalModel->remarks=null;
              $subtotalModel->item_code=null;
              $subtotalModel->save();



              //Create Miscellanious Row

               $miscellaniousRowModel=UnitRateItem::where(['rate_id'=>$rate->id,'classification'=>"Primary",'item_subcategory'=>$rateItem->preprimarycode,"item_name"=>"Miscellaneous Cost",'item_unitratecode'=>$rate->unit_rate_code,"preprimarycode"=>$rateItem->preprimarycode])
                   ->first();

                    if(!$miscellaniousRowModel)
                   {
                      $miscellaniousRowModel=new UnitRateItem();
                      $miscellaniousRowModel->rate_id=$rate->id;
                      $miscellaniousRowModel->item_id=null;
                      $miscellaniousRowModel->item_subcategory=$rateItem->preprimarycode;
                      $miscellaniousRowModel->classification="Primary";
                      $miscellaniousRowModel->item_name="Miscellaneous Cost";
                      $miscellaniousRowModel->price_year=$rate->year;
                      $miscellaniousRowModel->org_id=$rate->org_id;
                      $miscellaniousRowModel->item_unitratecode=$rate->unit_rate_code;
                      $miscellaniousRowModel->units="%";
                      $miscellaniousRowModel->type=null;
                      $miscellaniousRowModel->preprimarycode=$rateItem->preprimarycode;
                   }
                   /*if($levelone->concreate_has_subtotal==1)
                     {
                       $miscellaniousRowModel->summation=1; 
                     }else{
                        $add_Concreate_To_Calculation=Helper::getAddConcreate();
                        $miscellaniousRowModel->summation=$add_Concreate_To_Calculation;

                     }*/
                     $miscellaniousRowModel->summation=0; 
                    $miscellaniousRowModel->unit_price=$sum;
                   $miscellaniousRowModel->productivity_quantity="10";
                    $miscellaniousRowModel->total_amount=round($miscellaniousRowModel->unit_price*$levelone->concreate_ratio,0);
                     $miscellaniousRowModel->remarks="10 % of Subtotal";
                    $miscellaniousRowModel->item_code=null;
                    $miscellaniousRowModel->save();

                                    
                         


      
        
     

    
   }

   public static function getPrimaryTotal($rate,$rateItem)
   {
     $subtotal=UnitRateItem::where(['rate_id'=>$rate->id,'classification'=>'Primary','preprimarycode'=>$rateItem->preprimarycode,'summation'=>1])->whereNotIn('item_name',array("Subtotal"))->sum('total_amount');
      
     return $subtotal;

   }


   public static function getRateSubTotal($rateid,$preprimarycode)
   {
    $models=DB::select(" select sum(total_amount) as amount  from unit_rate_items where  rate_id=? and preprimarycode=? and item_name not in( 'Subtotal')
",[$rateid,$preprimarycode]);
         if(sizeof($models)>0)
         {
            return $models[0]->amount;
         }else{
            return 0;
         }
   }
   
   






  
 
}