<?php

namespace App\Http\Controllers\V2;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\User;
use App\Helpers\Helper;
use Modules\Organization\Entities\Region;
use Modules\Organization\Entities\RegionSFP;
use Modules\Organization\Entities\Contact;
use Modules\Organization\Entities\ContactRegion;
use DB;
use App\Notification;
class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request)
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

                  $models=\DB::select(\DB::raw("call getSfpContacts($user->company_id,$user->id)"));
                    
                    $contacts=$models;
                          $list=array();
                           

                           foreach($contacts as $contact)
                           {
                            $regions=$this->getContactRegions($contact->id,$user->id);
                              
                             $list[]=array('contact_id'=>$contact->id,
                                           'name'=>$contact->name,
                                           'telephone'=>$contact->telephone,
                                           'email'=>$contact->email,
                                           'contact_status'=>$contact->contact_status,
                                           'created_at'=>$contact->created_at,
                                           'RegionsList'=>$regions,


                               );
                           }
                           $response['ContactList']=$list;
                           
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

    public function getContactRegions($contact_id,$user_id)
    {
        $models=ContactRegion::join('regions','regions.id','=','contacts_region.region_id')
            ->where(['contact_id'=>$contact_id])
            ->select('region_id','region_name','contacts_region.created_at')
            ->get();
            $list=array();
             foreach($models as $model)
             {
               $list[]=array('region_id'=>$model->region_id,'region_name'=>$model->region_name);
             }
    return $list;
   }

   public function Delete(Request $request)
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
              

                     if(isset($data['contact_id']) && !empty($data['contact_id']))
                     {
                        $contact=Contact::find($data['contact_id']);
                         if($contact)
                          {
                            $contact->deleted_by=$user->id;
                            $contact->contact_status="Deleted";
                            $contact->save();
                            $contact->delete();
                           
                            $response['success_msg']="Contact Deleted Successfully";
                          }else{
                          $errors[]=array("404"=>"Contact Not Found ");
                          }

                     }else{
                         $errors[]=array("401"=>"Contact Id Is Required ");
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

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create(Request $request)
    {

        
           $data=$request->all();
           

        

            $response=array();
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

                if($data['names'] =="" || $data['telephone'] =="" || $data['Status'] ==""  )
                    {

                        $errors[]=array("401"=>"Name,Telephone  and Status Are Mandatory");
                            
                    }else{
                        
                         $names=$data['names'];
                         $telephone=$data['telephone'];
                           $name_array=explode(",", $names);
                            $telephones=explode(",",$telephone );
                                

                             foreach($telephones as $key=>$value)
                             {
                               $name=$name_array[$key];
                                $phone=$telephones[$key];

                                $model=Contact::where(['company_id'=>$user->company_id,'name'=>$name,'telephone'=>$phone])->first();


                                   if($model)
                                   {
                                    continue;
                                   }
                                   else{
                                     DB::beginTransaction();
                              $model=new Contact();
                              $model->name=strtoupper($name);
                              $model->email=null;
                              $model->telephone=$phone;
                              $model->contact_status="Active";
                              $model->company_id=$user->company_id;
                              $model->sfp_user_id=$user->id;
                                  if($model->contact_status=="Active")
                                    {
                                       $model->activated_at=date('Y-m-d H:i:s'); 
                                       $model->activated_by=$user->id;
                                   }else{
                                    $model->deactivated_at=date('Y-m-d H:i:s');
                                    $model->deactivated_by=$user->id; 
                                   }
                               $model->channel="Mobile";
                               $model->save();
                                 
                                  if($model)
                                  {
                                       if(isset($data['regions']))
                                       {
                                        $reg=$data['regions'];
                                     $region=Region::where(['id'=>$reg])->first();
                                     $region_ID=$region->id;

                                       }else{
                                         $region=RegionSFP::where(['user_id'=>$user->id])->first();
                                         $region_ID=$region->region_id;
                                          
                                       }

                                        
                                     
                                               if($region)
                                               {
                                                 $contactregion=ContactRegion::where(['contact_id'=>$model->id,'region_id'=>$region_ID,'company_id'=>$model->company_id])
                                                  ->first();

                                                 if(!$contactregion)
                                                 {
                                                  $contactregion=new ContactRegion();
                                                  $contactregion->contact_id=$model->id;
                                                  $contactregion->company_id=$model->company_id;
                                                  $contactregion->region_id=$region_ID;
                                                  $contactregion->save();
                                                 }
                                                  $users=Helper::getRoleUsers('SuperAdmin');
                                 
                                          foreach($users as $roleuser)
                                          {
                                            $subject="New Contact ".$model->telephone."  Added";
                                            $body=$user->name."add new contact;Name:".$model->name.",Telephone ".$model->telephone;
                                            $icon="mdi mdi-account";
                                            Helper::createSystemNotification($roleuser->user_id,$subject,$body,$icon);
                                            
                                          }
                                              }
                                            
                                      }
                                       
                                   
                                  DB::commit();




                                   }
                            }

                              $response['success_ms']="Contacts added Successfully";
                              ;










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

    public function UpdateContact(Request $request)
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


                if($data['name'] =="" || $data['telephone'] =="" || $data['Status'] ==""  )
                    {

                        $errors[]=array("401"=>"Name,Telephone  and Status Are Mandatory");
                            
                    }else{
                        
                       $model=Contact::find($data['contact_id']);

                           if(!$model)
                           {

                            $errors[]=array("404"=>"Contact Details Not Found");
                     
                            }else
                            {

                            DB::beginTransaction();
                             
                              $model->name=strtoupper($data['name']);
                              $model->email=$data['email'];
                              $model->telephone=$data['telephone'];
                              $model->contact_status=$data['Status'];
                              $model->company_id=$user->company_id;
                              $model->sfp_user_id=$user->id;
                                  if($model->contact_status=="Active")
                                    {
                                       $model->activated_at=date('Y-m-d H:i:s'); 
                                       $model->activated_by=$user->id;
                                   }else{
                                    $model->deactivated_at=date('Y-m-d H:i:s');
                                    $model->deactivated_by=$user->id; 
                                   }
                               $model->channel="Mobile";
                               $model->save();
                                 


                               
                               $regions=$this->getContactRegions($model->id,$user->id);
                              
                             $list=array('contact_id'=>$model->id,
                                           'name'=>$model->name,
                                           'telephone'=>$model->telephone,
                                           'email'=>$model->email,
                                           'contact_status'=>$model->contact_status,
                                           'created_at'=>$model->created_at,
                                           'RegionsList'=>$regions,
                                            );
                             $response['contactDetails']=$list;
                                

                             DB::commit();
                            $response['success_msg']="Contact Updated Successfully";

                        }
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
