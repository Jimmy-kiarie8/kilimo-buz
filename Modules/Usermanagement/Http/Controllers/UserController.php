<?php

namespace Modules\Usermanagement\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller ;
use Modules\Usermanagement\Entities\Department;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Session;
use App\User;
use Auth;
use DB;
use Input;
use Modules\Usermanagement\Entities\Role;
use Modules\Usermanagement\Entities\Profile;
use Modules\Usermanagement\Entities\Permission;
use Validator;
use Redirect;
use App\Helpers\SystemAudit;
use App\Helpers\Helper;
use Modules\Usermanagement\Entities\Staff;
use Modules\Usermanagement\Entities\County;
use Modules\Usermanagement\Entities\NodeType;

class UserController extends Controller
{

     protected $userID;
    protected $mid;
    protected $sid;
  public function __construct()
    {
       $this->middleware('auth');
        
       
        $this->middleware(function ($request, $next) {
            $this->userID = Auth::user()->id;
            $this->sid=Auth::user()->org_id;

            return $next($request);
        });
    }


    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
         if(Auth::user()->can("Add Users") || Auth::user()->hasRole("SuperAdmin") || Auth::user()->hasRole("County Co-ordinator") )
         {
            $data['page_title']="System Users";
               if(Auth::User()->hasRole("County Co-ordinator"))
               {
                 return view('usermanagement::users.countyindex',$data);
               }

        return view('usermanagement::users.index',$data);

    }else{
        return view("forbidden");
    }
    }

    public function GetOtherDetails(Request $request)
    {
        $data=$request->all();
        $no=$data['PNo'];
        $model=Staff::where(['personal_number'=>$no])->first();
         if($model)
         {
             $user=$model->user;
              $payload=array('Id'=>$user->id,
                        'Name'=>$user->name,'Email'=>$user->email,'username'=>$user->username,
                  'phone'=>$model->telephone,
                  'Gender'=>$model->gender,
              );
              return $payload;
         }else{
            return 0;
         }


    }
    public function fetchCountyList()
    {
           $list=array("County Co-ordinator","SuperAdmin");
        $models=DB::select(' select users.id,county_name,users.name,node_name,email,username,phone,user_type,user_status,profiles.id_number,gender,county,country,users.created_at,roles.name as user_role,profiles.personal_number,users.lastlogindate from users
  left join profiles on profiles.user_id=users.id
  join  model_has_roles on model_has_roles.model_id=users.id
  join counties on counties.id=users.org_id
  join roles on roles.id=model_has_roles.role_id
  left join node_types on  node_types.id=users.branch_id
  where  org_id=? and (roles.name="County Co-ordinator" or roles.name="Service Provider")',[$this->sid]);
         return Datatables::of($models)
          ->rawColumns(['action'])
          ->addColumn('action', function ($model) {
             $edit_url=url('/System/User/Edit/'.$model->id);
                 $delete=url('/System/Role/Delete/'.$model->id);
            $index_url=url('/System/Roles/Index');
            $view_url=url('/System/Users/ViewPermission/'.$model->id);
            $edit_d_url=url('/Admin/User/EditDepartment/'.$model->id);
            $view_user_url=url('/System/Users/ViewRoleUser/'.$model->id);
             $password_url=url('/System/Users/ResetPassword/'.$model->id);
              
        return '<div class="dropdown">
  <button class="btn btn-success btn-xs dropdown-toggle" type="button" data-toggle="dropdown">Action
  <span class="caret"></span></button>
  <ul class="dropdown-menu">
     <li><a style="cursor:pointer;"  class="reject-modal" data-title="User Password Reset" data-url="'.$password_url.'">&nbsp;&nbsp;&nbsp;&nbsp;Reset Password</a></li>
     <li><div class="dropdown-divider"></div></li>
    <li><a style="cursor:pointer;"  title="Edit Role Details" href="'.$edit_url.'">&nbsp;&nbsp;&nbsp;&nbsp;Edit Details</a></li>
    <li><div class="dropdown-divider"></div></li>
      <li><a style="cursor:pointer;"  class="reject-modal" data-title="View Permissions Assigned" data-url="'.$view_url.'">&nbsp;&nbsp;&nbsp;&nbsp;Permissions Assigned</a></li>
      <li><div class="dropdown-divider"></div></li>
    <li><a style="cursor:pointer;"  class="reject-modal" data-title="View Groups/Roles Assigned To User" data-url="'.$view_user_url.'"> &nbsp;&nbsp;&nbsp;&nbsp;User Roles</a></li>
   
    </ul>
</div> 
';
            })->make(true);


    }
    public function EditCountyDetails($id,Request $request)
    {
         $user=User::find($id);
           $data['user']=$model=$user;
           $data['url']=url()->current();
           $data['models']=County::all();
              if($request->isMethod("post"))
              {
                  $data=$request->all();
                    $model->org_id=$data['org_id'];
                    $model->save();
                    Session::flash("success_msg","User Details Updated");
                    return redirect()->back();
              }

           
             return view('usermanagement::users._editcounty',$data);
            

    }

    public function fetchUsers()
    {
         $list=array("County Co-ordinator","SuperAdmin");
        $models=DB::select(' select users.id,county_name,users.name,email,username,phone,user_type,user_status,profiles.id_number,gender,county,country,users.created_at,roles.name as user_role,profiles.personal_number,users.lastlogindate from users
  left join profiles on profiles.user_id=users.id
  join  model_has_roles on model_has_roles.model_id=users.id
  join counties on counties.id=users.org_id
  join roles on roles.id=model_has_roles.role_id
  where roles.name=? or  roles.name=? or  roles.name=?',['County Co-ordinator',"SuperAdmin","Service Provider"]);
         return Datatables::of($models)
          ->rawColumns(['action'])
          ->addColumn('action', function ($model) {
             $edit_url=url('/System/User/Edit/'.$model->id);
                 $delete=url('/System/Role/Delete/'.$model->id);
            $index_url=url('/System/Roles/Index');
            $view_url=url('/System/Users/ViewPermission/'.$model->id);
            $edit_d_url=url('/System/User/EditCounty/'.$model->id);
            $view_user_url=url('/System/Users/ViewRoleUser/'.$model->id);
             $password_url=url('/System/Users/ResetPassword/'.$model->id);
              
        return '<div class="dropdown">
  <button class="btn btn-success btn-xs dropdown-toggle" type="button" data-toggle="dropdown">Action
  <span class="caret"></span></button>
  <ul class="dropdown-menu">
     <li><a style="cursor:pointer;"  class="reject-modal" data-title="User Password Reset" data-url="'.$password_url.'">&nbsp;&nbsp;&nbsp;&nbsp;Reset Password</a></li>
     <li><div class="dropdown-divider"></div></li>
    <li><a style="cursor:pointer;"  title="Edit Role Details" href="'.$edit_url.'">&nbsp;&nbsp;&nbsp;&nbsp;Edit Details</a></li>
    <li><div class="dropdown-divider"></div></li>
      <li><a style="cursor:pointer;"  class="reject-modal" data-title="View Permissions Assigned" data-url="'.$view_url.'">&nbsp;&nbsp;&nbsp;&nbsp;Permissions Assigned</a></li>

      <li><a style="cursor:pointer;"  class="reject-modal" data-title="Edit Station/County Details" data-url="'.$edit_d_url.'">&nbsp;&nbsp;&nbsp;&nbsp;Edit County/Sation</a></li>
      <li><div class="dropdown-divider"></div></li>
    <li><a style="cursor:pointer;"  class="reject-modal" data-title="View Groups/Roles Assigned To User" data-url="'.$view_user_url.'"> &nbsp;&nbsp;&nbsp;&nbsp;User Roles</a></li>
   
    <li><div class="dropdown-divider"></div></li>
    <li><a  style="cursor:pointer;" data-name="Role" data-redirect-to="'.$index_url.'" class="delete-record"  data-url="'.$delete.'" >&nbsp;&nbsp;&nbsp;&nbsp;Delete</a></li>
    </ul>
</div> 
';
            })->make(true);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create(Request $request)
    {

          if(Auth::user()->can("Add Users") || Auth::user()->hasRole("SuperAdmin") || Auth::user()->hasRole("County Co-ordinator")   )
         {
            $data['page_title']="Create Users";
            $data['model']=new User();
              if(Auth::User()->hasRole("County Co-ordinator"))
              {
                 $data['roles']=Role::where('name','Service Provider')->pluck('name','name')->toArray();
                  $data['counties']=County::where('id',$this->sid)->pluck('county_name','id')->toArray();
                   $data['nodes']=NodeType::pluck('node_name','id')->toArray();

                
             }else{
                 $data['roles']=Role::pluck('name','name')->toArray();
                  $data['counties']=County::pluck('county_name','id')->toArray();
                  $data['nodes']=NodeType::pluck('node_name','id')->toArray();
             }
           
            $data['url']=url()->current();
           


             if($request->isMethod("post"))
             {

                $data=$request->all();
                  

                $this->validate($request,[
               
               'email'=>'required|email|unique:users,email',
               'password'=>'required|min:6|max:10|confirmed',
               'name'=>'required|string'
                ]);
                 

                DB::beginTransaction();
                 $user=new User();
                 $user->name=$data['name'];
                 $user->email=$data['email'];
                 $user->phone=$data['telephone'];
                 $user->password=$data['password'];
                 $user->confirmed_at=date('Y-m-d H:i:s');
                 $user->verification_code=str_random(7);
                   if($data['role_id']=="County Co-ordinator")
                   {
                     $user->org_id=$data['county_id'];
                 }else{
                     $user->org_id=$this->sid;
                 }
                
                 $user->role_id=$data['role_id'];
                 $user->username=$data['email'];
                 $user->user_type="Internal";
                   if(isset($data['node_id']))
                   {
                    $user->branch_id=$data['node_id'];
                     $user->org_id=$this->sid;
                   }
               
                 $user->save();

                 
                 $profile=new Profile();
                 $profile->user_id=$user->id;
                 $profile->telephone=$data['telephone'];
                
                 $profile->save();
                 $text="Dear ".$user->name.",Your ASDSP AGRIBUZ Login are \nusername:".$user->email."\n Password: 123456\n url:https://asdspmarketinfo.kilimo.go.ke/login";
                  $telephone=$user->phone;
                     try{
                         $test=Helper::send_sms($telephone,$text);

                     }catch(\Exception $e)
                     {

                     }
                    
                      
                 $roles=$data['role_id'];
                 $user->assignRole($roles);
               $usermodel=Auth::user();
               $event_name="Created";
               $description=$usermodel->name.",created account for ".$user->name." and assigned  role ".$roles;
               $severity="Critical";
               $ip=$request->ip();
                 SystemAudit::CreateEvent($usermodel,$event_name, $description, $severity,$ip,"User Management");
                 DB::commit();
                 Session::flash("success_msg","User Account Created Successfully");
                 return redirect("/System/Users/Index");

             }
              if(Auth::User()->hasRole("County Co-ordinator"))
              {
                 return view('usermanagement::users.countycreate',$data);

              }else{
                 return view('usermanagement::users.create',$data);
              }


        
    }else{
        return view("forbidden");
    }
        
    }

    public function PasswordReset($id,Request $request)
{
    
         if(Auth::user()->can("Reset User Passwords") || Auth::user()->hasRole("SuperAdmin"))
         {
             $user=User::find($id);
            $data['url']=url()->current();
             $data['user']=$user;
               if($request->isMethod("post"))
               {
                 $this->validate($request,[
                    'password'=>'required|min:6|confirmed',

                 ]);
                $data=$request->all();
                $user->password=$data['password'];
                $user->save();
                Session::flash("success_msg","User Password Updated Successfully");
                return redirect()->back();
            }
        return view('usermanagement::users.password',$data);
    }else{
        return view("forbidden");
    }

}

public function ViewPermission($id)
    {
        $user=User::find($id);
         if(!$user)
         {
            return "User Details Not Found";
         }
         $models=$user->getAllPermissions();
          $data['models']=$models;

          return view('usermanagement::users.permissions',$data);

    }


     public function ViewRoleUser($id)
    {
         $user=User::find($id);
         if(!$user)
         {
            return "User Details Not Found";
         }
         $models=$user->getRoleNames();

          $data['models']=$models;
          return view('usermanagement::users.roles',$data);

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
