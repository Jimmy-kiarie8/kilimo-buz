<?php

namespace Modules\Usermanagement\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Usermanagement\Entities\ValueChain;
use Modules\Usermanagement\Entities\CountyValueChain;
use Modules\Usermanagement\Entities\Organization;
use Modules\Usermanagement\Entities\Member;
use Modules\Usermanagement\Entities\Product;
use Modules\Usermanagement\Entities\County;
use App\User;
use Auth;
use DB;
class DashboardController extends Controller
{
     protected $userID;
    protected $mid;
    protected $sid;
  public function __construct()
    {
      
        $this->middleware(['auth','setup','securex']);
        
       
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

    public function ValueChainsSt()
    {
         $models=DB::select("SELECT value_chain_id,value_chains.value_name,count(organizations.id) as number FROM organizations join value_chains on value_chains.id=organizations.value_chain_id WHERE county_id=? group by value_chain_id,value_name",[$this->sid]);
          $data=array();
             foreach($models as $model)
             {
                $data[]=array('name'=>$model->value_name,'y'=>$model->number);
             }
             return $data;

    }
    public function index()
    {
        return view('usermanagement::index');
    }

    public function MapData(Request $request)
    {
          $data=$request->all();
         
          $name=$data['id'];
          $model=County::where(['county_name'=>$name])->first();
            if($model)
            {
                $models=DB::select('SELECT DISTINCT products.value_chain_id,value_chains.value_name ,format(sum(quantity_available*unit_price),2) as amount FROM `products` join organizations on organizations.id=products.org_id join value_chains on value_chains.id=products.value_chain_id where organizations.county_id=? GROUP by value_chain_id union select "","Net Value",format(sum(quantity_available*unit_price),2) from products join organizations on organizations.id=products.org_id where organizations.county_id=?',[$model->id,$model->id]);


                  echo  "<table border='1' cellspacing='1'  cellpadding='1'  style='width:100%'>
      <tr>
      <th colspan='4' ><center>".$name."</center></th>
      </tr>
     ";
       foreach($models as $mod):

     echo "<tr><td>".substr($mod->value_name, 0,25)."&nbsp;&nbsp;&nbsp;</td><td style='text-align:right'>&nbsp;&nbsp;".$mod->amount."</td></tr>";

        endforeach;
        "

      </table>

     ";
       
        }else{
                 return "County Details Not Found";
            }

    }


    public function MDashboard()
    {
        if(Auth::User()->hasRole(["County Co-ordinator","SuperAdmin"]))
          {
            $data['page_title']="Survey Dashboard";
            return view('dashboards.surveydash',$data);


          }else{
            return view("forbidden");
          }

    }

    public function MainData()
    {
          if(Auth::User()->hasRole("County Co-ordinator"))
          {

            $totalAdverts=CountyValueChain::where(['county_id'=>$this->sid])->count();
        $users=Organization::where(['county_id'=>$this->sid])->count();
        $applicants=Member::join('organizations','organizations.id','=','vco_members.org_id')
         ->where(['county_id'=>$this->sid])
        ->count();
        $applications=Product::join('organizations','organizations.id','=','products.org_id')
         ->where('county_id',$this->sid)->sum('quantity_available');
        $data=array("Adverts"=>$totalAdverts,
                    "UserCount"=>$users,
                    "ApplicantCount"=>$applicants,
                    "JobApplicantions"=>$applications,

            );

          }else{

            $totalAdverts=ValueChain::count();
        $users=Organization::count();
        $applicants=Member::count();
        $applications=Product::sum('quantity_available');
        $data=array("Adverts"=>$totalAdverts,
                    "UserCount"=>$users,
                    "ApplicantCount"=>$applicants,
                    "JobApplicantions"=>$applications,

            );

          }
        

        return $data;

    }

    public function getToptenProductByValue()
    {
         if(Auth::User()->hasRole("County Co-ordinator"))
         {
              $models=DB::select('SELECT products.value_chain_id,value_name,sum(`quantity_available`) as  number,sum(quantity_available*unit_price) as estimate_amount FROM `products`
join value_chains on value_chains.id=products.value_chain_id
join organizations on organizations.id=products.org_id
where organizations.county_id=?
group by value_chain_id,value_name order by estimate_amount desc limit 10',[$this->sid]);

         }else{
             $models=DB::select('SELECT `value_chain_id`,value_name,sum(`quantity_available`) as  number,sum(quantity_available*unit_price) as estimate_amount FROM `products`
join value_chains on value_chains.id=products.value_chain_id
group by value_chain_id,value_name order by estimate_amount desc limit 10');

         }
       
          foreach($models as $model)
          {
            echo '<tr><td>'.$model->value_name.'</td><td>'.$model->number.'</td><td>'.number_format($model->estimate_amount,2).'</td</tr>';
          }
         
    }

    public function GetGenStats()
    {
          if(Auth::User()->hasRole("County Co-ordinator"))
          {
             $models=DB::select('SELECT DISTINCT value_chain_organizations.node_id,node_types.node_name,count(`org_id`) as number FROM value_chain_organizations 
                join node_types on node_types.id=value_chain_organizations.node_id
                join organizations on organizations.id=value_chain_organizations.org_id
                where county_id=?
         group by node_id',[$this->sid]);

          }else{
             $models=DB::select('SELECT DISTINCT `node_id`,node_types.node_name,count(`org_id`) as number FROM value_chain_organizations join node_types on node_types.id=value_chain_organizations.node_id
         group by node_id');

          }
       
          $data=array();
            foreach($models as $model)
            {
                 $data[]=array('name'=>$model->node_name,'y'=>$model->number);
            }

            return $data;
    }


    public function GetSurveyGData(Request $request)
    {
        $requestdata=$request->all();
        $column=$requestdata['Param'];

           $models=DB::select("select ".$column." as name,count(id) as number from  mombasa_fish_surveys group by ".$column);


        $data=array();
            foreach($models as $model)
            {
                 $data[]=array('name'=>$model->name,'y'=>$model->number);
            }

            return $data;
        }

    public function GetSubCountyB(Request $request)
    {
           $requestdata=$request->all();
        $column=$requestdata['Param'];


        $subcounties=array("Likoni","Jomvu","Kisauni","Nyali","Mvita");

        $big_data=array();
        
           



           $models=DB::select("select  distinct ".$column." as name from  mombasa_fish_surveys ");
                foreach($models as $model)
                {
                     $name=$model->name;
                      
                       $small_data=array();
                      foreach($subcounties as $county)
                      {
                        $countmodel=DB::select("select count(id) number from  mombasa_fish_surveys  where ".$column." =? and SubCounty=?",[$name,$county]);
                          $number=$countmodel[0]->number;
                             $small_data[]=intval($number);
                         }


                         $big_data[]=array("name"=>$name,'data'=>$small_data);


                    

                }

                 return $big_data;



         
    }

    public function getTopValuePerformance(Request $request)
    {
         $postdata=$request->all();

             if($postdata['param']==1)
             {
                $models=DB::select('SELECT value_chain_id,value_name,count(organizations.id) as number from organizations join value_chains on value_chains.id=organizations.value_chain_id group by value_chain_id order by  number  desc limit 10');

             }else{

                $models=DB::select('SELECT value_chain_id,value_name,count(organizations.id) as number from organizations join value_chains on value_chains.id=organizations.value_chain_id group by value_chain_id order by  number  asc limit 10');

             }

           
              ;
               $data=array();
               $series_data=array();
                 foreach($models as $model)
                 {
                    $data[]=array("name"=>$model->value_name,'y'=>$model->number,'drilldown'=>$model->value_chain_id);

                    $series_name=$model->value_name;
                    $smodels=DB::select("SELECT county_id,county_name,count(o.id) as no FROM organizations o join counties c on c.id=o.county_id WHERE value_chain_id=? group by county_id,county_name",[$model->value_chain_id]);

                      $dril_data=array();
                        foreach($smodels as $dmodel)
                        {
                            $dril_data[]=array($dmodel->county_name,$dmodel->no);

                        }

                        $series_data[]=array("name"=>$series_name,
                               "id"=>$model->value_chain_id,
                               "data"=>$dril_data,

                             );

                 }

                 

                 $big_data=array("data"=>$data,'series'=>$series_data);

                 return $big_data;
    }

    public function CountValueQty()
    {
          $models=DB::select(" select node_name,count(m.id) as number from node_types join value_chain_organizations o on o.node_id=node_types.id  join vco_members m on m.org_id=o.org_id group by node_name");
         $data=array();
            foreach($models as $model)
            {
                 $data[]=array('name'=>$model->node_name,'y'=>$model->number);
            }

            return $data;

    }

    public function GetMonthStats(Request $request)
    {
         

          $models=DB::select("select value_name,count(m.id) as number from value_chains join  organizations  o on o.value_chain_id=value_chains.id  join vco_members m on m.org_id=o.id group by value_name order by  number desc limit 10 ");
         $data=array();
            foreach($models as $model)
            {
                 $data[]=array('name'=>$model->value_name,'y'=>$model->number);
            }

            return $data;

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
