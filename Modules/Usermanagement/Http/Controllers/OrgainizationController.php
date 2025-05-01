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
use Modules\Usermanagement\Entities\ValueChainOrganization;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Session;
use App\User;
use Auth;
use DB;
use Input;
use Validator;
use Redirect;
use App\Helpers\SystemAudit;
use Modules\Usermanagement\Entities\Profile;
use Excel;
use App\Helpers\Helper;
use App\Imports\OrganizationImport;
use Maatwebsite\Excel\Exceptions\NoTypeDetectedException;
class OrgainizationController extends Controller
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
        if(Auth::user()->can("Add Users") || Auth::user()->hasRole(["SuperAdmin","County Co-ordinator"]))
         {
            $data['page_title']="Registered Entities";
        return view('usermanagement::organizations.index',$data);
    } else{
        return view("forbidden");
    }
    }

    public function GetCountyList($id)
    {
       $models=Organization::where(['county_id'=>$id])->OrderBy('org_name','asc')->get();
          echo '<option value="">----Select Organization---</option>';
          foreach($models as $model)
          {
            echo '<option value="'.$model->id.'">'.$model->org_name.'</option>';
          }

    }

    public function Profile(Request $request)
    {
        if(Auth::user()->hasRole("Organization"))
         {
            $data['page_title']="VCO Profile";
            $data['counties']=County::pluck('county_name','id')->toArray();
             $data['subcounties']=SubCounty::pluck('sub_county_name','id')->toarray();
            $data['nodes']=NodeType::pluck('node_name','id')->toArray();
            $data['model']=$model=Organization::find($this->OrgID);
            $data['url']=url()->current();
              if($request->isMethod("post"))
              {
                  $this->validate($request,[
                    'org_name'=>'required',
                    'org_email'=>'required',
                    'contact_name'=>'required',
                    'org_tephone'=>'required',
                    'postal_address'=>'required'


                  ]);
                 $data=$request->all();
                    
                    $model->org_name=strtoupper($data['org_name']);
                    $model->org_email=$data['org_email'];
                    $model->date_registered=date('Y-m-d',strtotime($data['date_registered']));
                    $model->box_address=$data['box_address'];
                    $model->postal_address=$data['postal_address'];
                    $model->county_id=$data['county_id'];
                    $model->sub_county_id=$data['sub_county_id'];
                    $model->ward_name=$data['ward_name'];
                    $model->contact_name=$data['contact_name'];
                    $model->org_tephone=$data['org_tephone'];
                    $model->alt_telephone=$data['alt_telephone'];
                    $model->Status=1;
                    $model->landmark=$data['landmark'];
                    $model->physical_address=$data['physical_address'];
                    $model->save();
                    Session::flash("success_msg","Profile Updated Successfully");
                    return redirect('/home');
                  
              }

        return view('usermanagement::vcos.profile',$data);
    } else{
        return view("forbidden");
    }

    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create(Request $request)
    {
        
         if(Auth::user()->can("Add Users") || Auth::user()->hasRole(["SuperAdmin","County Co-ordinator"]))
         {
            $data['page_title']="Add New Organization";
            $data['model']=new Organization();
              if(Auth::User()->hasRole("County Co-ordinator"))
              {
                $data['county']=County::where('id',$this->OrgID)->pluck('county_name','id')->toArray();
                 $data['sub_counties']=SubCounty::where('county_id',$this->OrgID)->pluck('sub_county_name','id')->toarray();
              }else{

                 $data['county']=County::pluck('county_name','id')->toArray();
                  $data['sub_counties']=SubCounty::pluck('sub_county_name','id')->toarray();

              }
            
            
            $data['nodes']=NodeType::pluck('node_name','id')->toArray();
            $data['url']=url()->current();
              if($request->isMethod("post"))
              {
                  $this->validate($request,[
                    'org_email'=>'required|unique:organizations,org_email'


                  ]);
                  $data=$request->all();
                   $code=substr(number_format(time() * rand(),0,'',''),0,6);

                   DB::beginTransaction();
                    
                     $subCounty=SubCounty::find($data['sub_county_id']);
                      $node=NodeType::find($data['node_id']);
                      

                    $model=new Organization();
                    $model->org_name=strtoupper($data['org_name']);
                    $model->org_email=$data['org_email'];
                    $model->org_tephone=Helper::processNumber($data['org_tephone']);
                    $model->county_id=$data['county_id'];
                    $model->sub_county_id=$data['sub_county_id'];
                    $model->ward_name=$data['ward_name'];
                    $model->value_chain_id=$data['value_chain_id'];
                    $model->created_by=$this->userID;
                    $model->org_number=$this->createNumber();
                    $model->node_id=$data['node_id'];
                    $model->subcountyname=$subCounty->sub_county_name;
                    $model->nodename=$node->node_name;

                    $model->save();
                     $user=new User();
                     $user->name=$model->org_name;
                     $user->email=$model->org_email;
                     $user->phone=$model->org_tephone;
                     $user->org_id=$model->id;
                     $user->role_id=null;
                     $user->verification_code= $code;
                       $user->confirmed_at=date('Y-m-d H:i:s');
                       $user->user_status="Active";
                       $user->user_type="External";
                       $user->password=123456;
                       $user->save();
                       $text="Dear ".$user->name.",Your ASDSP Portal login details are:\n Email:".$user->email."\nPassword:123456";
                     $telephone=$user->phone;
                       try{
                         $test=Helper::send_sms($telephone,$text);

                     }catch(\Exception $e)
                     {

                     }
                       
                         
                        
                       $profile=new Profile();
                       $profile->user_id=$user->id;
                       $profile->telephone=$user->phone;
                       $profile->save();
                       $roles="Organization";
                       $user->assignRole($roles);
                       $user=Auth::user();
                         $description=$user->name."Added new Organization account for ".$model->org_number;
                           
         $client_ip=$request->ip();
        SystemAudit::CreateEvent($user,"Created",$description,"Major",$client_ip,"System Settings");
           DB::commit();
             Session::flash("success_msg",'Organization added Successfully');
             return redirect('/System/Entities/Index');



              }


        return view('usermanagement::organizations.create',$data);

        }else{
            return view("forbidden");
        }
    }

    public function fetchList()
    {
       if(Auth::User()->hasRole("County Co-ordinator"))
              {
                  $models=DB::select('SELECT organizations.id,org_name,org_email,`org_tephone`,`org_number`,`ward_name`,county_name,subcountyname,value_name,node_types.node_name,organizations.created_at FROM `organizations` 
left join counties on counties.id=organizations.county_id
left join sub_counties on sub_counties.id=organizations.sub_county_id
join value_chains on value_chains.id=organizations.value_chain_id
left JOIN node_types on node_types.id=organizations.node_id where organizations.county_id=? ',[$this->OrgID]);

              }else{
                  $models=DB::select('SELECT organizations.id,org_name,org_email,`org_tephone`,`org_number`,`ward_name`,county_name,subcountyname,value_name,node_types.node_name,organizations.created_at FROM `organizations` 
left join counties on counties.id=organizations.county_id
left join value_chains on value_chains.id=organizations.value_chain_id
left JOIN node_types on node_types.id=organizations.node_id');

              }
       
            return Datatables::of($models)
          ->rawColumns(['action'])
          ->addColumn('action', function ($model) {
              $edit_url=url('/System/Entities/EditDetails/'.$model->id);
              $value_url=url('/System/Entities/EditValue/'.$model->id);
               $node_url=url('/System/Entities/EditNode/'.$model->id);
                        return '<div class="dropdown">
  <button class="btn btn-success btn-xs dropdown-toggle" type="button" data-toggle="dropdown">Action
  <span class="caret"></span></button>
  <ul class="dropdown-menu">
    <li><a style="cursor:pointer;" class="reject-modal"  data-title="Edit Value Chain" data-url="'.$value_url.'">&nbsp;&nbsp; <i class="icol-font"></i>  Edit ValueChain</a></li>


        <li><a style="cursor:pointer;" class="reject-modal"  data-title="Edit Node Type" data-url="'.$node_url.'">&nbsp;&nbsp; <i class="icon-camera-retro"></i>Edit Primary Node</a></li>


     <li><a style="cursor:pointer;"  title="Edit" href="'.$edit_url.'">&nbsp;&nbsp;<i class="icon-pencil"></i>Edit Details</a></li>
    
    </ul>
</div> 
';
            })->make(true);

    }

    public function EditNode($id,Request $request)
    {
        $model=Organization::find($id);
       $data['model']=$model;
          $data['nodes']=NodeType::all();
            $data['url']=url()->current();
               if($request->isMethod("post"))
               {
                 $data=$request->all();

                    $node=NodeType::find($data['value_chain_id']);
                      if($node)
                      {
                         
                         $model->node_id=$node->id;
                         $model->nodename=$node->node_name;
                         $model->save();
                           $valueorg=ValueChainOrganization::where(['org_id'=>$model->id])->first();
                               if($valueorg)
                               {
                                 $valueorg->node_id= $model->node_id;
                                 $valueorg->save();
                               }else{
                                 $valueorg=new ValueChainOrganization();
                                 $valueorg->node_id=$model->node_id;
                                 $valueorg->org_id=$model->id;
                                 $valueorg->save();
                               }
                               Session::flash("success_msg","Node Added Successfully");
                               return redirect()->back();
                      }else{
                        Session::flash("danger_msg","Node Details Not Found");
                               return redirect()->back();

                      }
               }

              return view('usermanagement::organizations._editnode',$data);


    }


    public function EditValueChain($id,Request $request)
    {
      $model=Organization::find($id);
       $data['model']=$model;

       if(Auth::User()->hasRole("County Co-ordinator"))
             {
            
               $data['valuechains']=ValueChain::join('county_value_chains','county_value_chains.value_chain_id','=','value_chains.id')
               ->where(['county_id'=>$this->OrgID])
               ->select('value_name','value_chains.id')->get();

             }else{
             
               $data['valuechains']=ValueChain::select('value_name','value_chains.id')->get();
             }
             $data['url']=url()->current();
                if($request->isMethod("post"))
                {
                   $data=$request->all();
                     $model->value_chain_id=$data['value_chain_id'];
                     $model->save();
                     Session::flash("success_msg","Value Chain  Updated Successfully");
                     return redirect()->back();
                }

              return view('usermanagement::organizations._valuechain',$data);


    }

    public function createNumber()
    {
        $model=Organization::latest('id')->first();
          if($model)
          {
            $list=explode("/",$model->org_number );
             $number=$list[1];
              $number=$number+1;
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
                $number="VCO/".$number;

          
          }else{
            $number="VCO/0001";
          }

          return $number;
    }

    public function GetSubCounties($id)
    {
         $models=SubCounty::where(['county_id'=>$id])->get();
          echo '<option value="">---Select Sub County----</option>';
            foreach($models as $model)
            {
                 echo '<option value="'.$model->id.'">'.$model->sub_county_name.'</option>';
            }

    }
    public function EditDetails($id,Request $request)
      {

          if(Auth::user()->can("Add Users") || Auth::user()->hasRole(["SuperAdmin","County Co-ordinator"]))
         {
            $data['page_title']="Add New Organization";
            $data['model']=$model=Organization::find($id);
           
           if(Auth::User()->hasRole("County Co-ordinator"))
              {
                $data['county']=County::where('id',$this->OrgID)->pluck('county_name','id')->toArray();
                 $data['sub_counties']=SubCounty::where('county_id',$this->OrgID)->pluck('sub_county_name','id')->toarray();
              }else{

                 $data['county']=County::pluck('county_name','id')->toArray();
                  $data['sub_counties']=SubCounty::pluck('sub_county_name','id')->toarray();

              }
            
            
            $data['nodes']=NodeType::pluck('node_name','id')->toArray();
            $data['url']=url()->current();
              if($request->isMethod("post"))
              {
                  $data=$request->all();
                   $code=substr(number_format(time() * rand(),0,'',''),0,6);

                   DB::beginTransaction();
                    $model->org_name=strtoupper($data['org_name']);
                    $model->org_email=$data['org_email'];
                    $model->org_tephone=$data['org_tephone'];
                    $model->county_id=$data['county_id'];
                    $model->sub_county_id=$data['sub_county_id'];
                    $model->ward_name=$data['ward_name'];
                    $model->value_chain_id=$data['value_chain_id'];
                    $model->updated_by=$this->userID;
                    $model->node_id=$data['node_id'];
                    $model->save();
                   
                       
                       $user=Auth::user();
                         $description=$user->name."Update Organization Details for ".$model->org_number;
                           
         $client_ip=$request->ip();
        SystemAudit::CreateEvent($user,"Updated",$description,"Major",$client_ip,"System Settings");
           DB::commit();
             Session::flash("success_msg",'Organization added Successfully');
             return redirect('/System/Entities/Index');



              }


        return view('usermanagement::organizations.edit',$data);

        }else{
            return view("forbidden");
        }

      }

      public function Import(Request $request)
      {
           if(Auth::user()->can("Add Users") || Auth::user()->hasRole(["SuperAdmin","County Co-ordinator"]))
         {
            $data['page_title']="Import Organization";
           
             if(Auth::User()->hasRole("County Co-ordinator"))
             {
              $data['county']=County::where('id',$this->OrgID)->pluck('county_name','id')->toarray();
               $data['valuechains']=ValueChain::join('county_value_chains','county_value_chains.value_chain_id','=','value_chains.id')
               ->where(['county_id'=>$this->OrgID])
               ->pluck('value_name','value_chains.id')->toArray();

             }else{
              $data['county']=County::pluck('county_name','id')->toarray();
               $data['valuechains']=ValueChain::pluck('value_name','id')->toArray();
             }
            
            $data['model']=new Organization();

            

            
            $data['url']=url()->current();


              if($request->isMethod("post"))
              {
                ini_set('memory_limit', '-1');
                  $data=$request->all();


                  
                  $file_name=$data['file_name'];

                  try {
          
              $path1 = $file_name->store('temp'); 
$path=storage_path('app').'/'.$path1; 



    
                 $array=  Excel::toarray(new OrganizationImport, $path);

                 array_splice($array[0], 0, 1);
                    foreach($array as $rows)
                    {
                          #


                        $chunk_size = 50;
                   $big_array=$array[0];

                      
    foreach (array_chunk($rows, $chunk_size) as $data_chunk ) {


           foreach($rows as $row)
                        {
                            

                            
                             try{
                             
                            
                               
                                  
                      
                                
                                    
                                 
                               $subCount=$row[2];
                                    
                                  
                                  if(strlen($subCount)>0){
                                    $name=trim($row[1]);
                                    $ward_name=$row[3];
                                    $node=$row[4];
                                  $contact_name=$row[6];
                          
                             if(isset($rowp7))
                             {
                                 $contact_phone=trim($row[7]);
                                 
                           $contact_phone=str_replace(",", "",  $contact_phone);
                           $contact_phone=Helper::processNumber($contact_phone);
                            

                             }else{
                                 $contact_phone=null;
                             }
                       
                          $valueChain=trim($row[5]);




                            
                          
                          
                             

                          $subCount=trim( $subCount);
                           
                             
                           
                          $subCounty=SubCounty::where(['sub_county_name'=>$subCount])->first();

                             
                              if(!$subCounty)
                              {
                                $subCounty=new SubCounty();
                                $subCounty->county_id=$data['county_id'];
                                $subCounty->sub_county_name=strtoupper($subCount);
                                $subCounty->created_by=$this->userID;
                                $subCounty->save();
                                
                              } 
                         

                           
                            


                                       
                            
                            
                            $name=trim($name);


                            
                            $name=str_ireplace("’","",  $name);
                             $name=str_ireplace("-","",  $name);

                             
                            $contact_name=str_replace("-", "", $contact_name);
                              $contact_name=str_replace("’", "", $contact_name);
                              
                                  
                                $model=Organization::where(['org_name'=>$name,'county_id'=>$data['county_id']])->first();
                                $nodemodel=NodeType::where(['node_name'=>$node])->first();

                                    
                                 $valueChainModel=ValueChain::where(['value_name'=>$valueChain])->where('value_name','like','%'.$valueChain.'%')->first();
                                 

                                    


                                  
                                
                                 
                                   DB::beginTransaction();
                                  if(!$model)
                                  {
                                   
                    $model=new Organization();
                    $model->org_name=strval(strtoupper($name))   ;
                    $model->org_email=null;
                    $model->contact_name=strval(strtoupper($contact_name))  ;
                    $model->org_tephone=Helper::processNumber($contact_phone);
                   
                    $model->county_id=$data['county_id'];
                    $model->sub_county_id= $subCounty->id;
                    $model->subcountyname=$subCount;

                    $model->value_chain_id=($valueChainModel)?$valueChainModel->id:$data['value_id'];
                    $model->created_by=$this->userID;
                    $model->nodename=strtoupper($node);
                    $model->org_number=$this->createNumber();
                    
                    $model->org_email=strtolower($model->org_number."@demo.asdsp.go.ke");
                     //$model->org_email=$row[4];
                    $model->node_id=($nodemodel)?$nodemodel->id:null;
                    $model->ward_name=$ward_name;
                    $model->save();
                     
                    $user=User::where(['email'=>$model->org_email,'org_id'=>$model->id])->first();
                              if(!$user)
                              {
                             $user=new User();
                             $user->name=$model->org_name;
                             $user->email=$model->org_email;
                             $user->phone=$model->org_tephone;
                             $user->org_id=$model->id;
                             $user->role_id=null;
                             $user->verification_code= substr(number_format(time() * rand(),0,'',''),0,12);;
                               $user->confirmed_at=date('Y-m-d H:i:s');
                               $user->user_status="Active";
                               $user->user_type="Internal";
                               $user->password=123456;
                               $user->save();
                                $profile=new Profile();
                               $profile->user_id=$user->id;
                               $profile->telephone=$user->phone;
                               $profile->save();
                               $roles="Organization";
                               $user->assignRole($roles);


                              }


                      

                                  }
                                   



                                      
                        



                        $node =trim($node) ;
                              
                              $nodes=explode('/', $node);

                              
                                  if(is_array($nodes))
                                  {

                                      foreach($nodes as $node)
                                      {
                                       $node=trim($node);


                                        $nodemodel=NodeType::where('node_name','like','%'.$node.'%')->first();
                                         if(!$nodemodel)
                                          {
                                            $nodemodel=new NodeType();
                                            $nodemodel->node_name=$node;
                                            $nodemodel->save();
                                          }

                                          $modelnodel=ValueChainOrganization::where(['org_id'=>$model->id,'node_id'=>$model->node_id])->first();
                                      if(!$modelnodel)
                                      {
                                  $modelnodel=new ValueChainOrganization();
                                  $modelnodel->org_id=$model->id;
                                  $modelnodel->node_id=$nodemodel->id;
                                  $modelnodel->save();


                                      }


                                      }
                                    
                                  }





                                 
                                   
                                   DB::commit();

                                  }
                          

                             }catch(\Exception $e)
                             {
                               
                             }
                          
                         
                         


                             
                        }
        



    }

                       
                     
                        
                    }
                     Session::flash("success_msg",'Organization added Successfully');
             return redirect('/System/Entities/Index');

                    
                   
} catch (NoTypeDetectedException $e) {
     
    flash("Sorry you are using a wrong format to upload files.")->error();
    return Redirect::back();
}

                    
                
                 
        


              }


        return view('usermanagement::organizations.import',$data);

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
