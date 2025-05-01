<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Session;
use App\User;
use App\Helpers\Helper;
use Modules\Usermanagement\Entities\Product;
use Modules\Usermanagement\Entities\ProductName;
use Modules\Usermanagement\Entities\Organization;
use Modules\Usermanagement\Entities\Order;
use Auth;
use Input;
use Modules\Usermanagement\Entities\County;
use Illuminate\Pagination\LengthAwarePaginator;
class ProductController extends Controller
{
    //

    public function fetchList()
    {
    	$models=DB::select('SELECT products.id,organizations.org_name,counties.county_name,sub_county_name,   vco_members.member_number,vco_members.member_name,member_telephone, value_chains.value_name,   `variety`,`quantity_available`,unit_of_measures.unit_abbreviation,`unit_price`,products.updated_at FROM products
join vco_members on vco_members.id=products.member_id
join unit_of_measures on  unit_of_measures.id=products.uom_id
join value_chains  on value_chains.id=products.value_chain_id
join organizations on organizations.id=vco_members.org_id
join counties on counties.id=organizations.county_id
join sub_counties  on  sub_counties.id=organizations.sub_county_id
 order by products.created_at desc limit ?',[4250]);


        return Datatables::of($models)
          ->rawColumns(['action'])
          ->addColumn('action', function ($model) {
              $view_url=url('/Product/ContactMember/'.$model->id);
                        return '<a data-url="'.$view_url.'"  data-title="Contact Member" class="btn btn-xs btn-success reject-modal"><i class="fa fa-phone" aria-hidden="true"></i>
Contact Details</a> 
';
            })->make(true);

    }

    public function  ViewDetails($id)
    {
    	$model=Product::find($id);
    	  if($model)
    	  {
    	  	$data['model']=$model;
    	  	$data['member']=$model->member;
    	  	 return view('contactmember',$data);
    	  }else{
    	  	 return "Access Denied";
    	  }
    	 

    }


    public function SearchByCounty(Request $request)
    {
       $data=$request->all();
         if(isset($data['value_chain_name']) && isset($data['county_code']))
         {
          $valueChainId=$data['value_chain_name'];
          $CountyId=$data['county_code'];
           if($valueChainId=="0")
           {
              $models=DB::select("SELECT products.id,product_image,variety as product_name,product_code,uom ,product_description,format(unit_price,0) unit_price,quantity_available,value_chain_name as value_name,county_name,street,town,vconame  FROM products where county_id=? and products.is_deleted is null and  product_image is not null",[$CountyId]);

           }else{

            $models=DB::select("SELECT products.id,product_image,variety as product_name,product_code,uom ,product_description,format(unit_price,0) unit_price,quantity_available,value_chain_name as value_name,county_name,street,town,vconame  FROM products where county_id=? and value_chain_id=? and products.is_deleted is null and  product_image is not null",[$CountyId,$valueChainId]);


           }

           $products = $this->arrayPaginator($models, $request);
           $data['county']=County::find($CountyId);
            



            $data['products']=$products;
            $data['counties']=DB::select("select distinct  county_id as id ,county_name from products  where is_deleted is null and county_id is not null order by  county_name asc");

           $data['categories']=DB::select("select distinct  value_chain_id as id ,value_name from products
join value_chains on value_chains.id=products.value_chain_id
 where products.is_deleted is null ");
           return  view('countyproducts',$data);



         }else{
          return redirect('/');
         }

        

    }

    public function arrayPaginator($array, $request)
{
    $page = Input::get('page', 1);
    $perPage = 12;
    $offset = ($page * $perPage) - $perPage;

    return new LengthAwarePaginator(array_slice($array, $offset, $perPage, true), count($array), $perPage, $page,
        ['path' => $request->url(), 'query' => $request->query()]);
}
 


  public function AddToCard($orgId,$pCode,Request $request)
      {
          
           $model=ProductName::where(['product_code'=>$pCode])->first();
           $organization=Organization::find($orgId);
            
            $data['model']= $model;
            $data['organization']= $organization;
            $data['url']=url()->current();
                 if($request->isMethod("post"))
                 {
                   $data=$request->all();
                     $model=new Order();
                     $model->ref_number=Helper::generatePin(10);
                     $model->org_id=$orgId;
                     $model->user_id=(Auth::User())?Auth::User()->id:null;
                     $model->product_code=$pCode;
                     $model->customer_name=$data['buyer_name'];
                     $model->customer_phone=$data['telephone'];
                     $model->qty=$data['qty'];
                     $model->unit=$data['product'];
                     $model->order_date=date('Y-m-d');
                     $model->save();
                     Session::flash("success_msg","Order Details Added Successfully");
                     return redirect()->back();
                     
                 }

            return view('addtocart',$data);

      }


    public function ProductsDetails($code)
    {

        $model=Product::where(['product_code'=>$code])->first();
          if($model)
          {
            $data['model']=$model;
             
              

              $data['featured']=ProductName::join('uploads','uploads.id','=','product_names.product_image')
         ->join('value_chains','value_chains.id','=','product_names.value_chain_id')
         ->OrderBy('product_name')->take(6)->get();


         $images=json_decode( $model->product_images);


         $data['models']=DB::select("select org_id,products.county_name,product_name,org_name,sum(quantity_available) as qty ,avg(unit_price) unit_price,products.product_code,uom,org_tephone from products join product_names on product_names.id=products.product_id join organizations on organizations.id=products.org_id join counties on counties.id=organizations.county_id where products.product_code=? group by org_id,product_name,org_name,products.product_code,county_name,org_tephone",[$code]);
          $data['images']=null;
              return view('product_details',$data);
          }else{
             return "Access Denied";
          }

    }
}
