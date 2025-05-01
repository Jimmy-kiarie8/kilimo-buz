<?php

namespace Modules\Usermanagement\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller ;
use Modules\Usermanagement\Entities\Department;
use Modules\Usermanagement\Entities\County;
use Modules\Usermanagement\Entities\SubCounty;
use Modules\Usermanagement\Entities\ValueChain;
use Modules\Usermanagement\Entities\NodeType;
use Modules\Usermanagement\Entities\Organization;
use Modules\Usermanagement\Entities\Member;
use Modules\Usermanagement\Entities\Product;
use Modules\Usermanagement\Entities\ProductName;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Session;
use Modules\Usermanagement\Entities\Order;
use App\User;
use Auth;
use DB;
use Input;
use Validator;
use Redirect;
use App\Helpers\SystemAudit;
use Modules\Usermanagement\Entities\Profile;
use Excel;
use App\Imports\MemberImport;
use Maatwebsite\Excel\Exceptions\NoTypeDetectedException;
use Modules\Usermanagement\Entities\UnitOfMeasure;
use App\Helpers\Helper;
class MemberController extends Controller
{
     protected $userID;
    protected $mid;
    protected $OrgID;
  public function __construct()
    {
       $this->middleware('auth');
        
       
        $this->middleware(function ($request, $next) {
            $this->userID = Auth::user()->id;
            $this->OrgID=Auth::user()->org_id;

            return $next($request);
        });
    }


    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
       
         if(Auth::user()->hasRole(["Organization","County Co-ordinator"]))
         {
            $data['page_title']="Members List";

        return view('usermanagement::members.index',$data);

    }else{
        return view("forbidden");
    }
    }

    public function getMemberProducts()
    {
      if(Auth::user()->hasRole(["SuperAdmin","County Co-ordinator"]))
         {
            $data['page_title']="Products List";
           
            if(Auth::User()->hasRole("SuperAdmin"))
              {
                 
                 $data['counties']=County::pluck('county_name','id')->toArray();

              }else if(Auth::User()->hasRole("County Co-ordinator")){
                 $data['counties']=County::where('id',$this->OrgID)->pluck('county_name','id')->toArray();
              }else{
                 $data['counties']=array();
                
                
              }





        return view('usermanagement::members.product_index',$data);

    }else{
        return view("forbidden");
    }

    }


    public function MemberToVCOByID(Request $request)
    {

      $data['page_title']="VCA/VCO ID LINK";
              if(Auth::User()->hasRole("SuperAdmin"))
              {
                 
                 $data['counties']=County::pluck('county_name','id')->toArray();

              }else if(Auth::User()->hasRole("County Co-ordinator")){
                 $data['counties']=County::where('id',$this->OrgID)->pluck('county_name','id')->toArray();
              }else{
                 $data['counties']=array();
                
                
              }
           
            $data['url']=url()->current();
            $data['model']=new Member();

                if($request->isMethod("post"))
                {
                  $data=$request->all();
                    $model=Member::find($data['member_id']);
                      if($model)
                      {
                        $model->gender=$data['gender'];
                        $model->id_number=$data['id_number'];
                        $model->member_telephone=$data['member_telephone'];
                        $model->save();
                        Session::flash("success_msg","Member Details Updated Succesfully");
                      }
                     return redirect()->back();
                }

             return view('usermanagement::members.linkbyIduumber',$data);



    }

    public function VCOMemberOTP()
    {
       $data['page_title']="Mobile OTP";


             return view('usermanagement::members.loginotp',$data);

    }


    public function GetMobileOTP(Request $request)
    {
       $data=$request->all();
         if(isset($data['Telephone']))
         {

           $user=\App\User::where(['phone'=>$data['Telephone']])->first();
              if($user)
              {
                 if(strlen($user->opt_code)>2)
                 {

                  return "OTP Code is : " .$user->opt_code/3000;
                 }else{

                  return "Telephone Number Has Not Intiated Login Request";

                 }



              }else{
                return "Telephone Number Provided Not Registered On Mobile App";
              }


         }else{
          return "No Telephone Number Provided";
         }
         dd($data);

    }


    public  function GetMemberList($id)
    {
      $models=Member::where(['org_id'=>$id])->OrderBy('member_name','asc')->get();
        echo '<option value="">-----select Member Name----</option>';
         foreach($models as $model)
         {
           echo '<option value="'.$model->id.'">'.$model->member_name.'</option>';

         }
    }

    public function GetMemberDetail($id)
    {
      $model=Member::find($id);
       $data=array("IDNumber"=>$model->id_number,'Telephone'=>$model->member_telephone);
       return $data;


    }


    public function VCAByCounty()
    {

        if(Auth::user()->hasRole(["SuperAdmin","County Co-ordinator"]))
         {
            $data['page_title']="County VCA Statistics";

        return view('usermanagement::members.vcacounty',$data);

    }else{
        return view("forbidden");
    }


    }

    public function VCAByVCO()
    {
        if(Auth::user()->hasRole(["SuperAdmin","County Co-ordinator"]))
         {
            $data['page_title']="County VCA Statistics";

        return view('usermanagement::members.vcaorganization',$data);

    }else{
        return view("forbidden");
    }

    }
    public function ImportMembersByVCO(Request $request)
    {
        if(Auth::user()->hasRole(["Organization"]))
         {
            $data['page_title']="Import";
              if(Auth::User()->hasRole("SuperAdmin"))
              {
              
                 $data['counties']=County::pluck('county_name','id')->toArray();

              }else if(Auth::User()->hasRole("County Co-ordinator")){
                 $data['counties']=County::where('id',$this->OrgID)->pluck('county_name','id')->toArray();
              }else{
                 $data['counties']=array();
                 $data['orgs']=Organization::select('org_name','id')->where(['id'=>$this->OrgID])->get();
                
              }
           
            $data['url']=url()->current();
            
                if($request->isMethod("Post"))
                { ini_set('memory_limit', '-1');
                   $data=$request->all();
                    

                     
                    $file_name=$data['file_name'];
                      $path1 = $file_name->store('temp'); 
$path=storage_path('app').'/'.$path1;  
                 
                 $array=  Excel::toarray(new MemberImport, $path);
                  array_splice($array[0], 0, 1);
                  $not_list=array();
                     foreach($array[0] as $row)
                     {
                         dd($row);
                       
                       
                      $MemberName=trim($row[0]);
                      $MemberName=str_ireplace("'","",  $MemberName);

                      $Gender=$row[2];
                        
                       if($Gender=="M")
                       {
                        $Gender="Male";
                       }else{
                         $Gender="Female";
                       }

                         if($Gender=="Male")
                         {
                          $isMale=1;
                          $IsFemale=0;
                         }else{
                          $isMale=0;
                          $IsFemale=1;
                         }

                      $ValueChain=trim($row[5]);
                      $phone=trim($row[3]);
                      $idnum=$row[1];
                      $bracket=$row[4];
                      $disability=$row[5];
                      $location=$row[6];

                      $organization=Organization::find($data['org_id']);


                         if($organization)
                         {
                           
                            $ValueChain=$organization->value_chain_id;
                           
                          $number=$this->generateMemberNumber($organization->id);
                          $node=$organization->node_id;
                         
                         $model=Member::where(['org_id'=>$organization->id,'id_number'=>$idnum])->first();
                           if(!$model)
                           {
                           
                             try{
                               DB::beginTransaction(); 
                               $model=new Member();
                             $model->member_name=strtoupper($MemberName);
                             $model->member_telephone=$phone;
                             $model->value_chain_id=$organization->value_chain_id;
                             $model->node_id=$organization->node_id;
                             $model->gender=$Gender;
                             $model->member_number =$number;
                             $model->created_by=$this->userID;
                             $model->org_id=$organization->id;
                             $model->location=$location;
                             $model->id_number=$idnum;
                             $model->channel="Web";
                             $model->age_bracket=$bracket;
                             $model->isMale=$isMale;
                             $model->IsFemale=$IsFemale;
                             

                             $model->save();
                            DB::commit();

                             }catch(\Exception $e)
                             {
                             $test= Helper::sendEmailToSupport($e);
                               return false;

                             }
                            
                            } 
                          }else{
                              if(in_array($OrgName, $not_list))
                              {

                              }else{
                                 $not_list[]=$OrgName;
                              }
                          

                          }
                      
                     }
                       
               
                  
                   Session::flash("success_msg","Members Imported Succesfully");
                   return redirect('/System/MemberAccount/Index');
                }

        return view('usermanagement::members._import',$data);

    }else{
        return view("forbidden");
    }

    }

    public function  ImportMembers(Request $request)
    {
       if(Auth::user()->hasRole(["SuperAdmin","County Co-ordinator","Organization"]))
         {
            $data['page_title']="Import";
              if(Auth::User()->hasRole("SuperAdmin"))
              {
                 $data['counties']=County::pluck('county_name','id')->toArray();

              }else if(Auth::User()->hasRole("County Co-ordinator")){
                 $data['counties']=County::where('id',$this->OrgID)->pluck('county_name','id')->toArray();
              }else{
                 $data['counties']=array();
              }
           
            $data['url']=url()->current();
                if($request->isMethod("Post"))
                { ini_set('memory_limit', '-1');
                   $data=$request->all();

                     
                    $file_name=$data['file_name'];
                      $path1 = $file_name->store('temp'); 
$path=storage_path('app').'/'.$path1;  
                 
                 $array=  Excel::toarray(new MemberImport, $path);
                  array_splice($array[0], 0, 1);
                  $not_list=array();



                   $chunk_size = 500;
                   $big_array=$array[0];

                      
    foreach (array_chunk($big_array, $chunk_size) as $data_chunk ) {
          foreach($data_chunk  as $row)
          {
              
             
                      
             $orgNum=trim($row[3]) ;

                         $organization=Organization::where(['org_number'=>$orgNum])->first();

                          


                         
                           if($organization)
                           {

                            $MemberName=trim($row[5]);
                            $MemberName=str_ireplace("'","",  $MemberName);
                            $Gender=strtoupper($row[7])   ;
                            if($Gender=="M" )
                           {
                            $Gender="Male";
                           }else{
                             $Gender="Female";
                           }

                         if($Gender=="Male")
                         {
                          $isMale=1;
                          $IsFemale=0;
                         }else{
                          $isMale=0;
                          $IsFemale=1;
                         }
                         $ValueChain=$organization->value_chain_id;
                         $number=$this->generateMemberNumber($organization->id);
                        $node=$organization->node_id;
                          $phone=trim($row[6]);
                         
                           

                           $mname=strtoupper($MemberName);

                             $model=Member::where(['member_name'=> $mname,'org_id'=>$organization->id,'value_chain_id'=>$organization->value_chain_id])->first();


                               if(!$model)
                               {
                                DB::beginTransaction();
                             $model=new Member();
                             $model->member_name=strtoupper($MemberName);
                             $model->member_telephone=$phone;
                             $model->value_chain_id=$organization->value_chain_id;
                             $model->node_id=(strlen($organization->node_id))?$organization->node_id:1;
                             $model->gender=$Gender;
                             $model->member_number =$number;
                             $model->created_by=$this->userID;
                             $model->org_id=$organization->id;
                             $model->member_status="Active";
                             $model->channel="Web";
                             $model->isMale=$isMale;
                             $model->IsFemale=$IsFemale;
                             $model->save();
                             DB::commit();

                               }


                            

                     

                           }

          }
 
  
}

               Session::flash("success_msg","Members Imported Succesfully");
                   return redirect('/System/VCOMembers/Index');
                }

        return view('usermanagement::members.import',$data);

    }else{
        return view("forbidden");
    }

    }

    public function getMemberDetails($id)
    {
       $model=Member::find($id);
        if($model)
        {
          return $model->member_number;
        }else{
          return "Unknown";
        }

    }

    public function getAdminList()
    {
          if(Auth::user()->hasRole(["SuperAdmin","County Co-ordinator"]))
         {
            $data['page_title']="VCO Member";

        return view('usermanagement::members.adminindex',$data);

    }else{
        return view("forbidden");
    }

    }
    public function ProductList()
    {
        if(Auth::user()->hasRole("Organization"))
         {
             $data['page_title']="Member Products";

        return view('usermanagement::products.index',$data);

         }else{
          return view("forbidden");
         }
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */

    public function addProduct(Request $request)
    {
         if(Auth::user()->hasRole("Organization"))
         {
        $organization=Organization::find($this->OrgID);
         $data['values']=ValueChain::where('id',$organization->value_chain_id)->pluck('value_name','id')->toArray();
         $data['members']=Member::where(['org_id'=>$this->OrgID,'member_status'=>"Active"])->pluck('member_name','id')->toArray();
          $data['url']=url()->current();
          $data['model']=new Product();  

          $data['units']=array();
              if($request->isMethod("post"))
              {
                 $data=$request->all();
                  
                 
                   $model=Product::where(['member_id'=>$this->OrgID,'value_chain_id'=>$data['value_chain_id'],'product_size'=>$data['product_size'],'product_color'=>$data['product_color']])->first();
                     if(!$model)
                     {

                       $model=new Product();
                        $model->org_id=$this->OrgID;
                   $model->member_id=$data['member_id'];
                   $model->value_chain_id=$data['value_chain_id'];
                     }
                     $productname=ProductName::find($data['product_name']);
                      
                  
                   $model->variety=$productname->product_name;
                 
                   $model->quantity_available=$data['quantity_available'];
                   $model->unit_price=$data['unit_price'];
                   $model->created_by=$this->userID;
                   $model->product_color=$data['product_color'];
                   $model->product_size=$data['product_size'];
                   $model->uom=$data['uom'];
                   $model->product_id=$data['product_name'];
                   $model->save();
                   
                Session::flash("success_msg","Product Added Succesfully");
                 return redirect('/System/MemberAccount/ProductList');
              }
                 

           return view('usermanagement::products.create',$data);
           }else{
        return view("forbidden");
    }

    }

    public function  CountyCreate(Request $request)
    {
       if(Auth::user()->hasRole(["Organization","County Co-ordinator","SuperAdmin"]))
         {
            $data['page_title']="Register New Member";
             
               
            $data['model']=new Member();
            $data['nodes']=NodeType::pluck('node_name','id')->toArray();
            $data['values']=ValueChain::pluck('value_name','id')->toArray();
             if(Auth::User()->hasRole("County Co-ordinator"))
             {
              $data['vcos']=Organization::where(['county_id'=>$this->OrgID])->OrderBy('org_name')->pluck('org_name','id')->toarray();

             }else{

               $data['vcos']=Organization::where(['county_id'=>$this->OrgID])->OrderBy('org_name')->pluck('org_name','id')->toarray();

             }

             $data['counties']=County::OrderBy('county_name')->pluck('county_name','id')->toarray();

            

            $data['url']=url()->current();
              if($request->isMethod("post"))
              {
                 $data=$request->all();
                  
                   $model=Member::where(['id_number'=>$data['id_number'],'org_id'=>$data['org_id']])->first();
                      if($model)
                      {
                         Session::flash("danger_msg","Member Already Registered");
                          return redirect()->back();

                      }else{
                        $orgId=$data['org_id'];
                        $number=$this->generateMemberNumber($orgId);
                          
                   $model=new Member();
                   $model->member_name=strtoupper($data['member_name']);
                   //$model->member_email=$data['member_email'];
                   $model->id_number=$data['id_number'];
                   $model->member_telephone=$data['member_telephone'];
                   $model->value_chain_id=$data['value_chain_id'];
                   $model->node_id=$data['node_id'];
                   $model->gender=$data['gender'];
                   $model->member_number =$number;
                   $model->created_by=$this->userID;
                   $model->org_id=$data['org_id'];
                   //$model->member_dob=date('Y-m-d',strtotime($data['member_dob']));
                   $model->location=$data['location'];
                   $model->save();
                     Session::flash("success_msg","Member Added Successfully");
                      return redirect('/System/VCOMembers/Index');
                      }
                     
              
                   

              }

        return view('usermanagement::members.county_create',$data);
    } else{
        return view("forbidden");
    }

    }


    public function fetchOrgVCAS()
    {
        $models=DB::select("select org_id,org_name,count(vco_members.id) as number ,org_number as vco_number from vco_members  join organizations o on o.id=vco_members.org_id  where county_id=? group by org_id,org_name",[$this->OrgID]);

        return Datatables::Of($models)->make(true);
    }
    public function create(Request $request)
    {
         if(Auth::user()->hasRole(["Organization","County Co-ordinator"]))
         {
            $data['page_title']="Registered Entities";
              $organization=Organization::find($this->OrgID);
               
            $data['model']=new Member();
            $data['nodes']=NodeType::pluck('node_name','id')->toArray();
            $data['values']=ValueChain::where('id',$organization->value_chain_id)->pluck('value_name','id')->toArray();
            $data['url']=url()->current();
              if($request->isMethod("post"))
              {
                 $data=$request->all();
                   $model=Member::where(['id_number'=>$data['id_number'],'org_id'=>$this->OrgID])->first();
                      if($model)
                      {
                         Session::flash("danger_msg","Member Already Registered");
                          return redirect()->back();

                      }else{
                        $number=$this->generateMemberNumber();
                          
                          DB::beginTransaction();
                   $model=new Member();
                   $model->member_name=strtoupper($data['member_name']);
                   $model->member_email=$data['member_email'];
                   $model->id_number=$data['id_number'];
                   $model->member_telephone=$data['member_telephone'];
                   $model->value_chain_id=$data['value_chain_id'];
                   $model->node_id=$data['node_id'];
                   $model->gender=$data['gender'];
                   $model->member_number =$number;
                   $model->created_by=$this->userID;
                   $model->org_id=$this->OrgID;

                   $model->member_dob=date('Y-m-d',strtotime($data['member_dob']));
                   $model->location=$data['location'];
                   $model->channel="Web Portal";
                   $model->age_bracket=$data['age_bracket'];
                   $model->save();

                    $sms_text="Dear ".$model->member_name.",Your  Agribiz member number is ". $model->member_number;
                    DB::commit();
                   $test=Helper::sendSMS($model->member_telephone,$sms_text);
                    
                     Session::flash("success_msg","Member Added Successfully");
                      return redirect('/System/MemberAccount/Index');
                      }
                     
              
                   

              }

        return view('usermanagement::members.create',$data);
    } else{
        return view("forbidden");
    }
    }

    public function FetchVCAByCounty()
    {
         $models=DB::select("select county_id,county_name,format(count(vco_members.id),0) as number,sum(isMale) as male,sum(IsFemale) as female  from vco_members  join organizations o on o.id=vco_members.org_id join counties c on c.id=o.county_id group by county_id,county_name");
         return Datatables::of($models)->make(true);
    }

    public function fetchOrgList()
    {
        $models=DB::select('SELECT vco_members.id,`member_name`,`member_email`,`member_telephone`,`id_number`,`member_number`,`gender`,location,node_name,value_name,member_status FROM `vco_members`
join node_types on node_types.id=vco_members.node_id
join value_chains on value_chains.id=vco_members.value_chain_id where vco_members.org_id=? and member_status=?',[$this->OrgID,"Active"]);
         return Datatables::of($models)
          ->rawColumns(['action'])
          ->addColumn('action', function ($model) {
              $edit_url=url('/System/Member/EditDetails/'.$model->id);
               $detele_url=url('/System/Member/Remove/'.$model->id);
                        return '<div class="dropdown">
  <button class="btn btn-success btn-xs dropdown-toggle" type="button" data-toggle="dropdown">Action
  <span class="caret"></span></button>
  <ul class="dropdown-menu">
    <li><a style="cursor:pointer;"   data-title="Edit" href="'.$edit_url.'">&nbsp;&nbsp;&nbsp;&nbsp;Edit Details</a></li>

     <li><a style="cursor:pointer;" class="reject-modal"   data-title="Remove Member From List" data-url="'.$detele_url.'">&nbsp;&nbsp;&nbsp;&nbsp;Remove</a></li>
    
    </ul>
</div> 
';
            })->make(true);
    }

    public function Remove($id,Request $request)
    {
      $model=Member::find($id);
        $data['model']=$model;
        $data['url']=url()->current();
           if($request->isMethod("Post"))
           {
             $data=$request->all();
              $model->member_status="Removed";
              $model->reason=$data['reason'];
              $model->save();
               Session::flash("success_msg","Member Removed From The List Successfully");
               return redirect()->back();
           }
        return view('usermanagement::members._remove',$data);

    }

    public function fetchAdminList()
    {
           if(Auth::User()->hasRole("County Co-ordinator"))
           {

             $models=DB::select('SELECT vco_members.id,org_name,`member_name`,`member_email`,`member_telephone`,`id_number`,`member_number`,`gender`,node_name,value_name,county_name,sub_county_name,location,vco_members.created_at FROM `vco_members`
join node_types on node_types.id=vco_members.node_id
join value_chains on value_chains.id=vco_members.value_chain_id
join organizations on organizations.id=vco_members.org_id
join  counties on counties.id=organizations.county_id
left join sub_counties on sub_counties.id=organizations.sub_county_id where organizations.county_id=? order by vco_members.id     desc limit 20000',[$this->OrgID]);

           }else{
            $models=DB::select('SELECT vco_members.id,org_name,`member_name`,`member_email`,`member_telephone`,`id_number`,`member_number`,`gender`,node_name,value_name,county_name,sub_county_name,location,vco_members.created_at FROM `vco_members`
join node_types on node_types.id=vco_members.node_id
join value_chains on value_chains.id=vco_members.value_chain_id
join organizations on organizations.id=vco_members.org_id
join  counties on counties.id=organizations.county_id
left join sub_counties on sub_counties.id=organizations.sub_county_id order by vco_members.id desc limit 20000');

           }
         
            return Datatables::of($models)
          ->rawColumns(['action'])
          ->addColumn('action', function ($model) {
              $edit_url=url('/System/Member/EditMemberDetails/'.$model->id);
              $view_url=url('/System/Member/ViewDetails/'.$model->id);
                        return '<div class="dropdown">
  <button class="btn btn-success btn-xs dropdown-toggle" type="button" data-toggle="dropdown">Action
  <span class="caret"></span></button>
  <ul class="dropdown-menu">

    <li><a style="cursor:pointer;" class="reject-modal"  data-title="Edit Member Basic Details" data-url="'.$edit_url.'">&nbsp;&nbsp;&nbsp;&nbsp;Edit Basic Details</a></li>
     <li><div class="dropdown-divider"></div></li>


    <li><a style="cursor:pointer;" class="reject-modal"  data-title="View Member Name" data-url="'.$view_url.'">&nbsp;&nbsp;&nbsp;&nbsp;View Details</a></li>
    
    </ul>
</div> 
';
            })->make(true);

    }
     public function ViewDetails($id)
     {
         $model=Member::find($id);
         $data['model']=$model;

            return view('usermanagement::members.view',$data);

     }

    public function generateMemberNumber($OrgID=false)
    {
        
        if($OrgID==false)
        {
          $OrgID=$this->OrgID;
        }
         

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

    public function EditDetails($id,Request $request)
    {
         if(Auth::user()->hasRole("Organization"))
         {
            $data['page_title']="Registered Entities";
              $organization=Organization::find($this->OrgID);
               
            $data['model']=$model=Member::find($id);
            $data['nodes']=NodeType::pluck('node_name','id')->toArray();
            $data['values']=ValueChain::where('id',$organization->value_chain_id)->pluck('value_name','id')->toArray();
            $data['url']=url()->current();
              if($request->isMethod("post"))
              {
                 $data=$request->all();
                  
                   $model->member_name=strtoupper($data['member_name']);
                   $model->member_email=$data['member_email'];
                   $model->id_number=$data['id_number'];
                   $model->member_telephone=$data['member_telephone'];
                   $model->value_chain_id=$data['value_chain_id'];
                   $model->node_id=$data['node_id'];
                   $model->gender=$data['gender'];
                   $model->updated_by=$this->userID;
                   $model->org_id=$this->OrgID;
                   $model->member_dob=date('Y-m-d',strtotime($data['member_dob']));
                   $model->location=$data['location'];
                   $model->save();
                     Session::flash("success_msg","Member Updated Successfully");

                      
                      return redirect('/System/MemberAccount/Index');
              
                   

              }

        return view('usermanagement::members.edit',$data);
    } else{
        return view("forbidden");
    }

    }

    public function EditMemberDetails($id,Request $request)
    {

        $data['model']=$model=Member::find($id);
        $data['url']=url()->current();
          if($request->isMethod("post"))
          {
             $data=$request->all();
              $model->member_name=$data['member_name'];
              $model->id_number=$data['id_number'];
              $model->member_telephone=$data['member_telephone'];
              $model->save();

             Session::flash("success_msg","Member Details Updated Successfully");
             return redirect()->back();
          }
        return view('usermanagement::members._editdetails',$data);

    }


    public function  GetMostRecentPosts()
    {

     
       $models=DB::select('SELECT products.id,vco_members.member_name,vco_members.member_number,member_telephone,value_name,`variety`,`quantity_available`,unit_name,format(`unit_price`,0)unit_price,products.updated_at FROM `products`
join value_chains on value_chains.id=products.value_chain_id
left join unit_of_measures on unit_of_measures.id=products.uom_id
left join vco_members on vco_members.id= products.member_id
WHERE products.org_id=?',[$this->OrgID]);

         foreach($models as $model)
         {
          echo '<tr><td>'.$model->updated_at.'</td>
                <td>'.$model->value_name.'</td>
                <td>'.$model->variety.'</td>
                <td>'.$model->quantity_available.'</td>
                <td>KES:'.$model->unit_price.'</td>
                <td>'.$model->member_name.'</td>
                <td>'.$model->member_telephone.'</td>

             </tr>';

         }

    }

    public function VCODashboard()
    {
       $models=DB::select('SELECT sum(isMale) as Male,Sum(IsFemale) as Female,Sum(isMale+ IsFemale) as total FROM vco_members WHERE org_id=?',[$this->OrgID]);
            if(sizeof($models)>0)
            {
              $male=$models[0]->Male;
              $female=$models[0]->Female;
              $total=$models[0]->total;
            }else{
              $male=0;
              $female=0;
              $total=0;

            }
            $male=Member::where(['gender'=>"Male",'org_id'=>$this->OrgID])->count();

             $female=Member::where(['gender'=>"Female",'org_id'=>$this->OrgID])->count();
             $total=$male+$female;
             $orders=Order::where(['org_id'=>$this->OrgID])->count();



            $data=array("Total"=>$total,"MyTotal"=>$male,"PendingApproval"=>$female,"Rejected"=>$orders);
            return $data;
    }


    public function  FetchMemberProducts()
    {
      $models=DB::select('SELECT products.id,vco_members.member_name,vco_members.member_number,member_telephone,value_name,variety,quantity_available,uom ,product_color,format(unit_price,0)unit_price,products.created_at FROM `products`
join value_chains on value_chains.id=products.value_chain_id
join vco_members on vco_members.id= products.member_id
WHERE products.org_id=?',[$this->OrgID]);

        return Datatables::of($models)
          ->rawColumns(['action'])
          ->addColumn('action', function ($model) {
              $edit_url=url('/System/Member/EditProduct/'.$model->id);
                        return '<div class="dropdown">
  <button class="btn btn-success btn-xs dropdown-toggle" type="button" data-toggle="dropdown">Action
  <span class="caret"></span></button>
  <ul class="dropdown-menu">
    <li><a style="cursor:pointer;"   title="Edit Quantities" href="'.$edit_url.'">&nbsp;&nbsp;&nbsp;&nbsp;Edit Quantities</a></li>
    
    </ul>
</div> 
';
            })->make(true);

    }

    public function fetchAdminProductList()
    {

       if(Auth::user()->hasRole(['SuperAdmin']))
       {
        $models=DB::select('SELECT products.id,uom,product_color,product_size,organizations.org_name,counties.county_name,  vco_members.member_number,vco_members.member_name,member_telephone, value_chains.value_name,variety,quantity_available,unit_price,products.created_at FROM products
left join vco_members on vco_members.id=products.member_id
left join value_chains  on value_chains.id=products.value_chain_id
left join organizations on organizations.id=vco_members.org_id
left join counties on counties.id=organizations.county_id where is_deleted is null
order by products.created_at desc limit ?',[1000]);

       }else{
        $models=DB::select('SELECT products.id,uom,product_color,product_size,organizations.org_name,counties.county_name,  vco_members.member_number,vco_members.member_name,member_telephone, value_chains.value_name,variety,quantity_available,unit_price,products.created_at FROM products
left join vco_members on vco_members.id=products.member_id
left join value_chains  on value_chains.id=products.value_chain_id
left join organizations on organizations.id=vco_members.org_id
left join counties on counties.id=organizations.county_id
 where organizations.county_id=? and is_deleted is null
order by products.created_at desc limit ?',[$this->OrgID,1000]);

       }

       

        return Datatables::of($models)
          ->rawColumns(['action'])
          ->addColumn('action', function ($model) {
              $edit_url=url('/System/Product/EditProductQuanity/'.$model->id);
                $edit_value_url=url('/System/Product/EditValueChain/'.$model->id);
                 $delete_url=url('/System/Product/DeleteProduct/'.$model->id);
                        return '<div class="dropdown">
  <button class="btn btn-success btn-xs dropdown-toggle" type="button" data-toggle="dropdown">Action
  <span class="caret"></span></button>
  <ul class="dropdown-menu">
    <li><a style="cursor:pointer;" class="reject-modal"    data-title="Edit Quantities" data-url="'.$edit_url.'">&nbsp;&nbsp;&nbsp;&nbsp;Edit Quantities</a></li>
     <li><div class="dropdown-divider"></div></li>

      <li><a style="cursor:pointer;" class="reject-modal"   data-title="Edit Value chain" data-url="'.$edit_value_url.'">&nbsp;&nbsp;&nbsp;&nbsp;Edit Value Chain</a></li>

       <li><div class="dropdown-divider"></div></li>

         <li><a style="cursor:pointer;" class="reject-modal"   data-title="Delete Product From PLatform" data-url="'.$delete_url.'">&nbsp;&nbsp;&nbsp;&nbsp;Delete Product</a></li>



    
    </ul>
</div> 
';
            })->make(true);

    }

    public function EditProductQuanity($id,Request $request)
    {
        $data['model']=$model=Product::find($id); 
          
       $data['units']=UnitOfMeasure::pluck('unit_name','unit_name')->toarray();
       $data['url']=url()->current();

         if($request->isMethod("post"))
         {
           $data=$request->all();
            try{
              $model->quantity_available=doubleval( str_replace(",", "",  $data['quantity_available']));
           $model->unit_price=doubleval( str_replace(",", "",  $data['unit_price'])) ;
           $model->uom=$data['uom'];
           $model->save();
           Session::flash("success_msg","Updated Succesfully");

            }catch(\Exception $e)
            {
              Session::flash("danger_msg","Error Occured while Processing your request.Error Code:".$e->getMessage());


            }
           

           return redirect()->back();

            
         }




       return view('usermanagement::products._editadminQuanty',$data);         

    }


    public function DeleteProduct($id,Request $request)
    {
      $data['model']=$model=Product::find($id); 
          
       $data['units']=UnitOfMeasure::pluck('unit_name','unit_name')->toarray();
       $data['url']=url()->current();

         if($request->isMethod("post"))
         {
           $data=$request->all();
            try{
              //$ordersDelete=DB::select("delete from orders where product_id=?",[$id]);
               $model->is_deleted=1;
               $model->deleted_by =Auth::User()->name;
               $model->deleted_at=date("Y-m-d H:i:s");
               $model->save();
               Session::flash("success_msg","Product Delete Succesfully");

            }catch(\Exception $e)
            {

              Session::flash("danger_msg","Error Occured while Processing your request.Error Code:".$e->getMessage());


            }
           

           return redirect()->back();

            
         }




       return view('usermanagement::products._deleteadminView',$data); 

    }


    public function EditProductValueChain($id,Request $request)
    {
       $data['model']=$model=Product::find($id); 
       $data['value_chains']=ValueChain::OrderBy('value_name','asc')->pluck('value_name','id')->toArray();
       $data['url']=url()->current();

         if($request->isMethod("post"))
         {
           $data=$request->all();
           $model->value_chain_id=$data['value_chain_id'];
           $model->save();
           Session::flash("success_msg","Updated Succesfully");

           return redirect()->back();

            
         }




       return view('usermanagement::products._editvaluechain',$data);         



    }


    public function EditProduct($id,Request $request)
    {
        if(Auth::user()->hasRole(["Organization","SuperAdmin","County-Cordinator"]))
         {
        $organization=Organization::find($this->OrgID);
         $data['values']=ValueChain::where('id',$organization->value_chain_id)->pluck('value_name','id')->toArray();
         $data['members']=Member::where(['org_id'=>$this->OrgID])->pluck('member_name','id')->toArray();
          $data['url']=url()->current();
          $data['model']=$model=Product::find($id);  
          $data['units']=UnitOfMeasure::pluck('unit_name','id')->toArray();
              if($request->isMethod("post"))
              {
                 $data=$request->all();
                 
                   $model=Product::where(['member_id'=>$data['member_id'],'value_chain_id'=>$data['value_chain_id']])->first();
                     if(!$model)
                     {
                       $model=new Product();
                        $model->org_id=$this->OrgID;
                   $model->member_id=$data['member_id'];
                   $model->value_chain_id=$data['value_chain_id'];
                     }
                  
                   $model->variety=$data['variety'];
                   $model->uom_id=$data['uom_id'];
                   $model->quantity_available=$data['quantity_available'];
                   $model->unit_price=$data['unit_price'];
                   $model->created_by=$this->userID;
                   $model->save();
                   
                Session::flash("success_msg","Product Updated Succesfully");
                return redirect('/System/MemberAccount/ProductList');
              }

           return view('usermanagement::products.edit',$data);
           }else{
        return view("forbidden");
    }

    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('usermanagement::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('usermanagement::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }
}
