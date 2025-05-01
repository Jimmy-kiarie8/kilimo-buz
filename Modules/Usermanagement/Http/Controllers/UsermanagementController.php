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
use Modules\Usermanagement\Entities\Permission;
use Modules\Library\Entities\Book;
use Modules\Library\Entities\Publisher;
use Validator;
use Redirect;

class UsermanagementController extends Controller
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
        if(Auth::User()->hasRole("SuperAdmin") || Auth::User()->can(['add Book Category']))
         {
            $data['page_title']="System Roles";

             return view('usermanagement::roles.index',$data);
         }else{
            return view("forbidden");
         }
    }

    public function Permissions()
    {
         if(Auth::User()->hasRole("SuperAdmin") || Auth::User()->can(['add Book Category']))
         {
            $data['page_title']="System Permissions";

             return view('usermanagement::roles._index',$data);
         }else{
            return view("forbidden");
         }

    }

    public function fetchList()
    {
        $models=Role::all();
          return Datatables::of($models)
          ->rawColumns(['action'])
          ->addColumn('action', function ($model) {
              $edit_url=url('/System/Role/EditDetails/'.$model->id);
                 $delete=url('/System/Role/Delete/'.$model->id);
            $index_url=url('/System/Roles/Index');
            $view_url=url('/System/Role/ViewPermission/'.$model->id);
            $view_user_url=url('/System/Role/ViewRoleUser/'.$model->id);
        return '<div class="dropdown">
  <button class="btn btn-info btn-xs dropdown-toggle" type="button" data-toggle="dropdown">Action
  <span class="caret"></span></button>
  <ul class="dropdown-menu">
    <li><a style="cursor:pointer;"  title="Edit Role Details" href="'.$edit_url.'">&nbsp;&nbsp;&nbsp;&nbsp;Edit Details</a></li>
    <li><div class="dropdown-divider"></div></li>
    <li><a style="cursor:pointer;"  class="reject-modal" data-title="View Role Permissions" data-url="'.$view_url.'">&nbsp;&nbsp;&nbsp;&nbsp;View Permissions</a></li>
     <li><div class="dropdown-divider"></div></li>
     <li><a style="cursor:pointer;"  class="reject-modal" data-title="View User With This Role" data-url="'.$view_user_url.'">&nbsp;&nbsp;&nbsp;&nbsp;View Role Users</a></li>
    <li><div class="dropdown-divider"></div></li>
    <li><a  style="cursor:pointer;" data-name="Role" data-redirect-to="'.$index_url.'" class="delete-record"  data-url="'.$delete.'" >&nbsp;&nbsp;&nbsp;&nbsp;Delete</a></li>
    </ul>
</div> 
';
            })->make(true);
    }

    public function fetchPemissions()
    {
        $models=Permission::all();
         return Datatables::of($models)->make(true);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create(Request $request)
    {
        if(Auth::user()->can("Create Role") || Auth::user()->hasRole("SuperAdmin"))
         {
              $categories=Permission::select('perm_category')->distinct()->orderBy('perm_category')->get();
               $data['model']=new Role();
               $data['permission']=new Permission();
                $data['url']=url()->current();
                $data['permissions']=$categories;


                  if($request->isMethod("post"))
                  {
                     $this->validate($request,[
                      'name'=>'required|string|unique:roles,name',
                      'description'=>'required|string',
                     ]);
                    DB::beginTransaction();
                     $data=$request->all();
                       
                     $role = Role::create(['name' =>$data['name'],'description'=>$data['description']]);
                      if($role)
                      {
                          if(isset($data['permission']))
                          {
                           $permissions=$data['permission'];
                        
                       $perm= $role->syncPermissions($permissions); 
                          }else{
                            $role->givePermissionTo("View User Dashboard");
                          }
                        
                         DB::commit();
                         Session::flash("success_msg","Role Created Successfully");
                      }else{
                        DB::rollback();
                     Session::flash("danger_msg","Role Not Created Successfully");
                      }
                     
                     return redirect("/System/Roles/Index");
                  }
                  





               return view('usermanagement::roles.create',$data);  
         }else{
            return view("forbidden");
         }
       
    }

    public function EditDetails($id,Request $request)
    {
          if(Auth::user()->can("Create Role") || Auth::user()->hasRole("SuperAdmin"))
         {
              $categories=Permission::select('perm_category')->distinct()->orderBy('perm_category')->get();
               $data['model']=$model=Role::find($id);
                 if(!$model)
                 {
                    return view("not_found");
                 }
                 $permissions=$model->getAllPermissions();
                   $per_id=array();
                    foreach($permissions as $perm)
                    {
                      $per_id[]=$perm->id;  
                    }
                     
                $data['page_title']="Edit Role";
               $data['permission']=new Permission();
                $data['url']=url()->current();
                $data['permissions']=$categories;
                $data['ids']=$per_id;

                  if($request->isMethod("post"))
                  {
                     $this->validate($request,[
                      'name'=>'required|string',
                      'description'=>'required|string',
                     ]);
                    DB::beginTransaction();
                     $data=$request->all();
                       
                     $role =$model;;
                      if($role)
                      {
                         $role->name=$data['name'];
                         $role->description=$data['description'];
                         $role->save();
                          if(isset($data['permission']))
                          {
                           $permissions=$data['permission'];
                        
                       $perm= $role->syncPermissions($permissions); 
                          }else{
                            $role->givePermissionTo("View User Dashboard");
                          }
                        
                         DB::commit();
                         Session::flash("success_msg","Role Updated Successfully");
                      }else{
                        DB::rollback();
                     Session::flash("danger_msg","Role Not Updated Successfully");
                      }
                     
                     return redirect("/System/Roles/Index");
                  }
            return view('usermanagement::roles._create',$data);  
         }else{
            return view("forbidden");
         }

    }

    public function ViewPermission($id)
    {
         $model=Role::find($id);
        $models=   $model->getAllPermissions();
       $data['models']=$models;
       return view('usermanagement::roles.view_perms',$data);  

    }

    public function ViewRoleUser($id)
    {
          $users = User::role($id)->get();
        $data['models']=$users;
          if(sizeof($users)==0)
          {
            return "No Users Assigned This Role";
          }

       return view('usermanagement::roles.view_users',$data);

    }

    public function Delete($id)
    {
        try{
            $model=Role::find($id);
             if($model->name=="SuperAdmin")
             {
                Session::flash("danger_msg","You cannot Delete Super admin Role.Please Contact System Administrator For more Information");
             }else{
               $permission= $model->getAllPermissions();
                $model->revokePermissionTo($permission);
                $model->delete();

                Session::flash("success_msg","Role Deleted Successfully");
             }


        }catch(\Exception $e)
        {
            Session::flash("danger_msg",$e);
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
