<?php

namespace Modules\Usermanagement\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller ;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Session;
use App\User;
use Auth;
use DB;
use Input;
use Modules\Usermanagement\Entities\Profile;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class SecurityController extends Controller
{
      protected $userID;
    protected $mid;
    protected $OrgID;
  public function __construct()
    {
       $this->middleware('auth');
        
       
        $this->middleware(function ($request, $next) {
            $this->userID = Auth::user()->id;
            $this->OrgID=Auth::user()->org_id;

            return $next($request);
        });
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function ChangePassword(Request $request)
    {
        if(Auth::User()->hasRole("Organization"))
         {
            $data['page_title']="Change Password";
            $data['user']=Auth::user();
            $data['url']=url()->current();
                if($request->isMethod("post"))
                {
                    $data=$request->all();
                    $user = auth()->user();
        
                $validated = $request->validate([
                    'current_password' => [
                        'required',
                        
                        function ($attribute, $value, $fail) use ($user) {
                            if (!Hash::check($value, $user->password)) {
                                $fail('Your password was not updated, since the provided current password does not match.');
                            }
                        }
                    ],
                    'password' => [
                        'required', 'min:6', 'confirmed', 'different:current_password'
                    ]
                ]);

                $user->fill([
                    'password' =>$data['password']
                ])->save();

                $request->session()->flash('success_msg', 'Your password has been updated successfully.');

                return back();
                }
              return view('usermanagement::security.password',$data);



         }else{
           return view("forbidden");
         }
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
