<?php

namespace Modules\Usermanagement\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller ;
use Modules\Usermanagement\Entities\Department;
use Modules\Usermanagement\Entities\County;
use Modules\Usermanagement\Entities\ValueChain;
use Modules\Usermanagement\Entities\NodeType;
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

class NodeTypeController extends Controller
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
          
         if(Auth::user()->can("Add Users") || Auth::user()->hasRole("SuperAdmin"))
         {
            $data['page_title']="Nodes";

        return view('usermanagement::nodes.index',$data);

    }else{
        return view("forbidden");
    }
    }

    public function fetchList()
    {
         $models=NodeType::orderBy('created_at','desc');
            return Datatables::of($models)
          ->rawColumns(['action'])
          ->addColumn('action', function ($model) {
              $edit_url=url('/System/NodeTypes/EditDetails/'.$model->id);
                        return '<div class="dropdown">
  <button class="btn btn-success btn-xs dropdown-toggle" type="button" data-toggle="dropdown">Action
  <span class="caret"></span></button>
  <ul class="dropdown-menu">
    <li><a style="cursor:pointer;" class="reject-modal"  data-title="Edit Node Name" data-url="'.$edit_url.'">&nbsp;&nbsp;&nbsp;&nbsp;Edit Details</a></li>
    
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
          
         if(Auth::user()->can("Add Users") || Auth::user()->hasRole("SuperAdmin"))
         {
            $data['page_title']="Nodes";
             $data['model']=new NodeType();
             $data['url']=url()->current();
              if($request->isMethod("post"))
              {
                 $data=$request->all();
                  $this->validate($request,[
                 'node_name'=>'unique:node_types'
                  ]);
                  $model=new NodeType();
                   $model->node_name=$data['node_name'];
                   $model->save();
                   Session::flash("success_msg","Node Added Succesfuuly");
                   return redirect()->back();
                
              }

        return view('usermanagement::nodes.create',$data);

    }else{
        return view("forbidden");
    }
    }

    public function EditDetails($id,Request $request)
    {
          if(Auth::user()->can("Add Users") || Auth::user()->hasRole("SuperAdmin"))
         {
            $data['page_title']="Nodes";
             $data['model']=$model=NodeType::find($id);
             $data['url']=url()->current();

              if($request->isMethod("post"))
              {
                 $data=$request->all();
                  $this->validate($request,[
                 'node_name'=>'required'
                  ]);
                 
                   $model->node_name=$data['node_name'];
                   $model->save();
                   Session::flash("success_msg","Node Updated Succesfuuly");
                   return redirect()->back();
                
              }

        return view('usermanagement::nodes.create',$data);

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
