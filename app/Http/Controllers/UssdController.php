<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UssdOption;
use Modules\Usermanagement\Entities\Member;
use App\Helpers\Helper;
use Modules\Usermanagement\Entities\Organization;
use Modules\Usermanagement\Entities\Product;
use Modules\Usermanagement\Entities\ProductName;
use Modules\Usermanagement\Entities\ProductMetaData;
class UssdController extends Controller
{
    //
     public static function session(Request $request)
    {
              $sessionId   = $request->get('sessionId');
       $serviceCode = $request->get('serviceCode');
       $phoneNumber = $request->get('phoneNumber');
       $text        = $request->get('text');
        // use explode to split the string text response from Africa's talking gateway into an array.
        $ussd_string_exploded = explode("*", $text);
        // Get ussd menu level number from the gateway
        $level = count($ussd_string_exploded);

        if ($text == "") {
            // first response when a user dials our ussd code
            $response  = "CON Welcome to ASDSP USSD Service \n";
            $response .= "1.Register Member \n";

            $response .= "2.Add or Edit Products";
        }
        elseif ($text == "1") {
            // when user respond with option one to register
             $response = "CON Please Enter Your VCO NO:";
        }
        
      elseif ($ussd_string_exploded[0] == 1 && $level == 2) {
             $response = "CON Please Value Chain Actor National ID  Number:";


        }

        elseif ($ussd_string_exploded[0] == 1  && $level == 3) {
             $response = "CON Please Enter  Value Chain Actor Name:";


        }





        elseif ($ussd_string_exploded[0] == 1 && $level == 4) {
            
             $response = "CON Please Enter Value Chain Actor Telephone:";


        }
        elseif ($ussd_string_exploded[0] == 1 && $level == 5) {
            $response = "CON Please indicate Value Chain Actor Age:\n";
            $response .= "1.Below 36 Years \n";
            $response .= "2.36 to 60 Years \n";
            
           
            $response .= "3.60 and Above";
        }

         elseif ($ussd_string_exploded[0] == 1 && $level == 6) {
            $response = "CON Please Enter Value Chain Actor Location:";
        }

        elseif ($ussd_string_exploded[0] == 1 && $level == 7) {
            $response = "CON Please indicate Value Chain Actor Gender:\n";
            $response .= "1.Male \n";
            $response .= "2.Female \n";
            
           
           
        }
        elseif ($ussd_string_exploded[0] == 1  && $level == 8) {
            // save data in the database
                 $data=explode("*", $text);

                 unset($data[0]);
                    try{
                       $organisation=Organization::where(['org_number'=>$data[1]])->first();
                     if($organisation)
                     {
                       $number=self::generateMemberNumber($organisation->id);
                        
                          
                         
                            
                          
                   $model=new Member();
                   $model->member_name=strtoupper($data[3]);
                   
                   $model->id_number=$data[2];
                   $model->member_telephone=Helper::processNumber($data[4]);
                   $model->value_chain_id=$organisation->value_chain_id;
                   $model->node_id=$organisation->node_id;
                   
                   $model->member_number =$number;
                   
                   $model->org_id=$organisation->id;

                  
                   $model->location=$data[6];
                   $model->channel="USSD";
                    if($data[5]==1)
                    {
                      $bracket="Below 36";
                    }
                    else if($data[5]==2)
                    {
                      $bracket="36 Yrs to 60 Yrs";
                    }else{
                      $bracket="60 and Above";
                    }
                    
                   $model->age_bracket=$bracket;
                         if($data[7]==1)
                         {
                          $gender="Male";
                          $IsMale=1;
                          $IsFemale=0;

                         }else{
                          $gender="Fmale";
                          $IsMale=0;
                          $IsFemale=1;

                         }
                    $model->gender=$gender;
                    $model->isMale=$IsMale;
                    $model->IsFemale=$IsFemale;
                   $model->save();
                   
                     $text="Dear ".$model->member_name."you have successfully been registered on ASPSD Portal.Your VCO Number is ".$model->member_number;

              $test=Helper::sendSMS($model->member_telephone,$text);
                     }

                $response = "END Farmer Details submitted successfully.You will receive sms confirmation shortly.";


                    }catch(\Exception $e)
                    {
                       
                     $test= Helper::sendEmailToSupport($e,"USSD");

                       $response = "END Error Occured.System admin Notified";
                       
                    }


                
             

          
        }
         elseif ($text == "1*2") {
            // when use response with option django
            $response = "END SSD is similar to Short Messaging Service (SMS), but, unlike SMS, USSD transactions occur during the session only. With SMS, messages can be sent to a mobile phone and can be stored for several days in the mobile message history. While USSD is is just session active only which is mostly within a timeframe\n";
           
        }
       
        elseif ($text == "2") {
            // Our response a user respond with input 2 from our first level
           $response = "CON Please Enter Your Actor  VCO NO:";
        }


         elseif ($ussd_string_exploded[0] == 2  && $level == 2) {

              $data=explode("*", $text);

                 unset($data[0]);
                 $number=strval($data[1]);
                  $member=Member::where(['member_number'=>$number])->first();
                     if($member)
                     {
                        $products=ProductName::where(['value_chain_id'=>$member->value_chain_id])->get();

                         $response = "CON Please Select Product Name: \n";
                            foreach($products as $branch)
                            {
                             $response .= $branch->id.".". $branch->product_name." \n";
                            }


                     }else{
                         $response = "END Provided Member Number Does Not Exist in Our Database";


                     }


            

        }
           elseif ($ussd_string_exploded[0] == 2  && $level == 3) {
              $data=explode("*", $text);
               unset($data[0]);
                 $productnameId=$data[2];
                   try{
                     $metdadata=ProductMetaData::where(['product_name_id'=>$productnameId,'key'=>'UOM'])->get();

                  $response = "CON Please Enter Unit of Measure: \n";

                            foreach($metdadata as $branch)
                            {
                             $response .= $branch->value." \n";
                            }

                   }catch(\Exception $e)
                   {
                      $response = "END  Error Occured while processing your request.please try again: \n";
                   }
                

                 


        }

         elseif ($ussd_string_exploded[0] == 2  && $level == 4) {
            $data=explode("*", $text);
               unset($data[0]);
            $productnameId=$data[2];
             try{
                 $metdadata=ProductMetaData::where(['product_name_id'=>$productnameId,'key'=>'Color'])->get();
                    $response = "CON Please Enter Product Color: \n";

                            foreach($metdadata as $branch)
                            {
                             $response .= $branch->value." \n";
                            }

                            $response .= "Others \n";

             }catch(\Exception $e)
             {

             $response = "END  Error Occured while processing your request.please try again: \n";
             }
                

             
             

        }
         elseif ($ussd_string_exploded[0] == 2  && $level == 5) {
             
            
            $response = "CON Please Enter  Quantity Available:";



        }

        elseif ($ussd_string_exploded[0] == 2  && $level == 6) {
             $response = "CON Please Enter Unit Selling Price In KES:";


        }
         elseif ($ussd_string_exploded[0] == 2  && $level == 7) {

              $data=explode("*", $text);

                
                  try{
                     unset($data[0]);

                    $member=Member::where(['member_number'=>$data[1]])->first();
                 
                   if($member)
                   {
                       
                       $product=Product::where(['member_id'=>$member->id,'value_chain_id'=>$member->value_chain_id])->first();
                          if(!$product)
                          {
                             $product=new Product();
                             $product->org_id=$member->org_id;
                             $product->member_id=$member->id;
                             $product->uom_id=1;
                             $product->value_chain_id=$member->value_chain_id;
                          }
                            
                            $productname=ProductName::where(['id'=>$data[2]])->first();
                            $product->product_id=$product->id;
                           

                          $product->variety=($productname->product_name)?$productname->product_name:$data[2];
                          $product->uom=$data[3];
                          $product->product_color=$data[4];
                        
                           $product->quantity_available=$data[5];
                          $product->unit_price=$data[6];
                          $product->save();
                          

                          
                           $response = "END Product Details Submitted Successfully";
                   }


                   else{
                    
                     $response = "END  Member Details Not Found";

                   }


                  }catch(\Exception $e)
                  {
                      dd($e);
                      $response = "END  Error Occured while processing your request.please try again: \n";
                  }

                 
             
            


        }


        
        // send your response back to the API
        header('Content-type: text/plain');
        echo $response;
    }

    
     public static  function generateMemberNumber($OrgID=false)
    {
        
        
         

         $model=Member::where(['org_id'=>$OrgID])->latest('id')->first();

            if($model)
            {
                $number=explode("/",$model->member_number);
                 $vco=$number[0];
                 $org_number=$number[1];
                 $numberpart=$number[2];
                   $number=$numberpart+1;
                if(strlen($number)==1)
                {
                     $number="000".$number;
                }else if(strlen($number)==2)
                {
                    $number="00".$number; 
                }
                else if(strlen($number)==3)
                {
                    $number="0".$number; 
                }

                $number=$vco."/".$org_number."/".$number;
            }else{
                $organization=Organization::find($OrgID);
                  if($organization)
                  {
                    $number=$organization->org_number."/0001";
                  }else{
                     $number="Unknow0001";
                  }
                
            }

            return $number;

    }
}
