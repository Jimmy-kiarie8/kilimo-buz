<?php

namespace Modules\Usermanagement\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller ;
use Modules\Usermanagement\Entities\Department;
use Modules\Usermanagement\Entities\County;
use Modules\Usermanagement\Entities\ValueChain;
use Modules\Usermanagement\Entities\CountyValueChain;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Session;
use Modules\Usermanagement\Entities\ProductName;
use App\User;
use Auth;
use DB;
use Input;
use Validator;
use Redirect;
use App\Helpers\SystemAudit;
use Modules\Usermanagement\Entities\UnitOfMeasure;

class ValueChainController extends Controller
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
            $data['page_title']="Value Chains";

        return view('usermanagement::valuechains.index',$data);

    }else{
        return view("forbidden");
    }
    }


    public function CountyVsVCOs()
    {
        if(Auth::user()->can("Add Users") || Auth::user()->hasRole("SuperAdmin"))
         {
            $data['page_title']="County Vs VCOs";

        return view('usermanagement::reports.county_vcos',$data);

    }else{
        return view("forbidden");
    }

    }

    public function General()
    {
         if(Auth::user()->can("Add Users") || Auth::user()->hasRole("SuperAdmin"))
         {
            $data['page_title']="VCA Registrations";

        return view('usermanagement::reports.general',$data);

    }else{
        return view("forbidden");
    

    }
}

    public function getValueVCO()
    {
        if(Auth::user()->can("Add Users") || Auth::user()->hasRole("SuperAdmin"))
         {
            $data['page_title']="Value Chain VCOs";

        return view('usermanagement::reports.valuechain_vcos',$data);

    }else{
        return view("forbidden");
    }

    }
    public function getNodeVCO()
    {
       if(Auth::user()->can("Add Users") || Auth::user()->hasRole("SuperAdmin"))
         {
            $data['page_title']="Value Chain VCOs";

        return view('usermanagement::reports.node_vcos',$data);

    }else{
        return view("forbidden");
    }

    }

    public function getCounties()
    {
          if(Auth::user()->can("Add Users") || Auth::user()->hasRole("SuperAdmin"))
         {
            $data['page_title']="Value Chains";

        return view('usermanagement::valuechains._index',$data);

    }else{
        return view("forbidden");
    }
}


public function FetchGeneral()
{
    $models=DB::select("select counties.county_name,count(o.id) as vco,count(m.id) as total,sum(m.isMale) as male,sum(m.IsFemale) as female from counties
left join organizations o on o.county_id=counties.id
left join vco_members m on m.org_id=o.id group by county_name");
    return Datatables::of($models)->make(true);
}

    

    public function CreateCounty(Request $request)
    {

          if(Auth::user()->can("Add Users") || Auth::user()->hasRole("SuperAdmin"))
         {
            $data['page_title']="Create Value Chain";
             $data['counties']=County::all();
             $data['values']=ValueChain::all();
             $data['url']=url()->current();
              $data['model']=new CountyValueChain();
                if($request->isMethod("post"))
                {
                     $data=$request->all();
                      $model=CountyValueChain::where(['county_id'=>$data['county_id'],'value_chain_id'=>$data['value_chain_id']])->first();
                        if(!$model)
                        {
                       $model=new CountyValueChain();
                       $model->county_id=$data['county_id'];
                      $model->value_chain_id=$data['value_chain_id'];
                      $model->save();

                        }
                     

                      Session::flash("success_msg","Value Chain Attached To County Successfully");
                      return redirect()->back();

                     
                }

        return view('usermanagement::valuechains._create',$data);

    }else{
        return view("forbidden");
    }


    }
    public function fetchList()
    {
         $models=DB::select('SELECT value_chains.id,unit_name,value_name,value_chains.created_at FROM `value_chains` 
left join unit_of_measures on unit_of_measures.id=value_chains.uom_id');
            return Datatables::of($models)
          ->rawColumns(['action'])
          ->addColumn('action', function ($model) {
              $edit_url=url('/System/ValueChain/EditDetails/'.$model->id);
                        return '<div class="dropdown">
  <button class="btn btn-success btn-xs dropdown-toggle" type="button" data-toggle="dropdown">Action
  <span class="caret"></span></button>
  <ul class="dropdown-menu">
    <li><a style="cursor:pointer;" class="reject-modal"  data-title="Edit Value Chain" data-url="'.$edit_url.'">&nbsp;&nbsp;&nbsp;&nbsp;Edit Details</a></li>
    
    </ul>
</div> 
';
            })->make(true);
    }

    public function CountyValueChain()
    {
        $models=DB::select('SELECT county_value_chains.id,county_value_chains.created_at,county_name,value_chains.value_name FROM `county_value_chains`
join counties on counties.id=county_value_chains.county_id
join value_chains on  value_chains.id=county_value_chains.value_chain_id');
        return Datatables::of($models)
         ->rawColumns(['action'])
          ->addColumn('action', function ($model) {
              $edit_url=url('/System/CountyValueChain/EditDetails/'.$model->id);
                        return '<div class="dropdown">
  <button class="btn btn-success btn-xs dropdown-toggle" type="button" data-toggle="dropdown">Action
  <span class="caret"></span></button>
  <ul class="dropdown-menu">
    <li><a style="cursor:pointer;" class="reject-modal"  data-title="Edit Value Chain" data-url="'.$edit_url.'">&nbsp;&nbsp;&nbsp;&nbsp;Edit Details</a></li>
    
    </ul>
</div> 
';
            })->make(true);
    }

    public function EditDetails($id,Request $request)
    {


         if(Auth::user()->can("Add Users") || Auth::user()->hasRole("SuperAdmin"))
         {
            $data['page_title']="Create Value Chains";
             $data['url']=url()->current();
              $data['model']=$model=ValueChain::find($id);
                $data['units']=UnitOfMeasure::all();
               $old_name=$model->value_name;
                if($request->isMethod("post"))
                {
                     $data=$request->all();
                      $this->validate($request,[
                        'value_name'=>'required',
                      ]);
                      
                       $model->value_name=$data['value_name'];
                       $model->uom_id=$data['uom_id'];
                       $model->updated_by=$this->userID;
                       $model->save();
                       $user=Auth::user();
                         $description=$user->name."updated Value Chain Name from:".$old_name." to ".$model->value_name;
         $client_ip=$request->ip();
        SystemAudit::CreateEvent($user,"Updated",$description,"Major",$client_ip,"System Settings");
             Session::flash("success_msg",'Value chain Name added Successfully');
             return redirect()->back();
          
                     
                }

        return view('usermanagement::valuechains.create',$data);

    }else{
        return view("forbidden");
    }

    }

    public function EditValueDetails($id,Request $request)
    {
          if(Auth::user()->can("Add Users") || Auth::user()->hasRole("SuperAdmin"))
         {
            $data['page_title']="Create Value Chain";
             $data['counties']=County::all();
             $data['values']=ValueChain::all();
             $data['url']=url()->current();

              $data['model']=$model=CountyValueChain::find($id);
                if($request->isMethod("post"))
                {
                     $data=$request->all();
                     
                        
                       $model->county_id=$data['county_id'];
                      $model->value_chain_id=$data['value_chain_id'];
                      $model->save();
                     

                      Session::flash("success_msg","Details Updated Successfully");
                      return redirect()->back();

                     
                }

        return view('usermanagement::valuechains._create',$data);

    }else{
        return view("forbidden");
    }

    }

    public function GetCountyValues($id)
    {
           $models=DB::select('SELECT value_chain_id,value_name FROM `county_value_chains`
join counties on counties.id=county_value_chains.county_id
join value_chains on  value_chains.id=county_value_chains.value_chain_id where county_id=? ',[$id]);
             echo '<option values="">---select Value Chain----</option>';
               foreach($models as $model)
               {
                 echo '<option value="'.$model->value_chain_id.'">'.$model->value_name.'</option>';
               }


    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create(Request $request)
    {
          
         if(Auth::user()->can("Add Users") || Auth::user()->hasRole("SuperAdmin"))
         {
            $data['page_title']="Create Value Chains";
             $data['url']=url()->current();
             $data['units']=UnitOfMeasure::all();
              $data['model']=new ValueChain();
                if($request->isMethod("post"))
                {
                     $data=$request->all();
                      $this->validate($request,[
                        'value_name'=>'unique:value_chains',
                      ]);
                       $model=new ValueChain();
                       $model->value_name=$data['value_name'];
                       $model->created_by=$this->userID;
                        $model->uom_id=$data['uom_id'];
                       $model->save();
                       $user=Auth::user();
                         $description=$user->name." added new Value Chain Name".$model->value_name;
         $client_ip=$request->ip();
        SystemAudit::CreateEvent($user,"Created",$description,"Major",$client_ip,"System Settings");
             Session::flash("success_msg",'Value chain Name added Successfully');
             return redirect()->back();
          
                     
                }

        return view('usermanagement::valuechains.create',$data);

    }else{
        return view("forbidden");
    }
    }

    public function fetchCountyVCOS()
    {
      $models=DB::select('SELECT county_id,county_name,count(organizations.id)  as number FROM  organizations
left join counties on counties.id=organizations.county_id
group by county_id');
      return Datatables::of($models)->make(true);
    }

    public function ValueNameVCOS()
    {
      $models=DB::select('SELECT value_chain_id,value_name,count(organizations.id) as number from organizations join value_chains on value_chains.id=organizations.value_chain_id group by value_chain_id');
      return Datatables::of($models)->make(true);

    }

    public function FetchNodeNum()
    {
      $models=DB::select('SELECT DISTINCT node_id,node_name,count(DISTINCT org_id) as number  FROM `value_chain_organizations` 
JOIN node_types on node_types.id=value_chain_organizations.node_id
group by node_id');
      return Datatables::of($models)->make(true);
    }


    public function getUoM($id)
    {
       $models=ProductName::where(['value_chain_id'=>$id])->get();
           
            echo '<option value="">--select Product Name---</option>';

             foreach($models as $model)
             {
               echo  '<option value="'.$model->id.'">'.$model->product_name.'</option>';
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
