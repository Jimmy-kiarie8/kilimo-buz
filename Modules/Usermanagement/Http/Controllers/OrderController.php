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
use Modules\Usermanagement\Entities\Order;
class OrderController extends Controller
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
            $data['page_title']="Orders";
        return view('usermanagement::orders.index',$data);
    } else{
        return view("forbidden");
    }
    }
    public function Pending()
    {
         $data['page_title']="Orders";
        return view('usermanagement::orders.pending',$data);
    }

    public function completed()
    {
        $data['page_title']="Completed Orders";
        return view('usermanagement::orders.completed',$data);

    }

    public function fetchList()
    {
         $models=DB::select("select orders.id,value_chain_name, variety,ref_number,customer_name,customer_phone,qty,unit,products.unit_price,order_date,countyname,vconame,sellername,sellermobilenumber from orders
join products on products.id=orders.product_id order by orders.id desc limit 1000");

                    return Datatables::of($models)->make(true);

    }

    public function fetchVCOCList()
    {
          $models=Order::join('product_names','product_names.product_code','=','orders.product_code')
                    ->select('orders.id','order_date','customer_name','customer_phone','ref_number','product_name','product_names.product_code','qty','unit','order_status')
                    ->join('organizations','organizations.id','=','orders.org_id')
                    ->where(['orders.org_id'=>$this->sid,'order_status'=>"Completed"]);

          return Datatables::of($models)
          ->rawColumns(['action'])
          ->addColumn('action', function ($model) {
              $edit_url=url('/System/Order/MarkComplete/'.$model->id);
               $detele_url=url('/System/Member/Remove/'.$model->id);
                        return '<div class="dropdown">
  <button class="btn btn-success btn-xs dropdown-toggle" type="button" data-toggle="dropdown">Action
  <span class="caret"></span></button>
  <ul class="dropdown-menu">
    

     <li><a style="cursor:pointer;" class="reject-modal"   data-title="Complete Order Transaction" data-url="'.$edit_url.'">&nbsp;&nbsp;&nbsp;&nbsp;Mark As Completed</a></li>

     <li><a style="cursor:pointer;" class="reject-modal"   data-title="Remove Member From List" data-url="'.$detele_url.'">&nbsp;&nbsp;&nbsp;&nbsp;Mark As Cancelled</a></li>
    
    </ul>
</div> 
';
            })->make(true);

    }

    public function fetchVCOList()
    {
          $models=Order::join('product_names','product_names.product_code','=','orders.product_code')
                    ->select('orders.id','order_date','customer_name','customer_phone','ref_number','product_name','product_names.product_code','qty','unit','order_status')
                    ->join('organizations','organizations.id','=','orders.org_id')
                    ->where(['orders.org_id'=>$this->sid,'order_status'=>"Pending"]);

          return Datatables::of($models)
          ->rawColumns(['action'])
          ->addColumn('action', function ($model) {
              $edit_url=url('/System/Order/MarkComplete/'.$model->id);
               $detele_url=url('/System/Member/Remove/'.$model->id);
                        return '<div class="dropdown">
  <button class="btn btn-success btn-xs dropdown-toggle" type="button" data-toggle="dropdown">Action
  <span class="caret"></span></button>
  <ul class="dropdown-menu">
    

     <li><a style="cursor:pointer;" class="reject-modal"   data-title="Complete Order Transaction" data-url="'.$edit_url.'">&nbsp;&nbsp;&nbsp;&nbsp;Mark As Completed</a></li>

     <li><a style="cursor:pointer;" class="reject-modal"   data-title="Remove Member From List" data-url="'.$detele_url.'">&nbsp;&nbsp;&nbsp;&nbsp;Mark As Cancelled</a></li>
    
    </ul>
</div> 
';
            })->make(true);
    }


    public function MarkComplete($id,Request $request)
    {
         $model=Order::find($id);

           $data['model']=$model;
           $data['url']=url()->current();
               if($request->isMethod("post"))
               {
                 $data=$request->all();
                  $model->order_status="Completed";
                  $model->payment_method=$data['payment_method'];
                  $model->amount_paid= doubleval(str_replace(",","",$data['amount_paid']));
                  $model->unit_price=doubleval(str_replace(",","",$data['unit_price']));
                  $model->save();
                   Session::flash("success_msg","Details Updated Successfully");
                   return redirect()->back();
               }
            return view('usermanagement::orders.complete',$data);



    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('usermanagement::create');
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
