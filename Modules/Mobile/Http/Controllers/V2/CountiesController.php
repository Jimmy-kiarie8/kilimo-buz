<?php

namespace Modules\Mobile\Http\Controllers\V2;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Usermanagement\Entities\County;
use App\User;
use DB;
use App\Helpers\Helper;
use Modules\Usermanagement\Entities\Profile;
use App\Helpers\SystemAudit;
use Modules\Usermanagement\Entities\ValueChain;
use Modules\Usermanagement\Entities\NodeType;
use Modules\Usermanagement\Entities\ProductName;
use Modules\Usermanagement\Entities\CountyValueChain;

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

    public function GetValueChains(Request $request)
    {

         $response=array();
      $data=$request->all();

        $errors=array();
        $token = $request->header('token');
        $models=ValueChain::orderBy('value_name','asc')->get();
          


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
        $models=DB::select("SELECT product_names.id,filename,product_price,product_image,value_chains.value_name,product_name,product_code,product_uom,product_names.created_at,product_description FROM product_names
join value_chains on value_chains.id=product_names.value_chain_id
join uploads on uploads.id=product_names.product_image
");


         $data=array();
         foreach($models as $model)
           {
             if(strlen($model->product_image)>0)
                {

                   $url=asset('uploads/'.$model->filename); 
                }else{
                      $url=asset("placeholder.png");
                }

                $view_url=url('/backend/directors/view/'.$model->id);
              
            $data[]=
            array("ProductId"=>$model->id,
                "ProductName"=>$model->product_name,
                'ValueChainName'=>$model->value_name,
                "ProductCode"=>$model->product_code,
                "ProductUom"=>$model->product_uom,
                "ProductDescription"=>$model->product_description,
                "ProductUnitPrice"=>$model->product_price,
                "ProductCoverImage"=>$url,


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

    public function GetProductNamesByValueChainId(Request $request)
    {
        $response=array();
        $data=$request->all();
        $errors=array();

          
             
              
          $validator =\Validator::make($data, [
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
                 

                   $models=DB::select("SELECT product_names.id,filename,product_price,product_image,value_chains.value_name,product_name,product_code,product_uom,product_names.created_at,product_description FROM product_names
join value_chains on value_chains.id=product_names.value_chain_id
join uploads on uploads.id=product_names.product_image where value_chain_id=?
",[$id]);


         $data=array();
         foreach($models as $model)
           {
             if(strlen($model->product_image)>0)
                {

                   $url=asset('uploads/'.$model->filename); 
                }else{
                      $url=asset("placeholder.png");
                }

                $view_url=url('/backend/directors/view/'.$model->id);
              
            $data[]=
            array("ProductId"=>$model->id,
                "ProductName"=>$model->product_name,
                'ValueChainName'=>$model->value_name,
                "ProductCode"=>$model->product_code,
                "ProductUom"=>$model->product_uom,
                "ProductDescription"=>$model->product_description,
                "ProductUnitPrice"=>$model->product_price,
                "ProductCoverImage"=>$url,


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
        $validator =\Validator::make($data, [
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
        $models=DB::select("SELECT product_id,unit_price,quantity_available,product_size,product_names.product_color,product_names.product_name,product_names.product_code,product_names.product_description,product_names.product_image,uploads.filename,value_name,product_uom FROM products
join product_names on  product_names.id=products.product_id
join value_chains v on v.id=product_names.value_chain_id
join uploads on uploads.id=product_names.product_image
ORDER BY RAND()
LIMIT 8
");


         $data=array();
         foreach($models as $model)
           {
             if(strlen($model->product_image)>0)
                {

                   $url=asset('uploads/'.$model->filename); 
                }else{
                      $url=asset("placeholder.png");
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
                "ProductCoverImage"=>$url,
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
      $validator =\Validator::make($request->all(), [
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
        $models=DB::select("SELECT product_names.id,filename,product_price,product_image,value_chains.value_name,product_name,product_code,product_uom,product_names.created_at,product_description FROM product_names
join value_chains on value_chains.id=product_names.value_chain_id
join uploads on uploads.id=product_names.product_image where product_names.id=?
",[$id]);


         $data=array();
         foreach($models as $model)
           {
             if(strlen($model->product_image)>0)
                {

                   $url=asset('uploads/'.$model->filename); 
                }else{
                      $url=asset("placeholder.png");
                }

                //$view_url=url('/backend/directors/view/'.$model->id);
              
            $data=
            array("ProductId"=>$model->id,
                "ProductName"=>$model->product_name,
                'ValueChainName'=>$model->value_name,
                "ProductCode"=>$model->product_code,
                "ProductUom"=>$model->product_uom,
                "ProductDescription"=>$model->product_description,
                "ProductUnitPrice"=>"KES ".$model->product_price,
                "ProductQtyAvailable"=>"In Stock",
                "ProductCoverImage"=>$url,


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
        $models=DB::select("select  org_id,county_id,o.org_name,product_id ,   sum(quantity_available) as num,uom,  unit_price  from products join organizations o on o.id=products.org_id   where  county_id=? and product_id=? group by org_id ORDER BY RAND() LIMIT 25
",[$data['county_id'],$data['product_id']]);


         $data=array();
         foreach($models as $model)
           {
             

                //$view_url=url('/backend/directors/view/'.$model->id);
              
            $data[]=
            array("SellerId"=>$model->org_id,
                "SellerName"=>$model->org_name,
                'ProductId'=>$model->product_id,
                "CountyId"=>$model->county_id,
                "ProductUom"=>$model->uom,
                "ProductQtyAvailable"=>$model->num,
                "ProductUnitPrice"=>"KES ".$model->unit_price,
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
$models=DB::select("SELECT county_id,counties.county_name FROM `county_value_chains`
join counties on counties.id=county_value_chains.county_id
where value_chain_id=?
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
}
