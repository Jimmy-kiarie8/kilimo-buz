<?php

namespace Modules\Usermanagement\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller ;
use Modules\Usermanagement\Entities\Department;
use Modules\Usermanagement\Entities\Designition;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Session;
use App\User;
use Auth;
use DB;


class DesignitionController extends Controller
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
            $data['page_title']="Designitions";

        return view('usermanagement::designitions.index',$data);

    }else{
        return view("forbidden");
    }
    }

    public function  fetchList()
    {
         $models=Designition::all();
           return Datatables::of($models)
          ->rawColumns(['action'])
          ->addColumn('action', function ($model) {
              $edit_url=url('/System/Designitions/EditDetails/'.$model->id);
                        return '<div class="dropdown">
  <button class="btn btn-info btn-xs dropdown-toggle" type="button" data-toggle="dropdown">Action
  <span class="caret"></span></button>
  <ul class="dropdown-menu">
    <li><a style="cursor:pointer;" class="reject-modal"  data-title="Edit Designtion Name" data-url="'.$edit_url.'">&nbsp;&nbsp;&nbsp;&nbsp;Edit Details</a></li>
    
    </ul>
</div> 
';
            })->make(true);

    }

    public function create(Request $request)
    {
         if(Auth::user()->can("Add Users") || Auth::user()->hasRole("SuperAdmin"))
         {
            $data['page_title']="Designitions";
            $data['url']=url()->current();
            $data['model']=new Designition();
               if($request->isMethod("post"))
               { $this->validate($request,[
                 'designition_name'=>'required|unique:designitions'
               ]);
                 $data=$request->all();
                  $model=new Designition();
                  $model->designition_name=$data['designition_name'];
                  $model->created_by =$this->userID;
                  $model->save();
                  Session::flash("success_msg","Designition Added Successfully");
                  return redirect()->back();
                  
               }

        return view('usermanagement::designitions.create',$data);

    }else{
        return view("forbidden");
    }
    }

    public function EditDetails($id,Request $request)
    {
           if(Auth::user()->can("Add Users") || Auth::user()->hasRole("SuperAdmin"))
         {
            $data['page_title']="Designitions";
            $data['url']=url()->current();
            $data['model']=$model=Designition::find($id);
               if($request->isMethod("post"))
               {
                 $data=$request->all();
                  
                  $model->designition_name=$data['designition_name'];
                  $model->updated_by =$this->userID;
                  $model->save();
                  Session::flash("success_msg","Designition  Updated Successfully");
                  return redirect()->back();
                  
               }

        return view('usermanagement::designitions.create',$data);

    }else{
        return  "Access Denied";
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
