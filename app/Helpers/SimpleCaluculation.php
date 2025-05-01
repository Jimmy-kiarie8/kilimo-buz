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
use Modules\Usermanagement\Entities\ProductivityRate;
use Modules\Usermanagement\Entities\PriceListItem;
use Modules\Usermanagement\Entities\UnitPrice;
class SimpleCaluculation
{

   public  static function Create($rate,$productivityrate,$subitem)
   {
     
     
      $test=self::autoPopulateLevelOne($rate,$subitem);

      $primary=self::autoPopulatePainPrimaryLevels($rate,$subitem,$productivityrate);

      $subtotals=self::autocalculateSubTotals($rate,$subitem);
       
       }


    public  static function autocalculateSubTotals($model,$subitem)
    {   try{
            $subtotal=UnitRateItem::where(['rate_id'=>$model->id,'classification'=>'Primary','summation'=>1])->sum('total_amount');
             $model->sub_total=round($subtotal,4);
             $model->miscellaneous_cost=$model->sub_total*$subitem->miscellaneous_rate;
             $model->grand_total=round($subtotal+$model->miscellaneous_cost,2);
             $model->rate=$model->grand_total/$model->quantity;
             $model->save();
          return 1;

           }catch(\Exception $e)
           {
            return 0;
           }
    }


    public static  function autoPopulateLevelOne($model,$subitem)
    {

           $sub_itemId=$subitem->id;
          //$sub_itemId=38;

$levelOnemodels=ProductivityRate::where(['process_level'=>1,'subitem_id'=>$sub_itemId])->get();
           if(sizeof($levelOnemodels)>0)
          {

            foreach($levelOnemodels as $levelone)
            {
                $rateCode=$levelone->rate_code;
                 $unitrateitems=ProductivityRate::where(['item_subcategory'=>$levelone->rate_code,'subitem_id'=>$levelone->subitem_id,'display_type'=>'Secondary'])->get();
                 
                $sum=0;
                    foreach($unitrateitems  as $item)
                    {
                          
                        
                         
                         $pricelistItem=PriceListItem::where(['item_code'=>$item->rate_code])->first();
                         
                        //Create SubChilds  For Level One
                        $price=self::getPriceByRegion($model->region_id,$model->year,$item->rate_item_id);
                         
                            
                            
                        $itemmodel=UnitRateItem::where([
                            'item_unitratecode'=>$model->unit_rate_code,
                            'item_code'=>$item->rate_code,
                            'rate_id'=>$model->id,

                            'item_subcategory'=>$item->item_subcategory,

                            'classification'=>"Secondary",'item_id'=>$pricelistItem->id])->first();
                         

                          if(!$itemmodel)
                          {
                        $itemmodel=new UnitRateItem();
                        $itemmodel->rate_id=$model->id;
                        $itemmodel->item_id=$pricelistItem->id;
                        $itemmodel->units=$item->rate_unit;
                        $itemmodel->type=$item->rate_type;
                        $itemmodel->price_year=$model->year;
                        $itemmodel->org_id=$model->org_id;
                        }
                        $itemmodel->unit_price=$price;
                        $itemmodel->productivity_quantity=$item->quantity;
                        $itemmodel->total_amount=round($itemmodel->unit_price*$itemmodel->productivity_quantity,0);
                        $itemmodel->remarks=$item->remarks;
                        $itemmodel->item_name=$item->rate_name;
                        $itemmodel->item_unitratecode=$model->unit_rate_code;
                        $itemmodel->item_code=$item->rate_code;
                        $itemmodel->item_subcategory=$item->item_subcategory;
                         $itemmodel->classification="Secondary";
                        $itemmodel->save();

                        $sum=$sum+$itemmodel->total_amount;
                      }

                       //Log Parent at level one and exclude from other calculations
                        $quantity=$levelone->quantity;
                           
                          
                            if($levelone->is_concreate==1)
                            {

                                //log sub total so that they can appear on the outputs(pdf)

                                    $subtotalModel=UnitRateItem::where(['rate_id'=>$model->id,'classification'=>"Secondary",'item_subcategory'=>$levelone->rate_code,"item_name"=>"Subtotal",'item_unitratecode'=>$model->unit_rate_code])->first();
                                      if(!$subtotalModel)
                                      {
                                     $subtotalModel=new UnitRateItem();
                                      $subtotalModel->rate_id=$model->id;
                                      $subtotalModel->item_id=null;
                                      $subtotalModel->item_subcategory=$levelone->rate_code;
                                      $subtotalModel->classification="Secondary";
                                      $subtotalModel->item_name="Subtotal";
                                      $subtotalModel->price_year=$model->year;
                                      $subtotalModel->org_id=$model->org_id;
                                      $subtotalModel->item_unitratecode=$model->unit_rate_code;
                                      $subtotalModel->units=null;
                                      $subtotalModel->type=null;
                                      $subtotalModel->unit_price="";
                                      $subtotalModel->productivity_quantity=null;
                                      }
                                      $subtotalModel->summation=0;
                                      $subtotalModel->total_amount=$sum;
                                      $subtotalModel->remarks=null;
                                      $subtotalModel->item_code=null;
                                      $subtotalModel->save();

                                      //Add 10% to subtotal of these category
                                $concreateModel=UnitRateItem::where(['rate_id'=>$model->id,'classification'=>"Secondary",'item_subcategory'=>$levelone->rate_code,"item_name"=>"Miscellaneous Cost",'item_unitratecode'=>$model->unit_rate_code])->first();
                                  
                                   if(!$concreateModel)
                                   {
                                      $concreateModel=new UnitRateItem();
                                      $concreateModel->rate_id=$model->id;
                                      $concreateModel->item_id=null;
                                      $concreateModel->item_subcategory=$levelone->rate_code;
                                      $concreateModel->classification="Secondary";
                                      $concreateModel->item_name="Miscellaneous Cost";
                                      $concreateModel->price_year=$model->year;
                                      $concreateModel->org_id=$model->org_id;
                                      $concreateModel->item_unitratecode=$model->unit_rate_code;
                                      $concreateModel->units="%";
                                      $concreateModel->type=null;
                                   }
                                     
                                     
                                     if($levelone->concreate_has_subtotal==1)
                                     {
                                       $concreateModel->summation=1; 
                                     }else{
                                        $add_Concreate_To_Calculation=Helper::getAddConcreate();
                                        $concreateModel->summation=$add_Concreate_To_Calculation;

                                     }
                                    $concreateModel->unit_price=$sum;
                                   $concreateModel->productivity_quantity="10";
                                    $concreateModel->total_amount=round($concreateModel->unit_price*$levelone->concreate_ratio,0);
                                     $concreateModel->remarks="10 % of Subtotal";
                                    $concreateModel->item_code=null;
                                    $concreateModel->save();

                                      if($concreateModel->summation==1)
                                      {
                                         $sum=$sum+$concreateModel->total_amount;
                                      }

                                    


                                   
                                    
                            }//end of checking for concreates


                        $itemmodel=UnitRateItem::where(['item_unitratecode'=>$model->unit_rate_code,'item_name'=>$levelone->rate_name,
                            'process_level'=>1,'classification'=>"Primary" ,'rate_id'=>$model->id])->first();
                            if(!$itemmodel)
                           {
                             $itemmodel=new UnitRateItem();
                            $itemmodel->rate_id=$model->id;
                            $itemmodel->item_id=null;
                            $itemmodel->classification="Primary";
                            $itemmodel->process_level=1;
                            $itemmodel->item_name=$levelone->rate_name;
                            $itemmodel->price_year=$model->year;
                            $itemmodel->org_id=$model->org_id;
                            $itemmodel->item_unitratecode=$model->unit_rate_code;

                           }
                        $itemmodel->units=$levelone->rate_unit;
                        $itemmodel->type=$levelone->rate_type;
                        $itemmodel->unit_price=$sum;
                        $itemmodel->productivity_quantity=$quantity;
                        $itemmodel->total_amount=round($itemmodel->unit_price*$itemmodel->productivity_quantity,0);
                        $itemmodel->remarks=$levelone->remarks;
                        $itemmodel->item_code=$levelone->rate_code;
                        $itemmodel->item_subcategory=null;
                        $itemmodel->save();
                         

                    

                    
          }

          }
      }





      public static  function autoPopulatePainPrimaryLevels($model,$subitem,$productivityrate)
    {
      
       try{
         $levelOnemodels=ProductivityRate::where(['process_level'=>0,'subitem_id'=>$subitem->id,'display_type'=>'Primary'])->get();
          $name=$subitem->subitem_name;
           foreach($levelOnemodels as $levelone)
             {  

                $price=self::getPriceByRegion($model->region_id,$model->year,$levelone->rate_item_id);
                $itemmodel=UnitRateItem::where(['item_unitratecode'=>$model->unit_rate_code,'item_name'=>$levelone->rate_name,'classification'=>"Primary",'item_id'=>$levelone->subitem_id])->first();
                       if(!$itemmodel)
                         {
                        $itemmodel=new UnitRateItem();
                        $itemmodel->rate_id=$model->id;
                        $itemmodel->item_id=$model->subitem_id;
                        $itemmodel->units=$levelone->rate_unit;
                        $itemmodel->type=$levelone->rate_type;
                        $itemmodel->classification="Primary";
                        $itemmodel->price_year=$model->year;
                        $itemmodel->org_id=$model->orgId;
                        $itemmodel->item_unitratecode=$model->unit_rate_code;
                        }
                        $reinforcement_list=array("Reinforcement work (above 16mm)","Reinforcement work (below 16mm)");

                        if(in_array($name,$reinforcement_list) and  $levelone->rate_name=="price adjustment")
                        {
                            $price=Self::getReinformentSubTotal($model->id);
                             $itemmodel->unit_price=$price;
                             $itemmodel->productivity_quantity=$levelone->quantity;
                                if($itemmodel->productivity_quantity!=0)
                                {//check for zero to avoid divide by zero exception
                                    $itemmodel->total_amount=round($itemmodel->unit_price*($itemmodel->productivity_quantity/100),0);
 
                                }else{
                                     $itemmodel->total_amount=0;

                                }
                                                       
                        }else{
                             $itemmodel->unit_price=$price;
                             $itemmodel->productivity_quantity=$levelone->quantity;
                             $itemmodel->total_amount=round($itemmodel->unit_price*$itemmodel->productivity_quantity,0);
                        }
                        $itemmodel->remarks=$levelone->remarks;
                        $itemmodel->item_name=$levelone->rate_name;
                        $itemmodel->item_code=$levelone->rate_code;
                        $itemmodel->process_level=$productivityrate->process_level;
                        $itemmodel->item_subcategory=null;
                        $itemmodel->preprimarycode=$levelone->preprimarycode;
                        $itemmodel->save();
             }

       }catch(\Exception $e)
       {
        return 0;

       }
        

     





 }

 public  static  function getPriceByRegion($regionId,$year,$itemId)
    {
        $pricemodel=UnitPrice::where(['region_id'=>$regionId,'price_year'=>$year,'item_id'=>$itemId])->latest('id')->first();
           
           
          if($pricemodel)
          {
            return $pricemodel->price;
          }else{
            return 0;
          }
    }

    public static function getReinformentSubTotal($rate_id)
    {
        $model=UnitRateItem::where(['rate_id'=>$rate_id,'item_name'=>'Square twisted bars 16mm'])->first();
          if($model)
          {
            return $model->total_amount;
          }else{
            return 0;
          }

    }



              

             
               


    
        
 
   






  
 
}