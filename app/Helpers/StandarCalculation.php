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
class StandarCalculation
{

   public  static function Create($rate,$productivityrate,$subitem)
   {
     
     $primary=self::getAllPreprimaries($rate,$subitem);
     $primary=self::autoPopulatePainPrimaryLevels($rate,$subitem,$productivityrate);

      

    $subtotalrow= Self::addPreSubTotalRow($rate,$subitem);

    if($subitem->miscellaneous_rate>0)
              {
                 self::addPreMiscellanious($rate,$subitem);
              }
              self::addPrePrimaryTotalRow($rate,$subitem);
    
       

   }


   public static function addPrePrimaryTotalRow($model,$subitem)
{
      
         $sum=0;
       foreach($model->items as $item)
       {
          if($item->classification=="Pre-Primary" && $item->summation==1)
          {
             $sum=$sum+$item->total_amount;
          }

       }
        $subtotalModel=UnitRateItem::where(['rate_id'=>$model->id,'classification'=>"Pre-Primary",
    "item_name"=>"Total"])->first();
      
         
            
            if(!$subtotalModel)
             {
                  $subtotalModel=new UnitRateItem();
                  $subtotalModel->rate_id=$model->id;
                  $subtotalModel->item_id=null;
                  $subtotalModel->item_subcategory="";
                  $subtotalModel->classification="Hiden-Pre-Primary";
                  $subtotalModel->item_name="Total";
                  $subtotalModel->price_year=$model->year;
                  $subtotalModel->org_id=$model->org_id;
                  $subtotalModel->item_unitratecode=$model->unit_rate_code;
                  $subtotalModel->units=null;
                  $subtotalModel->type=null;
                  $subtotalModel->preprimarycode="";
                }
              $subtotalModel->summation=0;
               $subtotalModel->unit_price=$sum;
                  $subtotalModel->productivity_quantity=1;
              $subtotalModel->total_amount=$sum;
              $subtotalModel->remarks="Sum  of(SubTotal + Miscellaneous Cost)";
              $subtotalModel->item_code="Z2";
              $subtotalModel->save();

              $model->grand_total=$model->miscellaneous_cost+$model->sub_total;
              $model->rate=$model->grand_total/$model->quantity;
              $model->save();
             



                

}
    public static function addPreMiscellanious($model,$subitem)
   {
      
    
     $sum=self::getPrePreprimarySubTotal($model);
       

   

       $miscellaniousRowModel=UnitRateItem::where(['rate_id'=>$model->id,'classification'=>"Pre-Primary","item_name"=>"Miscellaneous Cost"])
                   ->first();

                   $ratio=$subitem->miscellaneous_rate; 


                   $quantity= $ratio*100;
                    $total=$sum*$ratio ;  

                                  

                    if(!$miscellaniousRowModel)
                   {
                      $miscellaniousRowModel=new UnitRateItem();
                      $miscellaniousRowModel->rate_id=$model->id;
                      $miscellaniousRowModel->item_id=null;
                      $miscellaniousRowModel->item_subcategory=null;
                      $miscellaniousRowModel->classification="Pre-Primary";
                      $miscellaniousRowModel->item_name="Miscellaneous Cost";
                      $miscellaniousRowModel->price_year=$model->year;
                      $miscellaniousRowModel->org_id=$model->org_id;
                      $miscellaniousRowModel->item_unitratecode=$model->unit_rate_code;
                      $miscellaniousRowModel->units="%";
                      $miscellaniousRowModel->type=null;
                      $miscellaniousRowModel->preprimarycode=null;
                   }
                   $miscellaniousRowModel->summation=1; 
                   $miscellaniousRowModel->unit_price=$sum;
                   $miscellaniousRowModel->productivity_quantity=$ratio;
                   $miscellaniousRowModel->total_amount=round($total,0);
                   $miscellaniousRowModel->remarks=$quantity." % of Subtotal";
                   $miscellaniousRowModel->item_code="Z1";
                   $miscellaniousRowModel->save();

                   $model->miscellaneous_cost=$miscellaniousRowModel->total_amount;
                   $model->save();

                   
                    

                  
      

   }

   public static function getPrePreprimarySubTotal($model)
   {
       
       $sum=0;
         foreach($model->items as $item)
         {
             if($item->classification=="Pre-Primary" && $item->summation==1 )
          {
              if($item->item_name!="Miscellaneous Cost")
              {
                 $sum=$sum+$item->total_amount;
              }
            
          }

         }
      
    $subtotal=$sum;
    
      return $subtotal;

   }


   public static function addPreSubTotalRow($model,$subitem)
{
      
    $subtotalModel=UnitRateItem::where(['rate_id'=>$model->id,'classification'=>"Pre-Primary","item_name"=>"Subtotal"])->first();
      
          $sum=self::getPrePreprimarySubTotal($model);
           
            
            if(!$subtotalModel)
             {
                  $subtotalModel=new UnitRateItem();
                  $subtotalModel->rate_id=$model->id;
                  $subtotalModel->item_id=null;
                  $subtotalModel->item_subcategory=null;
                  $subtotalModel->classification="Pre-Primary";
                  $subtotalModel->item_name="Subtotal";
                  $subtotalModel->price_year=$model->year;
                  $subtotalModel->org_id=$model->org_id;
                  $subtotalModel->item_unitratecode=$model->unit_rate_code;
                  $subtotalModel->units=null;
                  $subtotalModel->type=null;
                  $subtotalModel->preprimarycode=null;
                }
                $subtotalModel->unit_price=$sum;
                 $subtotalModel->productivity_quantity=1;
              $subtotalModel->summation=0;
              $subtotalModel->total_amount=$sum;
              $subtotalModel->remarks=null;
              $subtotalModel->item_code="Z";
              $subtotalModel->save();
              $model->sub_total=$sum;
              $model->save();


}

    public static  function autoPopulatePainPrimaryLevels($model,$subitem,$productivityrate)
    {
      
       try{
         $levelOnemodels= $preprimaries=ProductivityRate::where(['subitem_id'=>$subitem->id,'display_type'=>"Pre-Primary","is_standard"=>1])->get();;


          $name=$subitem->subitem_name;
           foreach($levelOnemodels as $levelone)
             {  

                $price=self::getPriceByRegion($model->region_id,$model->year,$levelone->rate_item_id);
                $itemmodel=UnitRateItem::where(['item_unitratecode'=>$model->unit_rate_code,'item_name'=>$levelone->rate_name,'classification'=>"Pre-Primary",'item_id'=>$levelone->subitem_id])->first();
                       if(!$itemmodel)
                         {
                        $itemmodel=new UnitRateItem();
                        $itemmodel->rate_id=$model->id;
                        $itemmodel->item_id=$model->subitem_id;
                        $itemmodel->units=$levelone->rate_unit;
                        $itemmodel->type=$levelone->rate_type;
                        $itemmodel->classification="Pre-Primary";
                        $itemmodel->price_year=$model->year;
                        $itemmodel->org_id=$model->orgId;
                        $itemmodel->item_unitratecode=$model->unit_rate_code;
                        }
                        $reinforcement_list=array("Reinforcement work (above 16mm)","Reinforcement work (below 16mm)","Concrete bollards");

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


   public static function getAllPreprimaries($model,$subitem)
   {
    $preprimaries=ProductivityRate::where(['subitem_id'=>$subitem->id,'display_type'=>"Pre-Primary","is_standard"=>0])->get();
     foreach($preprimaries  as $preliminary)
      {
        $levelOnemodels=ProductivityRate::where(['process_level'=>0,'subitem_id'=>$subitem->id,
            'display_type'=>'Primary','preprimarycode'=>$preliminary->rate_code])->get();


          foreach($levelOnemodels  as $primarylevelone)
          {  //consider level 0

                 
               
              self::autoPopulateLevelOne($model,$subitem,$preliminary,$primarylevelone);
               self::createRateItem($model,$subitem,$primarylevelone,$preliminary);
          }
           /*Check if to add a sub total row*/
             Self::addSubTotalRow($model,$subitem,$preliminary);
            /*Check for Miscelannious Row*/
              if($preliminary->concreate_ratio>0)
              {
                 self::addMiscellanious($model,$subitem,$preliminary);
              }

              $grandTotal=self::getGrandTotal($model,$preliminary);
              self::addTotalRow($model,$subitem,$preliminary,$grandTotal);

               

              $unit_rate=round($grandTotal/$preliminary->sample_quantity);
              self::addPreprimaryItem($model,$preliminary,$unit_rate);
    }
      $rate_subTotal=UnitRateItem::where(['rate_id'=>$model->id,'classification'=>"Pre-Primary"])->whereNull('is_deleted')->sum('unit_rate');


      $model->sub_total=$rate_subTotal;
      $model->miscellaneous_cost=0;
      $model->grand_total=$model->sub_total+ $model->miscellaneous_cost;
        if($model->grand_total>0)
        {
            $total=$model->grand_total/$model->quantity;
           $model->rate=round($total,2); 
        }
      
      $model->save();

    

     

   }

   public static function getGrandTotal($model,$preliminary)
   {
     $grand_total=UnitRateItem::where(['rate_id'=>$model->id,'classification'=>'Primary','preprimarycode'=>$preliminary->rate_code,'summation'=>1])->sum('total_amount');
      return $grand_total;

   }

   public static function getPreprimarySubTotal($model,$preliminary)
   {
      
    $subtotal=UnitRateItem::where(['rate_id'=>$model->id,'classification'=>'Primary','preprimarycode'=>$preliminary->rate_code,'summation'=>1])->where('item_name','!=','Miscellaneous Cost')->sum('total_amount');
      return $subtotal;

   }

   public static function addMiscellanious($model,$subitem,$preliminary)
   {
      
    $sum=self::getPreprimarySubTotal($model,$preliminary);

   

       $miscellaniousRowModel=UnitRateItem::where(['rate_id'=>$model->id,'classification'=>"Primary",'item_subcategory'=>$preliminary->rate_code,"item_name"=>"Miscellaneous Cost",'item_unitratecode'=>$model->unit_rate_code,"preprimarycode"=>$preliminary->rate_code])
                   ->first();

                   $ratio=$preliminary->concreate_ratio; 
                   $quantity= $ratio*100;
                    $total=$sum*$ratio  ;  
                                  

                    if(!$miscellaniousRowModel)
                   {
                      $miscellaniousRowModel=new UnitRateItem();
                      $miscellaniousRowModel->rate_id=$model->id;
                      $miscellaniousRowModel->item_id=null;
                      $miscellaniousRowModel->item_subcategory=$preliminary->rate_code;
                      $miscellaniousRowModel->classification="Primary";
                      $miscellaniousRowModel->item_name="Miscellaneous Cost";
                      $miscellaniousRowModel->price_year=$model->year;
                      $miscellaniousRowModel->org_id=$model->org_id;
                      $miscellaniousRowModel->item_unitratecode=$model->unit_rate_code;
                      $miscellaniousRowModel->units="%";
                      $miscellaniousRowModel->type=null;
                      $miscellaniousRowModel->preprimarycode=$preliminary->rate_code;
                   }
                   $miscellaniousRowModel->summation=1; 
                   $miscellaniousRowModel->unit_price=$sum;
                   $miscellaniousRowModel->productivity_quantity=$quantity;
                   $miscellaniousRowModel->total_amount=round($total,0);
                   $miscellaniousRowModel->remarks=$quantity." % of Subtotal";
                   $miscellaniousRowModel->item_code=null;
                   $miscellaniousRowModel->save();
                    

                  
      

   }


   public static function addPreprimaryItem($model,$preliminary,$amount)
   {
       
         
          

    $preprimaryModel=UnitRateItem::where(['rate_id'=>$model->id,'classification'=>"Pre-Primary","item_name"=>$preliminary->rate_name,'item_unitratecode'=>$model->unit_rate_code])
                   ->first();
                     
                     
                   $quantity=1;
                   $total=$quantity*$amount;
                        
                     if($preliminary->rate_code=="B2")
                     {
                          $sample=$preliminary->sample_quantity;

                     }else{
                         $sample=$preliminary->sample_quantity;
                     }

                      
                    




                    if(!$preprimaryModel)
                   {
                      $preprimaryModel=new UnitRateItem();
                      $preprimaryModel->rate_id=$model->id;
                      $preprimaryModel->item_id=null;
                      $preprimaryModel->item_subcategory=null;
                      $preprimaryModel->classification="Pre-Primary";
                      $preprimaryModel->item_name=$preliminary->rate_name;
                      $preprimaryModel->price_year=$model->year;
                      $preprimaryModel->org_id=$model->org_id;
                      $preprimaryModel->item_unitratecode=$model->unit_rate_code;
                      $preprimaryModel->units=$preliminary->rate_unit;
                      $preprimaryModel->type=null;
                      $preprimaryModel->preprimarycode=null;
                   }
                       $preprimaryModel->summation=$preliminary->is_summable; 
                       $preprimaryModel->unit_price=round($total,2);
                       $preprimaryModel->productivity_quantity=$preliminary->quantity;
                       
                       $preprimaryModel->remarks=$preliminary->remarks;
                       $preprimaryModel->item_code=$preliminary->rate_code;
                       $preprimaryModel->sample_space=$sample;

                       $preprimaryModel->unit_rate=$preprimaryModel->unit_price*$preprimaryModel->productivity_quantity;
                       $preprimaryModel->total_amount=$preprimaryModel->unit_rate;




                       $preprimaryModel->save();
                        

                        
                       
       

   }

public static function addSubTotalRow($model,$subitem,$preliminary)
{
      
    $subtotalModel=UnitRateItem::where(['rate_id'=>$model->id,'classification'=>"Primary","item_name"=>"Subtotal",'item_unitratecode'=>$model->unit_rate_code,"preprimarycode"=>$preliminary->rate_code,'item_subcategory'=>$preliminary->rate_code])->first();
      
          $sum=self::getPreprimarySubTotal($model,$preliminary);
            
            if(!$subtotalModel)
             {
                  $subtotalModel=new UnitRateItem();
                  $subtotalModel->rate_id=$model->id;
                  $subtotalModel->item_id=null;
                  $subtotalModel->item_subcategory=$preliminary->rate_code;
                  $subtotalModel->classification="Primary";
                  $subtotalModel->item_name="Subtotal";
                  $subtotalModel->price_year=$model->year;
                  $subtotalModel->org_id=$model->org_id;
                  $subtotalModel->item_unitratecode=$model->unit_rate_code;
                  $subtotalModel->units=null;
                  $subtotalModel->type=null;
                  $subtotalModel->unit_price="";
                  $subtotalModel->productivity_quantity=null;
                  $subtotalModel->preprimarycode=$preliminary->rate_code;
                }
              $subtotalModel->summation=0;
              $subtotalModel->total_amount=$sum;
              $subtotalModel->remarks=null;
              $subtotalModel->item_code=null;
              $subtotalModel->save();

}


public static function addTotalRow($model,$subitem,$preliminary,$amount)
{
      
    $subtotalModel=UnitRateItem::where(['rate_id'=>$model->id,'classification'=>"Primary","item_name"=>"Total",'item_unitratecode'=>$model->unit_rate_code,"preprimarycode"=>$preliminary->rate_code,'item_subcategory'=>$preliminary->rate_code])->first();
      
          $sum=self::getPreprimarySubTotal($model,$preliminary);
            
            if(!$subtotalModel)
             {
                  $subtotalModel=new UnitRateItem();
                  $subtotalModel->rate_id=$model->id;
                  $subtotalModel->item_id=null;
                  $subtotalModel->item_subcategory=$preliminary->rate_code;
                  $subtotalModel->classification="Primary";
                  $subtotalModel->item_name="Total";
                  $subtotalModel->price_year=$model->year;
                  $subtotalModel->org_id=$model->org_id;
                  $subtotalModel->item_unitratecode=$model->unit_rate_code;
                  $subtotalModel->units=null;
                  $subtotalModel->type=null;
                  $subtotalModel->unit_price=null;
                  $subtotalModel->productivity_quantity=null;
                  $subtotalModel->preprimarycode=$preliminary->rate_code;
                }
              $subtotalModel->summation=0;
              $subtotalModel->total_amount=$amount;
              $subtotalModel->remarks="Sum  of(SubTotal + Miscellaneous Cost)";
              $subtotalModel->item_code=null;
              $subtotalModel->save();

}

public static  function autoPopulateLevelOne($model,$subitem,$preliminary,$primaryModel)
    {


       $levelOnemodels=ProductivityRate::where(['process_level'=>1,'subitem_id'=>$subitem->id,'preprimarycode'=>$primaryModel->preprimarycode])->get();


         
       


          if(sizeof($levelOnemodels))
          {
               foreach($levelOnemodels as $levelone)
               {


                  $rateCode=$levelone->rate_code;
                 $unitrateitems=ProductivityRate::where(['item_subcategory'=>$levelone->rate_code,'subitem_id'=>$levelone->subitem_id,'display_type'=>'Secondary'])->get();


                       //AutoFill Level One subItems and set sum=0;
                     $sum=0;
                    foreach($unitrateitems  as $item)
                    {
                          $pricelistItem=PriceListItem::where(['item_code'=>$item->rate_code])->first();
                             

                           $price=self::getPriceByRegion($model->region_id,$model->year,$item->rate_item_id);
                                
                        $itemmodel=UnitRateItem::where([
                            'item_unitratecode'=>$model->unit_rate_code,
                            'item_code'=>$item->rate_code,
                            'rate_id'=>$model->id,

                            'item_subcategory'=>$item->item_subcategory,

                            'classification'=>"Secondary",
                            'item_id'=>$pricelistItem->id])->first();
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
                      }//end of levelone subitems
                        


                        $itemmodel=UnitRateItem::where(['item_unitratecode'=>$model->unit_rate_code,
                            'item_name'=>$levelone->rate_name,
                            'process_level'=>1,'classification'=>"Primary" ,
                            'rate_id'=>$model->id,'preprimarycode'=>$primaryModel->preprimarycode])->first();
                         $quantity=$levelone->quantity;

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
                        $itemmodel->unit_price=$sum/$levelone->sample_quantity;
                        $itemmodel->productivity_quantity=$quantity;
                         $itemmodel->sample_space=$levelone->sample_quantity;
                         $itemmodel->total_amount=round($itemmodel->unit_price*$itemmodel->productivity_quantity,0);
                         $itemmodel->remarks=$levelone->remarks;
                        $itemmodel->item_code=$levelone->rate_code;
                        $itemmodel->item_subcategory=null;
                        $itemmodel->preprimarycode=$primaryModel->preprimarycode;
                       
                        $itemmodel->unit_rate=$itemmodel->total_amount/$itemmodel->sample_space;
                        $itemmodel->save();
                          
                        
                        

               }
          }


    }

public static  function createRateItem($model,$subitem,$levelone,$preliminary)
{
        
        

          

           // autoPopulateLevelOne



    
                   
                     
                      $itemmodel=UnitRateItem::where(['item_unitratecode'=>$model->unit_rate_code,'item_name'=>$levelone->rate_name,'classification'=>"Primary",'item_id'=>$levelone->subitem_id,'preprimarycode'=>$levelone->preprimarycode])->first();


                       if(!$itemmodel)
                         {
                        $itemmodel=new UnitRateItem();
                        $itemmodel->rate_id=$model->id;
                        $itemmodel->item_id=$model->subitem_id;
                        $itemmodel->units=$levelone->rate_unit;
                        $itemmodel->type=$levelone->rate_type;
                        $itemmodel->classification="Primary";
                        $itemmodel->price_year=$model->year;
                        $itemmodel->org_id=$model->org_id;
                        $itemmodel->item_unitratecode=$model->unit_rate_code;
                        }
                        $itemmodel->productivity_quantity=$levelone->quantity;
                          
                          $priceadjustmentynodes=array("20.50.017","20.50.001");
                           
                         if($levelone->rate_name=="price adjustment" && $levelone->item_code=="08.50.024a")
                                {
                                     $price=Self::getManualAbove16mmPrice($model,$levelone);
                                     
                                    
                                      $itemmodel->unit_price=$price;
                                     $total=round($itemmodel->unit_price*$itemmodel->productivity_quantity/100,0);
                                      $itemmodel->summation=1;


                                }
                                else if($levelone->rate_name=="price adjustment" && in_array($levelone->item_code, $priceadjustmentynodes))
                                {
                                    
                                     $price=Self::getManualAbove16mmPrice($model,$levelone);
                                     $itemmodel->unit_price=$price;
                                     $total=round($itemmodel->unit_price*$itemmodel->productivity_quantity/100,0);
                                      $itemmodel->summation=1;



                                }


                                else{
                                    $price=self::getPriceByRegion($model->region_id,$model->year,$levelone->rate_item_id);
                                     $itemmodel->unit_price=$price;
                                    $total=round($itemmodel->unit_price*$itemmodel->productivity_quantity,0);
                                     $itemmodel->summation=1;
                                }




                       
                        $itemmodel->summation=$levelone->is_summable;
                        $itemmodel->total_amount=$total;
                        $itemmodel->remarks=$levelone->remarks;
                        $itemmodel->item_name=$levelone->rate_name;
                        $itemmodel->item_code=$levelone->rate_code;
                        $itemmodel->process_level=$levelone->process_level;
                        $itemmodel->item_subcategory=null;
                        $itemmodel->preprimarycode=$levelone->preprimarycode;
                       
                        $itemmodel->save();

                         

                        



}

public static function getManualAbove16mmPrice($rate,$levelone)
{
    

     $model=UnitRateItem::where(['rate_id'=>$rate->id,'item_code'=>"22.71.012"])->latest('id')->first();
       
        if($model)
        {
            return $model->total_amount;
        }else{
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



              

             //Perform checks for ,
               


    
        
 
   






  
 
}