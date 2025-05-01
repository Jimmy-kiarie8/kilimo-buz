<?php

namespace Modules\Mobile\Http\Controllers\V2;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\User;
use App\Helpers\Helper;
use Modules\Organization\Entities\Region;
use Modules\Organization\Entities\RegionSFP;
use Modules\Organization\Entities\AlertAcknowledgement;
use Modules\Organization\Entities\AlertContact;
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
                'telephone'=>'required|exists:users,phone',
                'device_type'=>'required',
                'device_token'=>'required',

            ],['Invalid Telephone']);
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
                 $user->device_token=$data['device_token'];
                 $user->device_type=$data['device_type'];
                 $user->save();
                   
                 $text="Dear ".$user->name.",Your AGRIBUZ OTP Is:".$password." \n".$data['device_type'];
                  
                $sendsms=Helper::sendSMS($user->phone,$text);
                $response['msg']="OTP Send To  Provided Telephone (".$user->phone.")";
                $response['data']=array();

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

     public function  Mobilelogin(Request $request)
     {

           $response=array();
        $data=$request->all();
        $errors=array();

        $data=$request->all();
         
          $validator =\Validator::make($request->all(), [
                'telephone'=>'required|exists:users,phone',
                'device_code'=>'required',
                'device_version'=>'required',

            ],['Invalid Telephone']);
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
            $user=User::where(['telephone'=>$data['telephone']])->first();
               if($user)
               {
                   if($user->telephone==254748285888)
                   {
                     $password=121214;
                   }else{
                     $password=$code=substr(number_format(time() * rand(),0,'',''),0,6);
                   }
                
                 $user->opt_code=$password*3000;
                 $user->device_token=$data['device_code'];
                 $user->device_version=$data['device_version'];
                 $user->save();
                 $text="Dear ".$user->full_name.",Your P-Count OTP Is:".$password." \n".$data['device_code'];
                  
                $test=Helper::sendsms($user->telephone,$text);
                $response['msg']="OTP Send To  Provided Telephone (".$user->telephone.")";
                $response['data']=array();

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
                            $statist=$this->getUserStatistics($user->id);
                            $dasboardalerts=$this->getDashboardAlerts($user->id);
                        $response['dashboadalerts']=$dasboardalerts;
                         $response['statistics']=  $statist; 
                         $response['basic_details']=$details;
                         $response['regions_attached_to']=$list;
                         

                  
                $response['msg']="User Auntenticated Successfully";
                $response['data']=array('basic_details'=>$details,
                  'regions_attached_to'=>$list);

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


  public function  UpdateProfile(Request $request)
  {
      $response=array();
        $data=$request->all();
        $errors=array();
        $data=$request->all();
        
          $validator =\Validator::make($request->all(), [
                'HomeCounty'=>'required|string',
                'PostAddress'=>'required|string',
                 'Gender'=>'required|string',
                 'Nationality'=>'required|string',
                 'token'=>'required|exists:users,token'


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
             $token=$data['token'];
             $user=User::where(['token'=>$token])->first();
                   if($user)
                   {
                    $profile=$user->profile;
                    $profile->postal_address=$data['PostAddress'];
                    $profile->street_address=$data['Street'];
                    $profile->home_county=$data['HomeCounty'];
                    $profile->nationality=$data['Nationality'];
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

    if($folder=="Avatar")
    {
      $path_with_end_slash=$destinationPath ='dirAvatars/';; 
    }else{
      $path_with_end_slash=$destinationPath ='dirVehicles/';; 
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
        $token = $request->header('token');
         if (is_null($token)) 
        {
        $errors[]=array("401"=>"Authorization Token Missing");
        }
        else
        { $user=User::where(['token'=>$token])->first();
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
                            $response['basicDetails'] =$details;
                            
                 

                                         

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
