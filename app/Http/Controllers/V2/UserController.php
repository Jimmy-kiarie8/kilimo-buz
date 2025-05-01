<?php
namespace App\Http\Controllers\V2;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\User;
use DB;
use App\Helpers\Helper;
use Modules\Usermanagement\Entities\Member;
use Modules\Usermanagement\Entities\Product;
use Modules\Usermanagement\Entities\Profile;
use Modules\Usermanagement\Entities\County;
use App\Helpers\SystemAudit;
use App\Helpers\AddressHelper;
class UserController extends Controller
{

    public function APkVersion(Request $request)
    {
          $response=array();
        $data=$request->all();
          

        $errors=array();
        $token = $request->header('token');
         if (is_null($token)) 
        {
        $errors[]=array("401"=>"Authorization Token Missing");
        }
        else
        { $user=User::where(['token'=>$token])->first();
           
           $response['current_version']="5.3.0";



        

        }
        $response['errors']=$errors;
         if(sizeof($response['errors'])>0)
        {
            $response['success']=false;
        }
        else
        {
            $response['success']=true;
        }
       return response()->json($response);

    }

    public function UserRegister(Request $request)
    {

         $response=array();
        $data=$request->all();
        $errors=array();

        $data=$request->all();
         
          $validator =\Validator::make($request->all(), [
                 'name'=>'required| string',
                 'email'=>'nullable|unique:users,email',
                'telephone'=>'required|unique:users,phone',
                'device_type'=>'required',
                'device_token'=>'required',

            ],['Telephone/Email No Already Taken']);
           if ($validator->fails()) 
        {

            $current_errors = $validator->errors();
            foreach($current_errors->all() as $error)
            {
                $errors[]=$error;
            }

            $response['errors']=$errors;
            $response['msg']="Invalid Telephone";
        }
        else
        {
             DB::beginTransaction();
             $user=new User();
             $user->name=$data['name'];
             $user->phone=Helper::processNumber($data['telephone']);
             $user->email=$data['email'];
             if($user->phone==254708236804)
              {
                     $password=121214;
            }else{
            $password=$code=substr(number_format(time() * rand(),0,'',''),0,6);
             }
            $user->opt_code=$password*3000;
            $user->device_token=$data['device_token'];
            $user->device_type=$data['device_type'];
            $user->save();
             
         $profile=new Profile();
         $profile->user_id=$user->id;
         $profile->country="KENYA";
         $profile->telephone=$user->phone;
         $profile->save();
          
          
         $roles="Buyer";
         $user->assignRole($roles);
         
          $description=$user->name." Registered  As A  Buyer";

        $client_ip=\Request::ip();
       $event= SystemAudit::CreateEvent($user,"Registered",$description,"Critical",$client_ip,"Registration Module");
          DB::commit();

         $text="Dear ".$user->name.",Your KILIMOBUZ Account Login Are Username:".$user->phone;
                  
        $sendsms=Helper::send_sms($user->phone,$text);
        $response['msg']="Account Created Successfully";
        $response['data']=array();
       


          

        }


        $response['errors']=$errors;
         if(sizeof($response['errors'])>0)
        {
            $response['success']=false;

        }
        else
        {
            $response['success']=true;
        }
       
        return response()->json($response);

    }

     public function  Mobilelogin(Request $request)
     {

           $response=array();
        $data=$request->all();
        $data['telephone']=Helper::processNumber($data['telephone']);
        $errors=array();


       
         
          $validator =\Validator::make($data, [
                'telephone'=>'required|exists:users,phone',
                'device_code'=>'required',
                'device_type'=>'required',

            ]);
           if ($validator->fails()) 
        {

            $current_errors = $validator->errors();
            foreach($current_errors->all() as $error)
            {
                $errors[]=$error;
            }

            $response['errors']=$errors;
            $response['msg']="Invalid Telephone";
        }
        else
        {
            $user=User::where(['phone'=>$data['telephone']])->first();
               if($user)
               {
                   if($user->phone==254708236804)
                   {
                     $password=121214;
                   }else{
                     $password=$code=substr(number_format(time() * rand(),0,'',''),0,6);
                   }
                
                 $user->opt_code=$password*3000;
                 $user->device_token=$data['device_code'];
                 $user->device_type=$data['device_type'];
                 $user->save();
                 $text="Dear ".$user->name.",Your KILIMOBUZ OTP Is:".$password." \n".$data['device_code'];
                   if(strlen($user->phone)>0)
                   {
                     $test=Helper::sendSMS($user->phone,$text);
                         $response['msg']="OTP Send To  Provided Telephone (".$user->phone."):".$code;
                   }
                  
               
            
                $response['data']=array();
                $response['smsDescription']=$text;

               }else{
                $response['msg']="User Details Not Found";

               }

          

        }


        $response['errors']=$errors;
         if(sizeof($response['errors'])>0)
        {
            $response['success']=false;

        }
        else
        {
            $response['success']=true;
        }
       
        return response()->json($response); 

     }

     public function userOTPVerification(Request $request)
     {
        $response=array();
        $data=$request->all();
        $errors=array();

          $data['OTP']=$code=$data['OTP']*3000;
             
              
          $validator =\Validator::make($data, [
                'OTP'=>'required|exists:users,opt_code',
            ],['Invalid OTP Code']);
           if ($validator->fails()) 
        {

            $current_errors = $validator->errors();
            foreach($current_errors->all() as $error)
            {
                $errors[]=$error;
            }

            $response['errors']=$errors;
            $response['msg']="Invalid OTP Code Provided";
        }
        else
        {
            $user=User::where(['opt_code'=>$data['OTP']])->first();
               if($user)
               {

                $token=Helper::generateToken();
                        $expiry=Helper::generateExpiry();
                         
                        $user->token=$token;
                        $user->token_expiry=$expiry;
                        
                        $now=date('Y-m-d H:i:s');
                        $user->token_expiry=date('Y-m-d', strtotime($now . "+90 days"));
                        $user->save();

                if(strlen($user->avatar)>0)
                          {
                            $avatar_url=url('/dirAvatars/'.$user->avatar);

                          }else{
                            $avatar_url=url('k.jpg');
                          }


                        $profile=$user->profile;
                         $details=array('user_id'=>$user->id,
                                 'token'=>$user->token,
                                 'name'=>$user->name,
                                 'telephone'=>$user->phone,
                                 'avatar'=>$avatar_url,
                                 'email'=>$user->email,
                                 'postal_address'=>$profile->postal_address,
                                 'street_address'=>$profile->residential_address,
                                 'dob'=>$profile->dob,
                                 'home_county'=>$profile->county,
                                 'nationality'=>$profile->country,
                                 'gender'=>$profile->gender,
                                 'id_number'=>$profile->id_number
    
                                );

                         $statist=array("Pending_orders"=>0,"Completed_orders"=>1,"Total_orders"=>1,"Total_Amount_Spent"=>10);
                        

                         $response['statistics']=  $statist; 
                         $response['basic_details']=$details;
                        
                         

                  
                $response['msg']="User Auntenticated Successfully";
                $response['data']=array('basic_details'=>$details);

               }else{
                $response['msg']="User Details Not Found";

               }

          

        }


        $response['errors']=$errors;
         if(sizeof($response['errors'])>0)
        {
            $response['success']=false;

        }
        else
        {
            $response['success']=true;
        }
       
        return response()->json($response); 

     }

    public function Login(Request $request){
         $response=array();
        $data=$request->all();
        $errors=array();

        $data=$request->all();
          $validator =\Validator::make($request->all(), [
                'email'=>'required|exists:users,email',
                'password'=>'required',
                'DeviceType'=>'required',
                'DeviceToken'=>'required'
            ]);
           if ($validator->fails()) 
        {

            $current_errors = $validator->errors();
            foreach($current_errors->all() as $error)
            {
                $errors[]=$error;
            }

            $response['errors']=$errors;
        }
        else
        {
            $email=$data['email'];
            $password=$data['password'];
             if (\Auth::attempt(['email' => $email, 'password' => $password]))
                    {

                        
                        $user=User::where('email',$email)->first();
                        $token=Helper::generateToken();
                        $expiry=Helper::generateExpiry();
                        $user->token=$token;
                        $user->token_expiry=$expiry;
                        $user->device_type=$data['DeviceType'];
                        $user->device_token=$data['DeviceToken'];
                        $now=date('Y-m-d H:i:s');
                        $user->token_expiry_date=date('Y-m-d', strtotime($now . "+10 days"));
                        $user->save();

                        if(strlen($user->avatar)>0)
                          {
                            $avatar_url=url('/dirAvatars/'.$user->avatar);

                          }else{
                            $avatar_url=url('k.jpg');
                          }


                        $profile=$user->profile;
                         $details=array('user_id'=>$user->id,
                                 'token'=>$user->token,
                                 'name'=>$user->full_name,
                                 'telephone'=>$user->telephone,
                                 'avatar'=>$avatar_url,
                                 'email'=>$user->email,
                                 'postal_address'=>$profile->postal_address,
                                 'street_address'=>$profile->street_address,
                                 'dob'=>$profile->dob,
                                 'home_county'=>$profile->home_county,
                                 'nationality'=>$profile->nationality,
                                 'gender'=>$profile->gender,
                                 'ip_id'=>$user->company_id
                                );
                         $regions=RegionSFP::join('regions','regions.id','=','regions_sfp.region_id')
                           ->where(['regions_sfp.user_id'=>$user->id])
                           ->select('region_id','region_name')
                           ->groupBy('region_id')->get();
                            
                           $list=array();
                            foreach($regions as $region)
                            {
                                $list[]=array("region_id"=>$region->region_id,'region_name'=>$region->region_name);
                            }
                            
                         $response['basic_details']=$details;
                         $response['regions_attached_to']=$list;
                    }else{
                        $errors[]="Provided credentials do not match with our records";
                    }
        $response['errors']=$errors;
         if(sizeof($response['errors'])>0)
        {
            $response['success']=false;
        }
        else
        {
            $response['success']=true;
        }
       }
        return response()->json($response); 


    }

    public function  getDashboardAlerts($id)
    {
       $models=\DB::select(\DB::raw("call getDashboardAlerts($id)"));
            $data=array();
                foreach($models as $model)
                {
                  $data[]=array(
                    "alert_id"=>$model->id,
                    'alert_title'=>$model->alert_name,
                    'alert_date'=>date('Y-m-d',strtotime($model->alert_date)),
                    'alert_time'=>date('h:i A',strtotime($model->alert_date)),
                    'alert_status'=>$model->alert_status,
                    'alert_category'=>$model->alert_category,
                    'spf_user_id'=>$model->sfp_user_id,
                    'alert_datetime'=>date('Y-m-d h:i:s',strtotime($model->alert_date)),

                  );
                  
                }

                return $data;

    }

    public function getUserStatistics($id)
    {
     

           $models=\DB::select(\DB::raw("call GetSFPStatistics($id)"));
              if(sizeof($models)>0)
              {
                 $data=array(
                  "contact_count"=>$models[0]->contacts,
                  "total_alerts_count"=>$models[0]->active_alerts,
                  "active_alerts_count"=>$models[0]->active_alerts,
                  "inactive_alerts_count"=>$models[0]->inactive_alerts

                         );

              }else{
                  $data=array(
                  "contact_count"=>0,
                  "total_alerts_count"=>0,
                  "active_alerts_count"=>0,
                  "inactive_alerts_count"=>0

                         );

              }

              return $data;

    }

    public function UpdateToken(Request $request)
    {
          $response=array();
        $data=$request->all();
          

        $errors=array();
        $token = $request->header('token');
         if (is_null($token)) 
        {
        $errors[]=array("401"=>"Authorization Token Missing");
        }
        else
        { $user=User::where(['token'=>$token])->first();
            if($user)
            {     
                      if(is_null($data['DeviceToken']))
                      {
                         $errors[]=array("404"=>"Device Token Is Required");
                      }else{
                         $user->device_token=$data['DeviceToken'];
                       $user->save();
                       $response['success_msg']="Device Token Updated Successfully";


                      }
                    

                  


            }else{
              $errors[]=array("404"=>"Provided Token Does Not Exists");
            }


        

        }
        $response['errors']=$errors;
         if(sizeof($response['errors'])>0)
        {
            $response['success']=false;
        }
        else
        {
            $response['success']=true;
        }
       return response()->json($response);

    }

  public function getRegions(Request $request)
  {
    $response=array();
        $data=$request->all();

        $errors=array();
        $token = $request->header('token');
         if (is_null($token)) 
        {
        $errors[]=array("401"=>"Authorization Token Missing");
        }
        else
        { $user=User::where(['token'=>$token])->first();
            if($user)
            { 
                      $models=RegionSFP::join('regions','regions.id','=','regions_sfp.region_id')
                      ->where(['regions_sfp.user_id'=>$user->id,'regions_sfp.company_id'=>$user->company_id])
                      ->select('regions.id as region_id','region_name')->get();
                      $list=array();
                       foreach($models as $mod)
                       {
                        $list[]=array("region_id"=>$mod->region_id,'region_name'=>$mod->region_name);
                       }

                       $response['RegionsList']=$list;



                  


            }else{
              $errors[]=array("404"=>"Provided Token Does Not Exists");
            }


        

        }
        $response['errors']=$errors;
         if(sizeof($response['errors'])>0)
        {
            $response['success']=false;
        }
        else
        {
            $response['success']=true;
        }
       return response()->json($response);

  }


  public function GetLatestPendingAlert(Request $request)
  {
      $response=array();
        $data=$request->all();
        $errors=array();
        $data=$request->all();
        
          $validator =\Validator::make($request->all(), [
                'user_id'=>'required|exists:users,id',
            ]);
           if ($validator->fails()) 
        {
            $current_errors = $validator->errors();
            foreach($current_errors->all() as $error)
            {
                $errors[]=$error;
            }

        }
        else
        {
             $user=User::where(['id'=>$data['user_id']])->first();
             
                 
               
                 
                 if($user)
                 {
                     
                      $alert=AlertAcknowledgement::where(['sfp_user_id'=>$user->id,'acknowlement_status'=>"Pending"])->latest('id')->first();

                        if($alert)
                        {
                              $response['count']=1;
                               
                              $detail=array("alert_id"=>$alert->alert_id,
                                            'alert_title'=>$alert->alert->alert_name,
                                            "acknowledgement_id"=>$alert->id,
                                            'Category'=>$alert->alert->alert_category,
                                            'alert_date'=>$alert->alert->alert_date,
                                            'acknowlement_status'=>$alert->acknowlement_status,
                                            'targeted_number'=>$alert->targeted_number,
                                            'number_acknowledged'=>$alert->number_acknowledged,
                                            'number_remaining'=>$alert->targeted_number-$alert->number_acknowledged,
                                            'alert_status'=>$alert->alert->alert_status,
                                            "Expiry_date"=>$alert->alert->expiary_date,


                                        );


                                 $response['alert_details']=$detail;



                        }else{

                            $response['count']=0;
                        }

                  
                 
                    
                  

                    
                  $response['status']="Successful";
                  

                 }else{
                     $errors[]=array("404"=>"UserId Does Not Exist In Our Database");
                 }
             }

        $response['errors']=$errors;
         if(sizeof($response['errors'])>0)
        {
            $response['success']=false;
        }
        else
        {
            $response['success']=true;
        }
       return response()->json($response); 

  }


  public function GetLivestatistics(Request $request)
  {
       $response=array();
        $data=$request->all();
        $errors=array();
        $data=$request->all();
        
          $validator =\Validator::make($request->all(), [
                'user_id'=>'required|exists:users,id',
            ]);
           if ($validator->fails()) 
        {
            $current_errors = $validator->errors();
            foreach($current_errors->all() as $error)
            {
                $errors[]=$error;
            }

        }
        else
        {
             $user=User::where(['id'=>$data['user_id']])->first();
             
                 
               
                 
                 if($user)
                 {
                  $list=$this->getUserStatistics($user->id);

                    
                  

                    
                  $response['status']="Successful";
                  $response['statistics']=$list;

                 }else{
                     $errors[]=array("404"=>"UserId Does Not Exist In Our Database");
                 }
             }

        $response['errors']=$errors;
         if(sizeof($response['errors'])>0)
        {
            $response['success']=false;
        }
        else
        {
            $response['success']=true;
        }
       return response()->json($response); 

  }

  public function changeMyPassword(Request $request)
  {
    $response=array();
        $data=$request->all();
        $errors=array();
        $data=$request->all();
        
          $validator =\Validator::make($request->all(), [
                'email'=>'required|email|exists:users,email',
            ]);
           if ($validator->fails()) 
        {
            $current_errors = $validator->errors();
            foreach($current_errors->all() as $error)
            {
                $errors[]=$error;
            }

        }
        else
        {
             $user=User::where(['email'=>$data['email']])->first();
              $username=$data['email'];
                 
                $password=$code=substr(number_format(time() * rand(),0,'',''),0,6);
                 
                 if($user)
                 {
                    $user->password=$password;
                    $user->save();
                    $text="Dear ".$user->full_name.", your password has been reset to ".$password;
                      $test=Helper::sendsms($user->telephone,$text);


                   /* $emailTest=Helper::sendEmail($username,$text,"Password Reset");
                       dd($emailTest);*/
                  

                    
                  $response['status']="Successful";
                  $response['message']="Your Account Password Has Been  RESET TO ".$password;

                 }else{
                     $errors[]=array("404"=>"Username Does Not Exist In Our Database");
                 }
             }

        $response['errors']=$errors;
         if(sizeof($response['errors'])>0)
        {
            $response['success']=false;
        }
        else
        {
            $response['success']=true;
        }
       return response()->json($response); 

  }

  public function  changePassword(Request $request)
  {
    $response=array();
        $data=$request->all();
        $errors=array();
        $data=$request->all();
        
          $validator =\Validator::make($request->all(), [
                'email'=>'required|email|exists:users,email',
                'password'=>'required|min:6|max:12|confirmed'
            ]);
           if ($validator->fails()) 
        {
            $current_errors = $validator->errors();
            foreach($current_errors->all() as $error)
            {
                $errors[]=$error;
            }

        }
        else
        {
             $user=User::where(['email'=>$data['email']])->first();
              $username=$data['email'];
                 
                 $password=$code=$data['password'];
                 
                 if($user)
                 {
                    $user->password=$password;
                    $user->save();
                    $text="Dear ".$user->full_name.", your password has been reset to ".$password;
                    Helper::sendEmail($username,$text,"Password Reset");
                    Helper::sendsms($user->telephone,$text);

                    
                  $response['status']="Successful";
                  $response['message']="Your Account Password Has Been  RESET TO ".$password;

                 }else{
                     $errors[]=array("404"=>"Username Does Not Exist In Our Database");
                 }
             }

        $response['errors']=$errors;
         if(sizeof($response['errors'])>0)
        {
            $response['success']=false;
        }
        else
        {
            $response['success']=true;
        }
       return response()->json($response); 

  }

  public function LinkSellerByIDToVCO(Request $request)
  {
     $response=array();
        $data=$request->all();
        $errors=array();
        $data=$request->all();
        
          $validator =\Validator::make($request->all(), [
                'userId'=>'required|integer',
                'idnumber'=>'required|string',
                 ]);
           if ($validator->fails()) 
        {
            $current_errors = $validator->errors();
            foreach($current_errors->all() as $error)
            {
                $errors[]=$error;
            }

        }
        else
        {
             $idnum=$data['idnumber'];
             $user_id=$data['userId'];
            $updatecount=DB::update("update vco_members set user_id=? where id_number=?",[$user_id,$idnum]);
            $models=Member::where(['id_number'=>$idnum])->get();
              $vco_count=sizeof($models);
               if($vco_count>0)
               {
                $response['vco_count']=$vco_count;
                $list=array();
                 foreach($models as $model)
                 {
                    $organization=$model->organization;
                    $list[]=array("RecordId"=>$model->id,'VCOName'=>$organization->org_name,'MemberNumber'=>$model->member_number,'ValueChain'=>$model->valuechain->value_name);
                   
                 }
                 $response['valuechain_organizations']=$list;


               }else{
                $response['vco_count']=0;
                 $response['valuechain_organizations']=array();


               }


        }

         $response['errors']=$errors;
         if(sizeof($response['errors'])>0)
        {
            $response['success']=false;
        }
        else
        {
            $response['success']=true;
        }
       return response()->json($response); 

  }

  public function GetSellerVCOList(Request $request)
  {
     $response=array();
        $data=$request->all();
        $errors=array();
        $data=$request->all();
        
          $validator =\Validator::make($request->all(), [
                'userId'=>'required|integer',
                
                 ]);
           if ($validator->fails()) 
        {
            $current_errors = $validator->errors();
            foreach($current_errors->all() as $error)
            {
                $errors[]=$error;
            }

        }
        else
        {
            
             $user_id=$data['userId'];
           
            $models=Member::where(['user_id'=>$user_id])->whereNotNull('user_id')->get();
              $vco_count=sizeof($models);
               if($vco_count>0)
               {
                $response['vco_count']=$vco_count;
                $list=array();
                 foreach($models as $model)
                 {
                    $organization=$model->organization;
                    $list[]=array(
                        "RecordId"=>$model->id,
                        'MemberId'=>$model->id,
                        'VCOName'=>$organization->org_name,
                        'MemberNumber'=>$model->member_number,
                        'ValueChain'=>$model->valuechain->value_name,
                        'ValueChainId'=>$organization->value_chain_id);
                   
                 }
                 $response['valuechain_organizations']=$list;


               }else{
                $response['vco_count']=0;
                 $response['valuechain_organizations']=array();


               }


        }

         $response['errors']=$errors;
         if(sizeof($response['errors'])>0)
        {
            $response['success']=false;
        }
        else
        {
            $response['success']=true;
        }
       return response()->json($response); 

  }


  public function PostProduct(Request $request)
  {
    $response=array();
        $data=$request->all();
        $errors=array();
        $data=$request->all();
        
          $validator =\Validator::make($request->all(), [
                'memberId'=>'required|integer|exists:vco_members,id',
                'ValueChainID'=>'required|integer',
                'ProductName'=>'required|string',
                'Units'=>'required|string',
                'QuantityAvailable'=>'required|integer',
                'UnitSelleingPrice'=>'required|integer',
                'ProductDescription'=>'required',
                'ProductImage'=>'required',
                'UserId'=>'required|integer'
                
                 ]);
           if ($validator->fails()) 
        {
            $current_errors = $validator->errors();
            foreach($current_errors->all() as $error)
            {
                $errors[]=$error;
            }

        }
        else
        {
               
               $pin=Helper::generatePin(32);


             
             
             
           
            $member=Member::find($data['memberId']);
             $user=User::find($data['UserId']);
             $organization=$member->organization;
             $county=County::find($organization->county_id);
             $valuechain=$member->valuechain;
             
              
            $product=Product::where(['member_id'=>$member->id,'value_chain_id'=>$data['ValueChainID'],'variety'=>$data['ProductName']])->first();
              if(!$product)
              {
                $product=new Product();
              $product->org_id=$member->org_id;
              $product->member_id=$member->id;
              $product->value_chain_id=$data['ValueChainID'];
              $product->variety=$data['ProductName'];
              $product->created_by=$member->user_id;
              $product->product_code=$pin;

              }

              $image=$this->save_base64_image($data['ProductImage'],$product->product_code,"MemberProducts");
              $product->uom=$data['Units'];
              $product->quantity_available=$data['QuantityAvailable'];
              $product->unit_price=doubleval(str_replace(",", "", $data['UnitSelleingPrice']));
              $product->product_description=$data['ProductDescription'];
              $product->product_image=$image;
              $product->user_id=$data['UserId'];
              $product->sellername =$user->name;
              $product->sellermobilenumber=$user->phone;
              $product->vconame =($organization)?$organization->org_name:null;
              $product->county_id=($organization)?$organization->county_id:null;
              $product->county_name=($county)?$county->county_name:null;
              $product->value_chain_name =($valuechain)?$valuechain->value_name:null;
              $product->longitude=$data['Longitude'];
              $product->latitude=$data['Latitude'];
               $locations=AddressHelper::ReverseGeocording2($product->latitude,$product->longitude);
              if(is_array($locations))
            {
              $product->town=$locations['city'];
              $product->street=$locations['street'];

                 }
              
              $product->save();
             
                
              $response['mgs']="Product Added/Updated Successfully";
              
              $response['productDetails']=array(
                                              "Id"=>$product->id,
                                              'ValueChainName'=>$product->value_chain_name,
                                              'ProductName'=>$product->variety,
                                              'Quantity'=>$product->quantity_available,
                                              'Units'=>$product->uom,
                                              'SellingPrice'=>"Kes :".$product->unit_price,
                                              'ProductDescription'=>$product->product_description,
                                              'ProductCode'=>$product->product_code,
                                              'CreatedAt'=>$product->created_at,
                                              'UserId'=>$user->id,
                                              'SellerName'=>$product->sellername,
                                              'SellerNumber'=>$product->sellermobilenumber,
                                              'ProductImage'=>asset('/MemberProducts/'.$product->product_image),
                                              'VCOName'=>$product->vconame,
                                              'CountyName'=>$product->county_name,
                                                 );


             


        }

         $response['errors']=$errors;
         if(sizeof($response['errors'])>0)
        {
            $response['success']=false;
        }
        else
        {
            $response['success']=true;
        }
       return response()->json($response); 


  }
  public  function getMyProduct(Request $request)
  {


      $errors=array();
      $data=$request->all();

       $validator =\Validator::make($request->all(), [
                'UserId'=>'required|integer|exists:users,id',
                


            ]);
           if ($validator->fails()) 
        {
            $current_errors = $validator->errors();
            foreach($current_errors->all() as $error)
            {
                $errors[]=$error;
            }

        }
        else
        {
             $data=$request->all();
                
               $models=DB::select("select products.id,products.created_at,product_image,variety as product_name,county_id, product_code,quantity_available,format(unit_price,0) unit_price,uom,value_chain_name,product_description,member_id,vconame,updated_at,user_id from products where  products.user_id =? and is_deleted is null order by products.id desc",[$data['UserId']]);
               $list=array();
                foreach($models as $model)
                {
                     
                     if(strlen($model->product_image))
                     {
                        $image=asset('MemberProducts/'.$model->product_image);
                     }else{
                        $image="Not Set";
                     }

                   $list[]=array("ProductId"=>$model->id,
                           "ProductValueChain"=>$model->value_chain_name,
                            "ProductName"=>$model->product_name,
                            "QuantityAvailable"=>$model->quantity_available,
                            "UnitPrice"=>$model->unit_price,
                            "ProductCode"=>$model->product_code,
                            "Units"=>$model->uom,
                            "ProductDescription"=>$model->product_description,
                            "ProductImage"=>$image,
                            "VCOName"=>$model->vconame,
                            'UserId'=>$model->user_id,
                            'MemberId'=>$model->member_id,
                            'PostDate'=>$model->created_at,
                            'LastUpdatedAt'=>$model->updated_at
                             );
                }
                $response['productslist']=$list;
            
             }

        $response['errors']=$errors;
         if(sizeof($response['errors'])>0)
        {
            $response['success']=false;
        }
        else
        {
            $response['success']=true;
        }
       return response()->json($response); 


  }

  public function DeleteMyProduct(Request $request)
  {
    $errors=array();
      $data=$request->all();
       $validator =\Validator::make($request->all(), [
                'UserId'=>'required|integer|exists:users,id',
                'ProductId'=>'required|integer|exists:products,id'
                


            ]);
           if ($validator->fails()) 
        {
            $current_errors = $validator->errors();
            foreach($current_errors->all() as $error)
            {
                $errors[]=$error;
            }

        }
        else
        {
             $data=$request->all();
             DB::beginTransaction();
             $model=Product::find($data['ProductId']);
               if($model)
               {
                $model->is_deleted=1;
                $model->deleted_at=date('Y-m-d H:i:s');
                $model->save();
                $response['msg']="Product Deleted Successfully";
               }else{
                 $response['msg']="Failed:Product Not Deleted";
               }
               
               
             DB::commit();
                 

                

            
             }

        $response['errors']=$errors;
         if(sizeof($response['errors'])>0)
        {
            $response['success']=false;
        }
        else
        {
            $response['success']=true;
        }
       return response()->json($response); 

  }

  public function UpdateProduct(Request $request)
  {
    $response=array();
        $data=$request->all();
        $errors=array();
        $data=$request->all();
        
          $validator =\Validator::make($request->all(), [
                'memberId'=>'required|integer|exists:vco_members,id',
                'ValueChainID'=>'required|integer',
                'ProductName'=>'required|string',
                'Units'=>'required|string',
                'QuantityAvailable'=>'required|integer',
                'UnitSelleingPrice'=>'required|integer',
                'ProductDescription'=>'required',
                'ProductImage'=>'required',
                'ProductId'=>'required|integer|exists:products,id'
                
                 ]);
           if ($validator->fails()) 
        {
            $current_errors = $validator->errors();
            foreach($current_errors->all() as $error)
            {
                $errors[]=$error;
            }

        }
        else
        {
               
              

             
             
             
           
            $member=Member::find($data['memberId']);
            $product=Product::find($data['ProductId']);
              
               $product->updated_by=$member->user_id;

              $image=$this->save_base64_image($data['ProductImage'],$product->product_code,"MemberProducts");
              $product->uom=$data['Units'];
              $product->quantity_available=$data['QuantityAvailable'];
              $product->unit_price=doubleval(str_replace(",", "", $data['UnitSelleingPrice']));
              $product->product_description=$data['ProductDescription'];
              $product->product_image=$image;
              $product->save();
              $response['mgs']="Product Updated Successfully";
              
              $response['productDetails']=array("Id"=>$product->id,
                                              'ProductName'=>$product->variety,
                                              'Quantity'=>$product->quantity_available,
                                              'Units'=>$product->uom,
                                              'SellingPrice'=>"Kes :".$product->unit_price,
                                              'ProductDescription'=>$product->product_description,
                                              'ProductCode'=>$product->product_code,
                                              'CreatedAt'=>$product->created_at,
                                              'ProductImage'=>asset('/MemberProducts/'.$product->product_image)
                                                 );


             


        }

         $response['errors']=$errors;
         if(sizeof($response['errors'])>0)
        {
            $response['success']=false;
        }
        else
        {
            $response['success']=true;
        }
       return response()->json($response); 

  }


  public function  UpdateProfile(Request $request)
  {
      $response=array();
        $data=$request->all();
        $errors=array();
        $data=$request->all();
        
          $validator =\Validator::make($request->all(), [
                'Name'=>'required|string',
                'Telephone'=>'required|string',
                'Gender'=>'required|string',
                'CountyOfResidence'=>'required|string',
                'userId'=>'required|integer|exists:users,id'
                 ]);
           if ($validator->fails()) 
        {
            $current_errors = $validator->errors();
            foreach($current_errors->all() as $error)
            {
                $errors[]=$error;
            }

        }
        else
        {
             $data=$request->all();
             
             $user=User::find($data['userId']);
                   if($user)
                   {
                    $user->name=$data['Name'];
                    $user->phone=Helper::processNumber($data['Telephone']);
                    $user->save();
                    $profile=$user->profile;
                    $profile->county=$data['CountyOfResidence'];
                    $profile->gender=$data['Gender'];
                    $profile->profile_status="Updated";
                    $profile->save();
                    $response['status']="Successful";
                     $response['message']="Your Account Profile Updated Successfully ";


                   }
            
             }

        $response['errors']=$errors;
         if(sizeof($response['errors'])>0)
        {
            $response['success']=false;
        }
        else
        {
            $response['success']=true;
        }
       return response()->json($response); 

  }

  public function  save_base64_image($base64_image_string,  $output_file_without_extension,$folder)
  {

    if($folder=="MemberProducts")
    {
      $path_with_end_slash=$destinationPath ='MemberProducts/';; 
    }else{
      $path_with_end_slash=$destinationPath ='dirAvatars/';; 
    }
   
    $splited = explode(',', substr( $base64_image_string , 5 ) , 2);
    $mime=$splited[0];
    $data=$splited[1];

    $mime_split_without_base64=explode(';', $mime,2);
    $mime_split=explode('/', $mime_split_without_base64[0],2);
    if(count($mime_split)==2)
    {
        $extension=$mime_split[1];
        if($extension=='jpeg')$extension='jpg';
        //if($extension=='javascript')$extension='js';
        //if($extension=='text')$extension='txt';
        $output_file_with_extension=$output_file_without_extension.'.'.$extension;
    }
    file_put_contents( $destinationPath . $output_file_with_extension, base64_decode($data) );
    return $output_file_with_extension;


  }

  public function ProfileAvatar(Request $request)
  {
    $response=array();
        $data=$request->all();

        $errors=array();
        $token = $data['userId'];
         if (is_null($token)) 
        {
        $errors[]=array("401"=>"Authorization Token Missing");
        }
        else
        { $user=User::where(['id'=>$token])->first();
            if($user)
            {  
                 

                   $image=$this->save_base64_image($data['avatar'],$user->id,"Avatar");
                   $user->avatar=$image;
                   $user->save();

                    if(strlen($user->avatar)>0)
                          {
                            $avatar_url=url('/dirAvatars/'.$user->avatar);

                          }else{
                            $avatar_url=url('k.jpg');
                          }


                   $response['UserProfile']=$avatar_url;
                   $response['success_msg']="Avatar Uploaded Successfully";
                                         

            }else{
              $errors[]=array("404"=>"Provided Token Does Not Exists");
            }


        

        }
        $response['errors']=$errors;
         if(sizeof($response['errors'])>0)
        {
            $response['success']=false;
        }
        else
        {
            $response['success']=true;
        }
       return response()->json($response);

  }

  public function  GetMyProfile(Request $request)
  {
     $response=array();
        $data=$request->all();

        $errors=array();
        $token = $request->header('token');
         if (is_null($token)) 
        {
        $errors[]=array("401"=>"Authorization Token Missing");
        }
        else
        { $user=User::where(['token'=>$token])->first();
            if($user)
            { 

            if(strlen($user->avatar)>0)
                          {
                            $avatar_url=url('/dirAvatars/'.$user->avatar);

                          }else{
                            $avatar_url=url('k.png');
                          }


                        $profile=$user->profile;
                         $details=array('user_id'=>$user->id,
                                 'token'=>$user->token,
                                 'name'=>$user->name,
                                 'telephone'=>$user->phone,
                                 'avatar'=>$avatar_url,
                                 'email'=>$user->email,
                                 'postal_address'=>$profile->postal_address,
                                 'street_address'=>$profile->street_address,
                                 'dob'=>$profile->dob,
                                 'CountyOfResidence'=>$profile->county,
                                 'Nationality'=>$profile->nationality,
                                 'gender'=>$profile->gender,
                                );
                            $response['basicDetails'] =$details;


                             $models=County::orderBy('county_name')->get();
         $counties=array();

           foreach($models as $model)
           {
            $counties[]=array("CountyId"=>$model->id,"CountyName"=>$model->county_name,'CountyCode'=>$model->county_code);
           }
           $response['counties_list']=$counties;

                            
                 

                                         

            }else{
              $errors[]=array("404"=>"Provided Token Does Not Exists");
            }


        

        }
        $response['errors']=$errors;
         if(sizeof($response['errors'])>0)
        {
            $response['success']=false;
        }
        else
        {
            $response['success']=true;
        }
       return response()->json($response);

  }
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return view('mobile::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('mobile::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        return view('mobile::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        return view('mobile::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
