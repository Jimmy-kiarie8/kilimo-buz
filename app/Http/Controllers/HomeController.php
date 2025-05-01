<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Helpers\Helper;
use DB;
use Modules\Usermanagement\Entities\County;
class HomeController extends Controller
{
    
     protected $userID;
    protected $mid;
    protected $sid;
  public function __construct()
    {
      $this->middleware(['auth']);
        
       
        $this->middleware(function ($request, $next) {
            $this->userID = Auth::user()->id;
            $this->sid=Auth::user()->org_id;

            return $next($request);
        });
    }


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    { 
         $user=Auth::user();
           


         if(Auth::User()->hasRole(['SuperAdmin']))
         {
            $data['page_title']="Admin Dashboard";
            //$test=Helper::sendSMS("254708236804","TEST SMS SEND FROM ASDSP PORTAL");
            // dd($test);
              
              
            $data['models']=County::orderBy('county_name')->get();

           
             return view('dashboards.admin',$data);

         }
         else if(Auth::User()->hasRole(['Organization']))
         {
            $data['page_title']="Applicant Dashboard";
            
            
             return view('dashboards.vco',$data);

         }

         else if(Auth::User()->hasRole(['County Co-ordinator']))
         {
            $data['page_title']="County Dashboard";
            $data['models']=County::where(['id'=>$this->sid])->orderBy('county_name')->get();
            
             return view('dashboards.county',$data);

         }

          else if(Auth::User()->hasRole(['Buyer']))
         {
            $data['page_title']="My Dashboard";
           
            
             return view('dashboards.myaccount',$data);

         }




       



         else{
            return view("forbidden");
         }
       
    }
}
