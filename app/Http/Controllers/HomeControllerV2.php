<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Input;
use App\Audit;
use Modules\Usermanagement\Entities\Orgainization;
use Auth;
use DB;
use App\Helpers\DataProcessor;
use App\Helpers\Helper;

class HomeController extends Controller
{


   protected $userID;
    protected $branchId;
    protected $orgId;
  public function __construct()
    {
       $this->middleware(['auth','history','2fa','firsttimer']);
       $this->middleware(function ($request, $next) {
            $this->userID = Auth::user()->id;
            $this->orgId=Auth::user()->org_id;
            $this->branchId=Auth::user()->branch_id;
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
       //$test=Helper::sendEmail("streetfamilyfund@gmail.com","Test","Some Subject");
       // dd($test);
        return view('home');
    }


    public function wizard()
    {

        return view('wizard');

    }
}
