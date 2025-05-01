<?php

namespace Modules\Mobile\Http\Controllers\V2;

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
use Modules\Organization\Entities\Alert;
use Modules\Organization\Entities\AlertAcknowledgement;
use Modules\Organization\Entities\AlertContact;
use App\Notification;
use Modules\Mobile\Entities\AdvisoryCategory;
use Modules\Mobile\Entities\Advisory;
class AlertController extends Controller
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


        $models=DB::select("SELECT alert_acknowledgement.id as acknowledgement_id,alert_name,alert_date,alert_id,acknowledgement_expiry,sent_date,number_acknowledged,targeted_number ,alert_status,alert_category,acknowlement_status FROM alert_acknowledgement 
join  alerts on alerts.id=alert_acknowledgement.alert_id
WHERE sfp_user_id=? and alerts.alert_status='Active'  order by alerts.id desc",[$user->id]);
        $list=array();
        $elist=array();


        foreach($models as $model)
        {
         if($model->alert_status=="Expired")
         {

             if(sizeof( $elist)<=8)
             {
                $elist[]=array("alert_id"=>$model->alert_id,
            "Category"=>$model->alert_category,
            'acknowledgement_id'=>$model->acknowledgement_id,
            'alert_title'=>strtoupper("P-Count Alert"),
            'alert_name'=>$model->alert_name,'alert_date'=>$model->sent_date,
            'targeted_number'=>$model->targeted_number,
            'number_acknowledged'=>($model->number_acknowledged>$model->targeted_number)?$model->targeted_number:$model->number_acknowledged,



            'number_remaining'=>$model->targeted_number-$model->number_acknowledged,'alert_status'=>$model->alert_status,"Expiry_date"=>$model->acknowledgement_expiry,'acknowledgement_status'=>$model->acknowlement_status);

             }

         

         }else{
           $list[]=array("alert_id"=>$model->alert_id,
            "Category"=>$model->alert_category,
            'acknowledgement_id'=>$model->acknowledgement_id,
            'alert_title'=>strtoupper("P-Count Alert"),
            'alert_name'=>$model->alert_name,'alert_date'=>$model->sent_date,'targeted_number'=>$model->targeted_number,'number_acknowledged'=>$model->number_acknowledged,'number_remaining'=>$model->targeted_number-$model->number_acknowledged,'alert_status'=>$model->alert_status,"Expiry_date"=>$model->acknowledgement_expiry,'acknowledgement_status'=>$model->acknowlement_status);

         }

       }
       $response['Active_Alerts']=$list;
       $response['Expired_Alerts']=$elist;



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

public function getExpired(Request $request)
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
  {  $models=AlertAcknowledgement::join('alerts','alerts.id','=','alert_acknowledgement.alert_id')
->where(['sfp_user_id'=>$user->id,'alert_acknowledgement.company_id'=>$user->company_id])
->where('alert_status','Expired')
->select('alert_acknowledgement.id as acknowledgement_id','alert_id','alert_name','alert_date','acknowledgement_expiry','number_acknowledged','targeted_number','alert_status','sent_date','acknowlement_status','alert_category')
->groupBy('alert_id')
->orderBy('alert_acknowledgement.created_at','desc')
->take(10)
->get();
     
$list=array();

foreach($models as $model)
{

  $list[]=array("alert_id"=>$model->alert_id,
    "Category"=>$model->alert_category,
    'acknowledgement_id'=>$model->acknowledgement_id,
    'alert_title'=>strtoupper("P-Count Alert"),
    'alert_name'=>$model->alert_name,'alert_date'=>$model->sent_date,'targeted_number'=>$model->targeted_number,'number_acknowledged'=>$model->number_acknowledged,'number_remaining'=>$model->targeted_number-$model->number_acknowledged,'alert_status'=>$model->alert_status,"Expiry_date"=>$model->acknowledgement_expiry,'acknowledgement_status'=>$model->acknowlement_status);
}
$response['Active_Alerts']=$list;


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


public function getAlertContact(Request $request)
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
    {   if(isset($data['alert_id']) && strlen($data['alert_id'])>0)
  {
   $alert_id=$data['alert_id'];
   $models=AlertContact::where(['alert_id'=>$alert_id,'alert_contacts.sfp_user_id'=>$user->id,'alert_contacts.company_id'=>$user->company_id])
   ->select('contact_id','name','telephone','email','contact_alert_status','alert_contacts.id as response_id')
   ->join('contacts','contacts.id','=','alert_contacts.contact_id')->get();
   $p_list=array();
   $a_list=array();
   foreach($models as $model)
   {
    if($model->contact_alert_status=="Pending")
    {
     $p_list[]=array("alert_id"=>$alert_id,
       "contact_id"=>$model->contact_id,
       'name'=>$model->name,
       'telephone'=>$model->telephone,
       'email'=>$model->email,
       'response_id'=>$model->response_id,
       'contact_alert_status'=>$model->contact_alert_status,
     );
   }else{
    $a_list[]=array(
      "alert_id"=>$alert_id,
      "contact_id"=>$model->contact_id,
      'name'=>$model->name,
      'telephone'=>$model->telephone,
      'email'=>$model->email,
      'response_id'=>$model->response_id,
      'contact_alert_status'=>$model->contact_alert_status,
    );
  }


}
$response['pending_list']=$p_list;
$response['acknowledged_list']=$a_list;


}else{
 $errors[]=array("401"=>"Alert ID is Required"); 
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

public function AcknowledgeAlert(Request $request)
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
   if(isset($data['acknowledgement_id']) && strlen($data['acknowledgement_id'])>0)
   {
     $id=$data['acknowledgement_id'];
     $model=AlertAcknowledgement::find($id);
     if($model)
     {
       if($model->acknowlement_status=="Acknowledged")
       {
         $response['danger_msg']="Acknowledgement Already Submitted Successfully";

       }else{
        $model->acknowledged_date=date('Y-m-d H:i:s');
        $model->acknowlement_status="Acknowledged";
        $model->save();

        $users=Helper::getRoleUsers('SuperAdmin');

        foreach($users as $roleuser)
        {
          $subject="New Alert #".$model->id."  Acknowledgement";
          $body=$user->name."acknowledged alert #".$model->id.", at  ".$model->acknowledged_date;
          $icon="ion ion-ios-checkbox ";
          Helper::createSystemNotification($roleuser->user_id,$subject,$body,$icon);

        }





        $response['success_msg']="Acknowledgement Submitted Successfully";
      }


    }
  }else{
   $errors[]=array("401"=>"Alert  Acknowledgement ID is Required"); 
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

public function CreateNotification(Request $request)
{
  $response=array();
  $data=$request->all();

  $errors=array();
  $token = $request->header('DeviceID');
  if (is_null($token)) 
  {
    $errors[]=array("401"=>"Authorization Token Missing");
  }
  else
  {

    $deviceToken=$data['DeviceID'];
    $title=$data['NotificactionTitle'];
    $mesage_body=$data['NotificationBody'];
    $test=Helper::sendNotification($deviceToken,$title,$mesage_body);



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

public function PostContacts(Request $request)
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
  if(isset($data['alert_id']) && strlen($data['alert_id'])>0)
  {
    $alert=Alert::find($data['alert_id']);
    if($alert)
    {
      $list=$data['contact_respond_ids'];
      $array_list=explode(",", $list);
        

      $accounted_list=array();
      if(sizeof($array_list)>0)
      {


       foreach($array_list as $key)
       {


         $alertcontact=AlertContact::where(['id'=>$key,
          'is_acknowledged'=>0])->first();

             
         if($alertcontact)
         {
           DB::beginTransaction();
               if(in_array($key, $accounted_list))
               {

               }else{

                $alertcontact->is_acknowledged=1;
          $accounted_list[]=$key;
          $alertcontact->acknowlement_date=date('Y-m-d H:i:s');
          $alertcontact->contact_alert_status="Accounted";
          $turn_around=Helper::getTurnAround($alertcontact->alert_date,$alertcontact->acknowlement_date);
          $alertcontact->turn_around_time=$turn_around;
          $min=$this->getMinTurnAround($alertcontact->alert_date,$alertcontact->acknowlement_date);
          $alertcontact->turn_min=$min;
          $alertcontact->save();
           

               }
          
           DB::commit();
           }

       



      }

      $total_accounted=AlertContact::where(['alert_id'=>$alert->id,'is_acknowledged'=>1,'sfp_user_id'=>$user->id])->count();
         
        
      $model=AlertAcknowledgement::where(['alert_id'=>$alert->id,'sfp_user_id'=>$user->id])->first();
           if($model)
           {
             
               if($total_accounted>=$model->targeted_number)
               {
                 
                $model->number_acknowledged=$model->targeted_number;
                 
               }else{
                   
                 $model->number_acknowledged=$total_accounted;
               }
            
              $model->save();
               
               

           }
     
     

      $response['success_msg']="Contacts Marked Accounted Successfully";

    }else{
     $errors[]=array("404"=>"At least One Contact Must Be Checked/Selected "); 
   }

 }else{
  $errors[]=array("404"=>"Alert Details Not Found"); 
}




}else{
  $errors[]=array("404"=>"Alert ID Is Required"); 

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


public  function getMinTurnAround($start_date,$end_date)
{

  $start_date=date('Y-m-d H:i:s',strtotime($start_date));
  $end_date=date('Y-m-d H:i:s',strtotime($end_date));
  $t1 = \Carbon::parse($start_date);
  $t2 = \Carbon::parse($end_date);
  $diff = $t1->diff($t2);
  return  ( ((($diff->d)*60 )*24)    +  (($diff->h)*60 )+($diff->i));

}

public function getAdvisoryCategories(Request $request)
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
 $models=AdvisoryCategory::all();
 $list=array();
 foreach($models as $model)
 {
  $list[]=array("CategoryId"=>$model->id,
   "CategoryName"=>$model->type_name,
   "CategoryDescription"=>$model->description,
   "DatetimeCreated"=>$model->created_at,


 );
}
$response['categories']= $list;





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


public function getCategoryAdvisories(Request $request)
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
    $id=$data['CategoryId'];
    $model=AdvisoryCategory::find($id);
    if($model)
    {
      $basicDetails=array("CategoryId"=>$model->id,
        "CategoryName"=>$model->type_name,
        "CategoryDescription"=>$model->description,
        "DatetimeCreated"=>$model->created_at,

      );

      $models=Advisory::where(['advisory_type_id'=>$model->id])->get();

      $list=array();
      foreach($models as $advisory)
      {
        $list[]=array("CategoryId"=>$model->id,
         "AdvisoryId"=>$advisory->id,
         "CategoryName"=>$model->type_name,
         "AdvisoryDescription"=>$advisory->Advisrory_description,
         "DatetimeCreated"=>$advisory->created_at,


       );
      }
      $response['basicDetails']= $basicDetails;
      $response['categories']= $list;

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
