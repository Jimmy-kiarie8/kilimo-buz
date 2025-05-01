<?php

namespace Modules\Usermanagement\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller ;
use Modules\Usermanagement\Entities\Department;
use Modules\Usermanagement\Entities\County;
use Modules\Usermanagement\Entities\Organization;
use Modules\Usermanagement\Entities\Transporter;
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
use Excel;
use App\Imports\MemberImport;
use App\Helpers\Helper;
class TransporterController extends Controller
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
        
         if(Auth::user()->hasRole(["SuperAdmin","Organization","County Co-ordinator"]))
         {
            $data['page_title']="Transporters List";

        return view('usermanagement::transporters.index',$data);

    }else{
        return view("forbidden");
    }
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create(Request $request)
    {
        $data['page_title']="Import";
              if(Auth::User()->hasRole("SuperAdmin"))
              {
                 $data['counties']=County::pluck('county_name','id')->toArray();
                 $data['orgs']=Organization::where(['node_id'=>'5'])
                 ->orderBy('org_name','asc')
                ->pluck('org_name','org_name')->toArray();

              }else{
                 $data['counties']=County::where('id',$this->OrgID)->pluck('county_name','id')->toArray();
                 $data['orgs']=Organization::where(['county_id'=>$this->OrgID,'node_id'=>'5'])
                 ->orderBy('org_name','asc')
                 ->pluck('org_name','org_name')->toArray();
                
              }
              $data['url']=url()->current();
              $data['model']=new Transporter();
                  if($request->isMethod("post"))
                  {
                    $this->validate($request,[
                        'county_id'=>'required|integer',
                        'vco_number'=>'required',
                        'name'=>'required|string',
                        'contact_telephone'=>'required|string'


                    ]);
                    $data=$request->all();

                    $model=new Transporter();
                    $model->county_id=$data['county_id'];
                    $model->vco_number=$data['vco_number'];
                    $model->name=$data['name'];
                    $model->contact_telephone=$data['contact_telephone'];
                    $model->items_transported=$data['items_transported'];
                    $model->origin=$data['origin'];
                    $model->destination=$data['destination'];
                    $model->capacity=$data['capacity'];
                    $model->duration_to_destination=$data['duration_to_destination'];
                    $model->km_covered=$data['km_covered'];
                    $model->cost_Per_km=$data['cost_Per_km'];
                    $model->payment_model=$data['payment_model'];
                    $model->special_features=$data['special_features'];
                    $model->save();

                    Session::flash("success_msg","Transporter added Successfully");
                    return redirect()->back();

                                      }
               
                return view('usermanagement::transporters.create',$data);
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
