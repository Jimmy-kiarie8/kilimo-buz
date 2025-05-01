<?php

namespace Modules\Usermanagement\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller ;
use Modules\Usermanagement\Entities\Department;
use Modules\Usermanagement\Entities\County;
use Modules\Usermanagement\Entities\ValueChain;
use Modules\Usermanagement\Entities\ProductName;
use Modules\Usermanagement\Entities\ProductMetaData;
use Modules\Usermanagement\Entities\CountyValueChain;
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
use App\Helpers\Helper;
use Modules\Usermanagement\Entities\UnitOfMeasure;

class ProductNameController extends Controller
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
            $data['page_title']="Product Names";
            $data['url']=url()->current();
         

        return view('usermanagement::productnames.index',$data);

    }else{
        return view("forbidden");
    }
    }

    public function EditValueChain(Request $request,$id)
    {
            $data['url']=url()->current();
            $data['product']=$model=ProductName::find($id);
             $data['valuechains']=ValueChain::all();



               if($request->isMethod("post"))
               {
                  $data=$request->all();
                    
                   $model->value_chain_id=$data['value_chain_id'];
                   $model->product_name=$data['product_name'];
                   $model->save();
                   Session::flash("success_msg","Product Details  Updated Successfully");
                   return redirect()->back();
               }


               return view('usermanagement::productnames._valuechain',$data);

    }
    public function getMyMeta($id)
    {
         $models=ProductMetaData::where(['product_name_id'=>$id])
                ->select('key','value','id');

         return Datatables::of($models)
         ->addColumn('action',function($model){
            $url=url("/System/ProductNames/EditMeta/".$model->id);
            return '<button data-url="'.$url.'" class="btn btn-xs btn-info  reject-modal" data-title="Edit Details">edit</button>';

         })

         ->make(true);

    }

    public function EditMeta($id,Request $request)
    { 
         $model=ProductMetaData::find($id);
         $data['model']=$model;
         $data['url']=url()->current();
            if($request->isMethod("post"))
            {
                 $data=$request->all();
                  $model->key=$data['key'];
                  $model->value=$data['value'];
                  $model->save();

                  Session::flash("success_msg","Details Updated Successfully");
                  return redirect()->back();
                
            }
            return view('usermanagement::productnames._editmeta',$data);

    }

    public function fetchList()
    {
        $models=DB::select("SELECT product_names.id,filename,product_price,product_image,value_chains.value_name,product_name,product_code,product_uom,product_names.created_at FROM product_names
join value_chains on value_chains.id=product_names.value_chain_id
join uploads on uploads.id=product_names.product_image
");

           return Datatables::of($models)
          ->rawColumns(['action','product_image'])
           ->addColumn('details_url', function($user) {
            return url('/System/ProductNames/getMyMeta/' . $user->id);
        })
          ->editColumn('product_image',function($model){

             if(strlen($model->product_image)>0)
                {

                   $url=asset('uploads/'.$model->filename); 
                }else{
                      $url=asset("placeholder.png");
                }

                $view_url=url('/backend/directors/view/'.$model->id);

              return '<img src='.$url.' data-title="View Manager-Summary View" border="0" width="120" height="100"  data-url="'.$view_url.'" class="img-rounded pop-modal" align="center" cursor="pointer"  style="cursor:pointer;border-radius:5%" title="View Details"    />';

          })
          ->addColumn('action', function ($model) {
              $edit_url=url('/System/ProductNames/EditDetails/'.$model->id);
               $price_edit_url=url('/System/ProductNames/EditPrice/'.$model->id);

                $chain_edit_url=url('/System/ProductNames/EditValueChain/'.$model->id);

              $meta_url=url('/System/ProductNames/MetaData/'.$model->id);
                        return '<div class="dropdown">
  <button class="btn btn-success btn-xs dropdown-toggle" type="button" data-toggle="dropdown">Action
  <span class="caret"></span></button>
  <ul class="dropdown-menu">
  <li><a style="cursor:pointer;" class="reject-modal"  data-title="Add Product Meta Data" data-url="'.$meta_url.'">&nbsp;&nbsp;&nbsp;&nbsp;Add MetaData</a></li>
    <li><div class="dropdown-divider"></div></li>
    

  

    <li><div class="dropdown-divider"></div></li>
    <li><a style="cursor:pointer;" class="reject-modal"  data-title="Edit Product Price" data-url="'.$price_edit_url.'">&nbsp;&nbsp;&nbsp;&nbsp;Edit Price</a></li>

     <li><div class="dropdown-divider"></div></li>
    <li><a style="cursor:pointer;" class="reject-modal"  data-title="Edit Value Chain Name" data-url="'.$chain_edit_url.'">&nbsp;&nbsp;&nbsp;&nbsp;Edit Value Chain</a></li>

      <li><div class="dropdown-divider"></div></li>
    
      <li><a style="cursor:pointer;"  title="Edit Details" href="'.$edit_url.'">&nbsp;&nbsp;&nbsp;&nbsp;Edit Details</a></li>


   
    
    </ul>
</div> 
';
            })->make(true);
    }


    public  function EditPrice(Request $request,$id)
    {
         $data['url']=url()->current();
            $data['product']=$model=ProductName::find($id);
               if($request->isMethod("post"))
               {
                  $data=$request->all();
                   $model->product_price=doubleval(str_replace(",","",$data['product_price']));
                   $model->product_uom=$data['product_uom'];
                   $model->save();
                   Session::flash("success_msg","Price Updated Successfully");
                   return redirect()->back();
               }


               return view('usermanagement::productnames._editprice',$data);

    }


    public function EditDetails(Request $request,$id)
    {
        if(Auth::user()->can("Add Users") || Auth::user()->hasRole("SuperAdmin"))
         {
            $data['page_title']="Product Names";
            $data['url']=url()->current();
            $data['model']=$model=ProductName::find($id);
            $data['values']=ValueChain::pluck('value_name','id')->toArray();
               if($request->isMethod("post"))
               {
                $data=$request->all();

                 
                   $model->value_chain_id=$data['value_chain_id'];
                   $model->product_name=$data['product_name'];
                   $model->product_color=$data['product_color'];
                   $model->product_uom=$data['product_uom'];
                   $model->product_description=$data['product_description'];
                   $model->save();

                   Session::flash("success_msg","Product Name Added Successfully");
                   return redirect('/System/ProductNames/Index');

                
               }


        return view('usermanagement::productnames.edit',$data);

    }else{
        return view("forbidden");
    }

    }
    public function getMeta($id,Request $request)
    {

         $data=$request->all();
           try{
            $key=$data['key'];
         $models=ProductMetaData::where(['product_name_id'=>$id,'key'=>$key])->get();
           foreach($models as $model)
           {
             echo '<option>'.$model->value.'</option>';
           }


           }catch(\Exception $e)
           {
             echo '<option value="">---select One---</option>';

           }
          

    }


    public function MetaData($id,Request $request)
    {
        $data['product']=ProductName::find($id);
        $data['url']=url()->current();
           if($request->isMethod("post"))
           {
              $data=$request->all();
              $model=ProductMetaData::where(['product_name_id'=>$id,'key'=>$data['key'],'value'=>$data['value']])->first();
                if(!$model)
                {
                $model=new ProductMetaData();
                $model->product_name_id=$id;
                $model->key=$data['key'];
                $model->value=$data['value'];
                $model->save();

                }
                
                Session::flash("success_msg","Product MetaData Added Successfully");
                return redirect()->back();

               
           }

          return view('usermanagement::productnames.metadatas',$data);

    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create(Request $request)
    {
        if(Auth::user()->can("Add Users") || Auth::user()->hasRole("SuperAdmin"))
         {
            $data['page_title']="Product Names";
            $data['url']=url()->current();
            $data['model']=new ProductName();
            $data['values']=ValueChain::pluck('value_name','id')->toArray();
               if($request->isMethod("post"))
               {
                $data=$request->all();
                 
                 

                   $model=new ProductName();
                   $model->value_chain_id=$data['value_chain_id'];
                   $model->product_name=$data['product_name'];
                   $model->product_color=$data['product_color'];
                   $model->product_uom=$data['product_uom'];
                   $model->product_image=$data['primary_image'];
                   $model->product_description=$data['product_description'];
                   $model->product_code=Helper::generatePin(8);
                   $model->product_images=json_encode($data['primary_images']);
                   $model->product_price=doubleval(str_replace(",", "", $data['product_price']));
                   
                   $model->save();

                   Session::flash("success_msg","Product Name Added Successfully");
                   return redirect('/System/ProductNames/Index');

                
               }


        return view('usermanagement::productnames.create',$data);

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
