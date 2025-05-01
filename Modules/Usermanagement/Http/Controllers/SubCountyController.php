<?php

namespace Modules\Usermanagement\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller ;
use Modules\Usermanagement\Entities\Department;
use Modules\Usermanagement\Entities\County;
use Modules\Usermanagement\Entities\SubCounty;
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
use Validator;
use Redirect;

class SubCountyController extends Controller
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
         
         if(Auth::user()->can("Add Users") || Auth::user()->hasRole(["SuperAdmin","County Co-ordinator"]))
         {
            $data['page_title']="Sub Counties";

        return view('usermanagement::sub_counties.index',$data);

    }else{
        return view("forbidden");
    }
    }

    public function  fetchList()
    {
        if(Auth::User()->hasRole("County Co-ordinator"))
        {
           $models=SubCounty::join('counties','counties.id','=','subcounties.county_id')->select('subcounties.id','subcounties.created_at','sub_county_name','county_name')
           ->where(['subcounties.county_id'=>$this->sid]);

        }else{
           $models=SubCounty::join('counties','counties.id','=','subcounties.county_id')->select('subcounties.id','subcounties.created_at','sub_county_name','county_name');
        }
        
           return Datatables::of($models)
          ->rawColumns(['action'])
          ->addColumn('action', function ($model) {
              $edit_url=url('/System/SubCounties/EditDetails/'.$model->id);
                        return '<div class="dropdown">
  <button class="btn btn-success btn-xs dropdown-toggle" type="button" data-toggle="dropdown">Action
  <span class="caret"></span></button>
  <ul class="dropdown-menu">
    <li><a style="cursor:pointer;" class="reject-modal"  data-title="Edit Sub County Name" data-url="'.$edit_url.'">&nbsp;&nbsp;&nbsp;&nbsp;Edit Details</a></li>
    
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
         if(Auth::user()->can("Add Users") || Auth::user()->hasRole(["SuperAdmin","County Co-ordinator"]))
         {
            $data['page_title']="Counties";
            $data['url']=url()->current();

            $data['model']=new SubCounty();
              if(Auth::User()->hasRole("County Co-ordinator"))
              {
                  $data['models']=County::where(['id'=>$this->sid])->get();

              }else{
                  $data['models']=County::all();
              }
          
               if($request->isMethod("post"))
               {
                 $this->validate($request,[
                 'sub_county_name'=>'required|unique:subcounties'
               ]);
                 $data=$request->all();

                  $model=new SubCounty();
                   $model->county_id=$data['county_id'];
                  $model->sub_county_name=$data['sub_county_name'];
                  $model->created_by =$this->userID;
                  $model->save();
                  Session::flash("success_msg","Sub County Added Successfully");
                  return redirect()->back();
                  
               }

        return view('usermanagement::sub_counties.create',$data);

    }else{
        return view("forbidden");
    }
    }

    public function EditDetails($id,Request $request)
    {
           if(Auth::user()->can("Add Users") || Auth::user()->hasRole(["SuperAdmin","County Co-ordinator"]))
         {
            $data['page_title']="sub Counties";
            $data['url']=url()->current();
             if(Auth::User()->hasRole("County Co-ordinator"))
              {
                  $data['models']=County::where(['id'=>$this->sid])->get();

              }else{
                  $data['models']=County::all();
              }

            $data['model']=$model=SubCounty::find($id);
               if($request->isMethod("post"))
               {
                 $data=$request->all();
                  $model->county_id=$data['county_id'];
                  $model->sub_county_name=$data['sub_county_name'];
                  $model->updated_by =$this->userID;
                  $model->save();
                  Session::flash("success_msg","sub County Updated Successfully");
                  return redirect()->back();
                  
               }

        return view('usermanagement::sub_counties.create',$data);

    }else{
        return  "Access Denied";
    }

    }


    public function  GetMySubCounties($id)
    {
       $models=SubCounty::where(['county_id'=>$id])->get();
       echo '<option value="">---Select Sub County --</option>';
         foreach($models as $model)
         {
           echo '<option value="'.$model->id.'">'.$model->sub_county_name.'</option>';
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
