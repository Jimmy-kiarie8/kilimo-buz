<?php

namespace Modules\Usermanagement\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller ;
use Modules\Usermanagement\Entities\Department;
use Modules\Usermanagement\Entities\Ministry;
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
use Modules\Library\Entities\Book;
use Modules\Library\Entities\Publisher;
use Modules\Library\Entities\Library;
use Validator;
use Redirect;

class MinistryController extends Controller
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

    public function index()
    {
         
         if(Auth::user()->can("Add Users") || Auth::user()->hasRole("SuperAdmin"))
         {
            $data['page_title']="Ministries";

        return view('usermanagement::ministries.index',$data);

    }else{
        return view("forbidden");
    }
    }

    public function  fetchList()
    {
         $models=Ministry::all();
           return Datatables::of($models)
          ->rawColumns(['action'])
          ->addColumn('action', function ($model) {
              $edit_url=url('/System/Ministries/EditDetails/'.$model->id);
                        return '<div class="dropdown">
  <button class="btn btn-info btn-xs dropdown-toggle" type="button" data-toggle="dropdown">Action
  <span class="caret"></span></button>
  <ul class="dropdown-menu">
    <li><a style="cursor:pointer;" class="reject-modal"  data-title="Edit Ministry Name" data-url="'.$edit_url.'">&nbsp;&nbsp;&nbsp;&nbsp;Edit Details</a></li>
    
    </ul>
</div> 
';
            })->make(true);

    }

    public function create(Request $request)
    {
         if(Auth::user()->can("Add Users") || Auth::user()->hasRole("SuperAdmin"))
         {
            $data['page_title']="Counties";
            $data['url']=url()->current();
            $data['model']=new Ministry();
               if($request->isMethod("post"))
               { $this->validate($request,[
                 'ministry_name'=>'required|unique:ministries'
               ]);
                 $data=$request->all();
                  $model=new Ministry();
                  $model->ministry_name=$data['ministry_name'];
                  $model->created_by =$this->userID;
                  $model->save();
                  Session::flash("success_msg","Ministry Added Successfully");
                  return redirect()->back();
                  
               }

        return view('usermanagement::ministries.create',$data);

    }else{
        return view("forbidden");
    }
    }

    public function EditDetails($id,Request $request)
    {
           if(Auth::user()->can("Add Users") || Auth::user()->hasRole("SuperAdmin"))
         {
            $data['page_title']="Department";
            $data['url']=url()->current();
            $data['model']=$model=Ministry::find($id);
               if($request->isMethod("post"))
               {
                 $data=$request->all();
                  
                  $model->ministry_name=$data['ministry_name'];
                  $model->updated_by =$this->userID;
                  $model->save();
                  Session::flash("success_msg","Ministry  Updated Successfully");
                  return redirect()->back();
                  
               }

        return view('usermanagement::ministries.create',$data);

    }else{
        return  "Aces Denied";
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
