<?php

namespace App\Http\Controllers\V2;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Usermanagement\Entities\County;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Helpers\Helper;
use Modules\Usermanagement\Entities\Profile;
use App\Helpers\SystemAudit;
use Modules\Usermanagement\Entities\ValueChain;
use Modules\Usermanagement\Entities\NodeType;
use Modules\Usermanagement\Entities\ProductName;
use Modules\Usermanagement\Entities\CountyValueChain;
use Modules\Usermanagement\Entities\Product;
use Modules\Usermanagement\Entities\UnitOfMeasure;

class CountiesController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {
         $response=array();
      $data=$request->all();

      $errors=array();
      $token = $request->header('token');
       $models=County::orderBy('county_name')->get();
         $data=array();

           foreach($models as $model)
           {


            $data[]=array("CountyId"=>$model->id,"CountyName"=>$model->county_name,'CountyCode'=>$model->county_code);
           }

           $response['counties_list']=$data;

  $response['errors']=$errors;
  if(sizeof($response['errors'])>0)
  {
    $response['success']=false;
  }
  else
  {
    $response['success']=true;
  }
  return response()->json($response);


    }


    public function GetNodes(Request $request)
    {
        $response=array();
      $data=$request->all();

        $errors=array();
        $token = $request->header('token');
        $models=NodeType::orderBy('node_name')->get();
         $data=array();
         foreach($models as $model)
           {
            $data[]=array("NodeId"=>$model->id,"NodeName"=>$model->node_name);
           }

           $response['nodes_list']=$data;

  $response['errors']=$errors;
  if(sizeof($response['errors'])>0)
  {
    $response['success']=false;
  }
  else
  {
    $response['success']=true;
  }
  return response()->json($response);


    }

    public function GetUom(Request $request)
    {

        $response=array();
      $data=$request->all();

        $errors=array();
        $token = $request->header('token');
        $models=UnitOfMeasure::orderBy('unit_name')->get();
         $data=array();
         foreach($models as $model)
           {
            $data[]=array("UnitId"=>$model->id,"UnitName"=>$model->unit_name);
           }

           $response['uom_list']=$data;

  $response['errors']=$errors;
  if(sizeof($response['errors'])>0)
  {
    $response['success']=false;
  }
  else
  {
    $response['success']=true;
  }
  return response()->json($response);

    }

    public function GetValueChains(Request $request)
    {

         $response=array();
      $data=$request->all();

        $errors=array();
        $token = $request->header('token');
        $models=DB::select("select distinct  value_chain_id as id ,value_name from products
join value_chains on value_chains.id=products.value_chain_id
 where products.is_deleted is null order by value_name");



         $data=array();
         foreach($models as $model)
           {
            $data[]=array("ValueChainId"=>$model->id,"ValueChainName"=>$model->value_name);
           }
           $response['valuechains_count']=sizeof( $models);

           $response['valuechains_list']=$data;


  $response['errors']=$errors;
  if(sizeof($response['errors'])>0)
  {
    $response['success']=false;
  }
  else
  {
    $response['success']=true;
  }
  return response()->json($response);



    }


    public function GetProductNames(Request $request)
    {
         $response=array();
      $data=$request->all();

        $errors=array();
        $token = $request->header('token');
        $models=DB::select("SELECT products.id,product_image,variety as product_name,product_code,uom ,product_description,format(unit_price,0) unit_price,quantity_available,value_chain_name as value_name,county_name,street,town  FROM products where products.is_deleted is null and product_image is not null  order by id desc limit 30");


         $data=array();
         foreach($models as $model)
           {

              if(strlen($model->product_image)>0)
                     {
                        $image=asset('MemberProducts/'.$model->product_image);
                     }else{
                       $image=asset("placeholder.png");
                       // $image="Not Set";
                     }

                $data[]= array("ProductId"=>$model->id,
                "ProductName"=>$model->product_name,
                'ValueChainName'=>$model->value_name,
                "ProductCode"=>$model->product_code,
                "ProductUom"=>$model->uom,
                "ProductDescription"=>$model->product_description,
                "ProductUnitPrice"=>$model->unit_price,
                "ProductQuantity"=>$model->quantity_available,
                "ProductCoverImage"=>$image,
                "ProductCounty"=>$model->county_name,
                "ProductLocation"=>$model->street.", ".$model->town


              );
           }

           $response['productnames_list']=$data;

  $response['errors']=$errors;
  if(sizeof($response['errors'])>0)
  {
    $response['success']=false;
  }
  else
  {
    $response['success']=true;
  }
  return response()->json($response);

    }


    public  function GetProducstByCountyID(Request $request)
    {

       $response=array();
        $data=$request->all();
        $errors=array();




          $validator = Validator::make($data, [
                'CountyId'=>'required|exists:counties,id',
            ],['Invalid County ID']);
           if ($validator->fails())
        {

            $current_errors = $validator->errors();
            foreach($current_errors->all() as $error)
            {
                $errors[]=$error;
            }

            $response['errors']=$errors;
            $response['msg']="Invalid County Provided";
        }
        else
        {
             $id=$data['CountyId'];

            $valuechain=County::find($id);
               if($valuechain)
               {


                   $models=DB::select("SELECT products.id,product_image,variety as product_name,product_code,uom ,product_description,format(unit_price,0) unit_price,quantity_available,value_chain_name as value_name,county_name,street,town,vconame  FROM products where county_id=? and products.is_deleted is null and  product_image is not null ",[$id]);


         $data=array();
         foreach($models as $model)
           {


                 if(strlen($model->product_image)>0)
                     {
                        $image=asset('MemberProducts/'.$model->product_image);
                     }else{
                        $image=asset("placeholder.png");
                     }



            $data[]=
            array("ProductId"=>$model->id,
                "ProductName"=>$model->product_name,
                'ValueChainName'=>$model->value_name,
                "ProductCode"=>$model->product_code,
                "ProductUom"=>$model->uom,
                "ProductDescription"=>$model->product_description,
                "ProductUnitPrice"=>$model->unit_price,
                "ProductCoverImage"=>$image,
                "VCOName"=>$model->vconame


              );
           }

           $response['productnames_list']=$data;






               }else{
                $response['msg']="User Details Not Found";

               }



        }


        $response['errors']=$errors;
         if(sizeof($response['errors'])>0)
        {
            $response['success']=false;

        }
        else
        {
            $response['success']=true;
        }

        return response()->json($response);


    }




    public function GetProductNamesByValueChainId(Request $request)
    {
        $response=array();
        $data=$request->all();
        $errors=array();




          $validator = Validator::make($data, [
                'ValueChainId'=>'required|exists:value_chains,id',
            ],['Invalid ValueChainId']);
           if ($validator->fails())
        {

            $current_errors = $validator->errors();
            foreach($current_errors->all() as $error)
            {
                $errors[]=$error;
            }

            $response['errors']=$errors;
            $response['msg']="Invalid ValueChainId Provided";
        }
        else
        {
             $id=$data['ValueChainId'];

            $valuechain=ValueChain::find($id);
               if($valuechain)
               {


                   $models=DB::select("SELECT products.id,product_image,variety as product_name,product_code,uom ,product_description,format(unit_price,0) unit_price,quantity_available,value_chain_name as value_name,county_name,street,town  FROM products where value_chain_id=? and products.is_deleted is null and  product_image is not null
",[$id]);


         $data=array();
         foreach($models as $model)
           {


                 if(strlen($model->product_image)>0)
                     {
                        $image=asset('MemberProducts/'.$model->product_image);
                     }else{
                        $image=asset("placeholder.png");
                     }



            $data[]=
            array("ProductId"=>$model->id,
                "ProductName"=>$model->product_name,
                'ValueChainName'=>$model->value_name,
                "ProductCode"=>$model->product_code,
                "ProductUom"=>$model->uom,
                "ProductDescription"=>$model->product_description,
                "ProductUnitPrice"=>$model->unit_price,
                "ProductCoverImage"=>$image,


              );
           }

           $response['productnames_list']=$data;






               }else{
                $response['msg']="User Details Not Found";

               }



        }


        $response['errors']=$errors;
         if(sizeof($response['errors'])>0)
        {
            $response['success']=false;

        }
        else
        {
            $response['success']=true;
        }

        return response()->json($response);

    }

    public function GetCountyValueChainByCid(Request $request)
    {
         $response=array();
        $data=$request->all();
        $errors=array();
        $validator = Validator::make($data, [
                'CountyId'=>'required|exists:counties,id',
            ],['Invalid County ID']);
           if ($validator->fails())
        {

            $current_errors = $validator->errors();
            foreach($current_errors->all() as $error)
            {
                $errors[]=$error;
            }

            $response['errors']=$errors;
            $response['msg']="Invalid CountyId Provided";
        }
        else
        {
             $id=$data['CountyId'];

            $valuechain=County::find($id);
               if($valuechain)
               {

                $models=CountyValueChain::join('value_chains','value_chains.id','=','county_value_chains.value_chain_id')
                     ->select('value_chains.id','value_name')
                     ->where(['county_id'=>$id])->get();





         $data=array();
          foreach($models as $model)
           {
            $data[]=array("ValueChainId"=>$model->id,"ValueChainName"=>$model->value_name);
           }

           $response['valuechains_list']=$data;






               }else{
                $response['msg']="County Details Not Found";

               }



        }


        $response['errors']=$errors;
         if(sizeof($response['errors'])>0)
        {
            $response['success']=false;

        }
        else
        {
            $response['success']=true;
        }

        return response()->json($response);

    }


    public function GetFeaturedItems(Request $request)
    {
          $response=array();
      $data=$request->all();


        $errors=array();
        //$token = $request->header('token');
        $models=DB::select("SELECT id as product_id,unit_price,quantity_available,product_image,variety as product_name,value_chain_name as value_name,product_description,product_code ,uom as product_uom,product_description,'' as product_size  FROM products where is_deleted is null and product_image is not null

ORDER BY RAND()
LIMIT 8
");


         $data=array();
         foreach($models as $model)
           {

                if(strlen($model->product_image)>0)
                     {
                        $image=asset('MemberProducts/'.$model->product_image);
                     }else{
                        $image=asset("placeholder.png");
                     }



                //$view_url=url('/backend/directors/view/'.$model->id);

            $data[]=
            array("ProductId"=>$model->product_id,
                "ProductName"=>$model->product_name,
                'ValueChainName'=>$model->value_name,
                "ProductCode"=>$model->product_code,
                "ProductUom"=>$model->product_uom,
                "ProductDescription"=>$model->product_description,
                "ProductUnitPrice"=>"KES ".$model->unit_price,
                "ProductQtyAvailable"=>$model->quantity_available,
                "ProductCoverImage"=>$image,
                "ProductSize"=>$model->product_size


              );
           }

           $response['productnames_list']=$data;

  $response['errors']=$errors;
  if(sizeof($response['errors'])>0)
  {
    $response['success']=false;
  }
  else
  {
    $response['success']=true;
  }
  return response()->json($response);


    }

    public function GetProductByID(Request $request)
    {
         $response=array();
      $data=$request->all();
      $validator = Validator::make($request->all(), [
                'product_id'=>'required|integer',

            ]);
           if ($validator->fails())
        {

            $current_errors = $validator->errors();
            foreach($current_errors->all() as $error)
            {
                $errors[]=$error;
            }

            $response['errors']=$errors;
        }
        else
        {

        $errors=array();
        $id=$data['product_id'];
        $models=DB::select("SELECT id,product_image,variety as product_name,product_code,created_at,product_description,product_image,value_chain_name as value_name,product_description,quantity_available,format(unit_price,0) unit_price,uom,county_name,'' as subcountyname,street,town,sellername,
          CONCAT(SUBSTR(sellermobilenumber, 4, 6), REPEAT('*', CHAR_LENGTH(sellermobilenumber) - 6)) as sellermobilenumber,user_id


         From products where id=?
",[$id]);


         $data=array();
         foreach($models as $model)
           {

              if(strlen($model->product_image))
                     {
                        $image=asset('MemberProducts/'.$model->product_image);
                     }else{
                        $image="Not Set";
                         $image=asset("placeholder.png");
                     }


                //$view_url=url('/backend/directors/view/'.$model->id);

            $data=
            array("ProductId"=>$model->id,
                "ProductName"=>$model->product_name,
                'ValueChainName'=>$model->value_name,
                "ProductCode"=>$model->product_code,
                "ProductUom"=>$model->uom,
                "ProductDescription"=>$model->product_description,
                "ProductUnitPrice"=>"KES ".$model->unit_price,
                "ProductQtyAvailable"=>$model->quantity_available,
                "ProductCoverImage"=>$image,
                "CountyName"=>$model->county_name,
                "SubCounty"=>$model->subcountyname,
                'PhysicalLocation'=>$model->street.",".$model->town,
                "SellerName"=>$model->sellername,
                "SellerMobile"=>$model->sellermobilenumber,
                "SellerUserId"=>$model->user_id


              );
           }

           $response['ProductDetails']=$data;


           $reviewmodels=DB::select("select id,username,rate,remarks,created_at from product_reviews where product_id=? order by id desc  limit 10 ",[$id]);
             $review_data=array();
               foreach($reviewmodels as $model)
               {
                $review_data[]=array("ReviewId"=>$model->id,
                               'ReviewedBy'=>$model->username,
                               "Remarks"=>$model->remarks,
                               "ReviewDate"=>date("Y-m-d",strtotime($model->created_at)),
                               "Rating"=>$model->rate


                               );

               }
               $response['product_reviews']=$review_data;

       }

  $response['errors']=$errors;
  if(sizeof($response['errors'])>0)
  {
    $response['success']=false;
  }
  else
  {
    $response['success']=true;
  }
  return response()->json($response);

    }


    public function GetProductSellersByCounty(Request $request)
    {

           $response=array();
      $data=$request->all();


        $errors=array();
        //$token = $request->header('token');
        $models=DB::select("select  org_id ,sellername,id,vconame,uom,unit_price,county_id,county_name ,quantity_available ,
          CONCAT(SUBSTR(sellermobilenumber, 4, 6), REPEAT('*', CHAR_LENGTH(sellermobilenumber) - 6)) as sellermobilenumber,town,street

          from products  where products.county_id=? and id=? group by org_id ORDER BY RAND() LIMIT 25
",[$data['county_id'],$data['product_id']]);


         $data=array();
         foreach($models as $model)
           {






            $data[]=
            array(
                "SellerId"=>$model->org_id,
                "VCOName"=>$model->vconame,
                "SellerName"=>$model->sellername,
                'SellerPhone'=>$model->sellermobilenumber,
                'ProductId'=>$model->id,
                "CountyId"=>$model->county_id,
                'CountyName'=>$model->county_name,
                "ProductUom"=>$model->uom,
                "ProductQtyAvailable"=>$model->quantity_available,
                "ProductUnitPrice"=>"KES ".$model->unit_price,
                "SellerLocation"=>$model->street." , ".$model->town
              );
           }

           $response['sellers_list']=$data;

  $response['errors']=$errors;
  if(sizeof($response['errors'])>0)
  {
    $response['success']=false;
  }
  else
  {
    $response['success']=true;
  }
  return response()->json($response);

    }



    public function GetValueChainCounties(Request $request)
    {
        $response=array();
      $data=$request->all();

      $errors=array();
$models=DB::select("SELECT distinct county_id,county_name FROM products where value_chain_id=?
",[$data['ValueChainId']]);


         $data=array();
         foreach($models as $model)
           {


            $data[]=
            array("CountyId"=>$model->county_id,
                "CountyName"=>$model->county_name,
                 );
           }

           $response['counties_list']=$data;

  $response['errors']=$errors;
  if(sizeof($response['errors'])>0)
  {
    $response['success']=false;
  }
  else
  {
    $response['success']=true;
  }
  return response()->json($response);

    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('mobile::create');
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
        return view('mobile::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('mobile::edit');
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



    public function filterProducts(Request $request)
    {
        $valuechain = $request->valuechain;
        $county = $request->county;
        $minprice = $request->minprice ?? 0;
        $maxprice = $request->maxprice ?? 200000;
        $minquantity = $request->minquantity ?? 0;
        $maxquantity = $request->maxquantity ?? 1000000;
        $sort = $request->sort ?? 'featured';
        $perPage = $request->perPage ?? 12;
        $page = $request->page ?? 1;

        $query = Product::query()
            ->whereNotNull('product_image')
            ->whereNull('is_deleted')
            ->where('unit_price', '>=', $minprice)
            ->where('unit_price', '<=', $maxprice)
            ->where('quantity_available', '>=', $minquantity)
            ->where('quantity_available', '<=', $maxquantity);

        // Filter by value chain if provided
        if (!empty($valuechain)) {
            $valuechainIds = explode(',', $valuechain);
            $query->whereIn('value_chain_id', $valuechainIds);
        }

        // Filter by county if provided
        if (!empty($county)) {
            $countyIds = explode(',', $county);
            $query->whereIn('county_id', $countyIds);
        }

        // Apply sorting
        switch ($sort) {
            case 'price_asc':
                $query->orderBy('unit_price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('unit_price', 'desc');
                break;
            case 'newest':
                $query->orderBy('created_at', 'desc');
                break;
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
            case 'popular':
                // You might want to add a column for popularity or use another metric
                $query->orderBy('id', 'desc');
                break;
            default: // featured or any other value
                $query->orderBy('id', 'desc');
                break;
        }

        // Get products with pagination
        $products = $query->paginate($perPage, ['*'], 'page', $page);

        // Format products for response
        $formattedProducts = [];
        foreach ($products as $product) {
            $formattedProducts[] = [
                'id' => $product->id,
                'variety' => $product->variety,
                'product_code' => $product->product_code,
                'product_image' => $product->product_image,
                'unit_price' => $product->unit_price,
                'quantity_available' => $product->quantity_available,
                'uom' => $product->uom,
                'county_name' => $product->county_name,
                'value_chain_name' => $product->value_chain_name,
                'created_at' => $product->created_at,
            ];
        }

        return response()->json([
            'success' => true,
            'products' => $formattedProducts,
            'pagination' => [
                'total' => $products->total(),
                'per_page' => $products->perPage(),
                'current_page' => $products->currentPage(),
                'last_page' => $products->lastPage(),
            ]
        ]);
    }

    public function testApi(Request $request)
    {
        return response()->json([
            'success' => true,
            'message' => 'API is working correctly',
            'timestamp' => now()
        ]);
    }
}
