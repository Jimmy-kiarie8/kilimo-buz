<?php

namespace App\Http\Controllers\V2;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Usermanagement\Entities\County;
use App\User;
use DB;
use App\Helpers\Helper;
use App\Helpers\CharterHelper;
use Modules\Usermanagement\Entities\Profile;
use App\Helpers\SystemAudit;
use Modules\Usermanagement\Entities\ValueChain;
use Modules\Usermanagement\Entities\NodeType;
use Modules\Usermanagement\Entities\ProductName;
use Modules\Usermanagement\Entities\Order;
use Modules\Usermanagement\Entities\Organization;
use Modules\Mobile\Entities\ProductReview;
use Modules\Usermanagement\Entities\Product;



class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('mobile::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function CreateOrder(Request $request)
    {
        $response=array();
      $data=$request->all();

      $errors=array();
       $user=User::find($data['user_id']);
           if(!$user)
           {
             $error[]=array("404"=>"User Details Not Found");

           }
        
        $product=Product::find($data['ProductId']);
       
           
        

           $model=Order::where(['user_id'=>$user->id,'product_id'=>$product->id,'org_id'=>$product->org_id,'order_date'=>date('Y-m-d'),'qty'=>$data['Quantity']])->first();
                if(!$model)
                {
                    DB::beginTransaction();
                     $model=new Order();
                     $model->ref_number=Helper::generatePin(10);
                     $model->org_id=$product->org_id;
                     $model->user_id=$user->id;
                     $model->product_code=$product->product_code;
                     $model->product_id=$product->id;
                     $model->customer_name=$user->name;
                     $model->customer_phone=$user->phone;
                     $model->qty=$data['Quantity'];
                     $model->countyname=$product->county_name;
                     $model->unit_price=$product->orders; 
                     $model->unit=$product->uom;
                     $model->order_date=date('Y-m-d');
                     $model->county_id=$product->county_id;
                     $model->f_year=CharterHelper::CurFinancialYear();
                     $model->q_name=CharterHelper::QuaterName();
                     $model->seller_userId=$product->user_id;
                     $model->save();
                     DB::commit();
                       try{
                        $phone=$product->sellermobilenumber;

                         $text="New Order with Ref No ".$model->ref_number." from ".$model->customer_name." ( ".$model->customer_phone.") for ".$model->qty." ".$model->unit ." of ".$product->variety;
                    $test= Helper::sendSMS($phone,$text);
                     

                       }catch(\Exception $e)
                       {
                         

                       }

                       
                    
                      
                     $response['msg']="Order Placed Successfully";
                    $response['orderDetails']=array('order_id'=>$model->id,
                                               'customer_name'=>$user->name,
                                               'customer_phone'=>$user->phone,
                                               'order_date'=>$model->order_date,
                                               'product_code'=>$product->product_code,
                                               'product_id'=>$product->id,
                                               'product_name'=>$product->variety,
                                               'seller_name'=>$product->sellername,
                                               'Seller_vco'=>$product->vconame,
                                               'sellermobilenumber'=>$product->sellermobilenumber,
                                               'seller_longitude'=>$product->longitude,
                                               'seller_latitude'=>$product->latitude,
                                               'seller_town'=>$product->town,
                                               'seller_street'=>$product->street,
                                               'countyname'=>$product->county_name,
                                               'quantity'=>$model->qty,
                                               'units'=>$product->uom,
                                               'unit_price'=>$product->unit_price,
                                               'sub_total'=>$model->qty*$product->unit_price,
                                                'systemdatetime'=>date('Y-m-d H:i:s',strtotime($model->created_at)),
                                                );

                }else{
                    $response['msg']="Order Already placed";
                    $response['orderDetails']=array('order_id'=>$model->id,
                                               'customer_name'=>$user->name,
                                               'customer_phone'=>$user->phone,
                                               'order_date'=>$model->order_date,
                                               'product_code'=>$product->product_code,
                                               'product_id'=>$product->id,
                                               'product_name'=>$product->variety,
                                               'seller_name'=>$product->sellername,
                                               'Seller_vco'=>$product->vconame,
                                               'sellermobilenumber'=>$product->sellermobilenumber,
                                               'seller_longitude'=>$product->longitude,
                                               'seller_latitude'=>$product->latitude,
                                               'seller_town'=>$product->town,
                                               'seller_street'=>$product->street,
                                               'countyname'=>$product->county_name,
                                               'quantity'=>$model->qty,
                                               'units'=>$product->uom,
                                               'unit_price'=>$product->unit_price,
                                               'sub_total'=>$model->qty*$product->unit_price,
                                                'systemdatetime'=>date('Y-m-d H:i:s',strtotime($model->created_at)),
                                                );



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


    public function GetOrderDetails($id,Request $request)
    {
          $response=array();
      $data=$request->all();

      $errors=array();
        $model=Order::join('product_names','product_names.product_code','=','orders.product_code')
                    ->select('orders.id','order_date','customer_name','customer_phone','ref_number','product_name','product_names.product_code','qty','unit','order_status','org_name','organizations.contact_name','org_tephone','alt_telephone','product_image','product_id','filename','product_description','product_price')
                    ->join('organizations','organizations.id','=','orders.org_id')
                    ->leftjoin('uploads','uploads.id','=','product_names.product_image')
                    ->where(['orders.id'=>$id])->orderBy('orders.id','desc')->first();
          if($model)
          {
                        if(strlen($model->product_image)>0)
                                {

                                   $url=asset('uploads/'.$model->filename); 
                                }else{
                                      $url=asset("placeholder.png");
                                }
                    $details=array("OrderId"=>$model->id,
                                'OrderDate'=>$model->order_date,
                                'CustomerName'=>$model->customer_name,
                                'CustomerPhone'=>$model->customer_phone,
                                'OrderRef'=>$model->ref_number,
                                'ProductName'=>$model->product_name,
                                'ProductCode'=>$model->product_code,
                                'ProductId'=>$model->product_id,
                                'ProductDescription'=>$model->product_description,
                                'ProductUnit'=>"Ksh ".$model->product_price,
                                'Quantity'=>$model->qty,
                                "SubTotal"=>"Ksh ".$model->qty*$model->product_price,
                                'Uom'=>$model->unit,
                                'OrderStatus'=>$model->order_status,
                                'SellerName'=>$model->org_name,
                                'SellerContactPerson'=>$model->contact_name,
                                'SellerPhone'=>$model->org_tephone,
                                'SellerAltPhone'=>$model->alt_telephone,
                                 "ProductCoverImage"=>$url,
                            );

                     $response['orderdetails']=$details;

          }else{
           $error[]=array("404"=>"User Details Not Found"); 
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



    public function GetSellerOrders(Request $request)
    {
        $response=array();
      $data=$request->all();

      $errors=array();
       $user=User::find($data['UserId']);
           if(!$user)
           {
             $error[]=array("404"=>"User Details Not Found");

           }


           $models=Order::join('products','products.id','=','orders.id')
                    ->select('orders.id','order_date','customer_name','customer_phone','ref_number','variety','products.product_code','qty','unit','order_status','vconame','sellername','sellermobilenumber','product_image','orders.product_id','product_image','product_description','orders.unit_price')
                    ->where(['orders.seller_userId'=>$user->id])->orderBy('orders.id','desc')->take(30)->get();
                    

                      $lists=array();
                        foreach($models as $model)
                        {
                               

                                 if(strlen($model->product_image))
                     {
                        $image=asset('MemberProducts/'.$model->product_image);
                     }else{
                        $image=asset("placeholder.png");
                     }

                            $lists[]=array("OrderId"=>$model->id,
                                'OrderDate'=>$model->order_date,
                                'CustomerName'=>$model->customer_name,
                                'CustomerPhone'=>$model->customer_phone,
                                'OrderRef'=>$model->ref_number,
                                'ProductName'=>$model->variety,
                                'ProductCode'=>$model->product_code,
                                'ProductId'=>$model->product_id,
                                'ProductDescription'=>$model->product_description,
                                'ProductUnit'=>"Ksh ".$model->unit_price,
                                'Quantity'=>$model->qty,
                                "SubTotal"=>"Ksh ".$model->qty*$model->product_price,
                                'Uom'=>$model->unit,
                                'OrderStatus'=>$model->order_status,
                                'SellerName'=>$model->vconame,
                                'SellerContactPerson'=>$model->sellername,
                                'SellerPhone'=>$model->sellermobilenumber,
                                'SellerAltPhone'=>null,
                                 "ProductCoverImage"=>$image,
                            );
                        }

                        $response['my_orders_request_list']=$lists;







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

     public function MyOrders(Request $request)
     {
        $response=array();
      $data=$request->all();

      $errors=array();
       $user=User::find($data['user_id']);
           if(!$user)
           {
             $error[]=array("404"=>"User Details Not Found");

           }


           $models=Order::join('products','products.id','=','orders.id')
                    ->select('orders.id','order_date','customer_name','customer_phone','ref_number','variety','products.product_code','qty','unit','order_status','vconame','sellername','sellermobilenumber','product_image','orders.product_id','product_image','product_description','orders.unit_price')
                    ->where(['orders.user_id'=>$user->id])->orderBy('orders.id','desc')->take(30)->get();
                    

                      $lists=array();
                        foreach($models as $model)
                        {
                               

                                 if(strlen($model->product_image))
                     {
                        $image=asset('MemberProducts/'.$model->product_image);
                     }else{
                        $image=asset("placeholder.png");
                     }

                            $lists[]=array("OrderId"=>$model->id,
                                'OrderDate'=>$model->order_date,
                                'CustomerName'=>$model->customer_name,
                                'CustomerPhone'=>$model->customer_phone,
                                'OrderRef'=>$model->ref_number,
                                'ProductName'=>$model->variety,
                                'ProductCode'=>$model->product_code,
                                'ProductId'=>$model->product_id,
                                'ProductDescription'=>$model->product_description,
                                'ProductUnit'=>"Ksh ".$model->unit_price,
                                'Quantity'=>$model->qty,
                                "SubTotal"=>"Ksh ".$model->qty*$model->product_price,
                                'Uom'=>$model->unit,
                                'OrderStatus'=>$model->order_status,
                                'SellerName'=>$model->vconame,
                                'SellerContactPerson'=>$model->sellername,
                                'SellerPhone'=>$model->sellermobilenumber,
                                'SellerAltPhone'=>null,
                                 "ProductCoverImage"=>$image,
                            );
                        }

                        $response['my_orders_list']=$lists;







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


public function CustomerFeedback(Request $request)
{
      $response=array();
      $data=$request->all();

      $errors=array();

       $validator =\Validator::make($data, [
                'orderId'=>'required|exists:orders,id',
            ],['Invalid Order']);
           if ($validator->fails()) 
        {

            $current_errors = $validator->errors();
            foreach($current_errors->all() as $error)
            {
                $errors[]=$error;
            }

            $response['errors']=$errors;
            $response['msg']="Invalid Order ID Provided";
        }
        else
        {
              $model=Order::find($data['orderId']);
                if($model)
                {
                     $model->order_status=$data['OrderStatus'];
                     $model->payment_method=$data['PaymentMethod'];
                      if($model->order_status=="Completed")
                      {
                        $model->amount_paid=$model->qty*$model->unit_price;
                      }
                      
                      $model->save();
                       $user=User::find($model->user_id);
                        
                      $review=new ProductReview();
                      $review->name=$model->customer_name;
                      $review->username=($user)?$user->name:null;
                      $review->rate=$data['Rating'];
                      $review->remarks=$data['CustomerRemarks'];
                      $review->product_id=$model->product_id;
                      $review->order_id=$model->id;
                      $review->user_id=$user->id;
                      $review->save();

                       $response['msg']="Feedback Received Successfully";

                }


                     $response['orderDetails']=array('OrderId'=>$model->id);


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
