<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Usermanagement\Entities\County;
use Modules\Usermanagement\Entities\ValueChain;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use DB;
use Modules\Usermanagement\Entities\ProductName;
use Modules\Usermanagement\Entities\Product;
use Modules\Usermanagement\Entities\Organization;
class VCOsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['page_title']="Registered VCOs";
       
    $data['count']=Organization::count();

        return view('vcos.index',$data);
    }

    public function CountyStats()
    {

         $data['page_title']="Registered VCOs";
       
    $data['count']=47;

        return view('vcos.county',$data);

    }


      public function getCheckProductName(Request $request)
      {
         $data=$request->all();
          $group_id=$data['groupids'];
           $products=Product::join('value_chains','value_chains.id','=','products.value_chain_id')
             ->select('products.id','value_name','uom','variety','quantity_available','products.unit_price','product_code','product_image')
             ->whereNotNull('product_image') 
             ->whereIn('value_chain_id',$group_id)->paginate(50);
             $data['products']= $products;


           return view('_productspartial',$data);




      }


      public function getCountyPostedValuechainName(Request $request)
      {
         $data=$request->all();
           
                $models=DB::select("select distinct  value_chain_id,value_name,county_name from products
 join  value_chains on value_chains.id=products.value_chain_id
 where county_id= ? and is_deleted is null",[$data['County']]);

                 if(sizeof($models)):
                     echo '<option value="0">----All Value Chains----</option>';

                  foreach($models as $model)
                  {
                      echo '<option value="'.$model->value_chain_id.'">'.$model->value_name.'</option>';
                  }

              endif;

         

      }

     


    public function fetchList()
    {
        try{
            $models=DB::select("SELECT organizations.id,org_name,org_number,nodename,counties.county_name,value_name ,subcountyname,ward_name,date_registered,date(organizations.created_at) created_at FROM `organizations` 
join  counties on counties.id=organizations.county_id
join sub_counties on sub_counties.id=organizations.sub_county_id
join value_chains on value_chains.id=organizations.value_chain_id");


        }catch(\Exception $e)
        {

            $models=array();

        }



         
         return Datatables::of($models)->make(true);
    }


    public function fetchListCountyStats()
    {
        try{
             $models=DB::select("SELECT county_name,count(organizations.county_id) as vcos,sum(isMale) as Males,sum(IsFemale) as Female,sum(isMale+IsFemale) as total FROM counties
        left join organizations on organizations.county_id=counties.id
        left join vco_members on organizations.id=vco_members.org_id group by  county_name");


        }catch(\Exception $e)
        {
             
            $models=array();

        }





         return Datatables::of($models)->make(true);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
