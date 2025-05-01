<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Modules\Usermanagement\Entities\Institution;
use App\Helpers\Helper;
use DB;
class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }



    public function getDropDownList($procedurename)
    {
         try{
             $models=\DB::connection("sqlsrv")->select('SET NOCOUNT ON exec  [dbo].['.$procedurename.']' );
             return $models;

         }catch(\Exception $e)
         {
             dd($e);

         } 



        

    }



    public function showRegistrationForm()
    {
           //Get Institution Types
         $procedurename="Proc_List_InstitutionTypes";
         $insitutuions=$this->getDropDownList( $procedurename);
         $insitutuionsTypes=(collect($insitutuions)->pluck('INST_Type_Name','INST_Type'));
         //get Registration Bodies
         $procedurename="Proc_List_Registration_Bodies";
         $RegistrationBodies=$this->getDropDownList( $procedurename);
          
         $RegistrationBodies=(collect($RegistrationBodies)->pluck('Institution_Registration_Body','Institution_Registration_Body_Id'));

         //get counties

         $procedurename="Proc_List_County";
         $Counties=$this->getDropDownList( $procedurename);
         $Counties=(collect($Counties)->pluck('CountyName','CountyCode'));

     

         $data['insitutuionTypes']=$insitutuionsTypes->toArray();
         $data['RegistrationBodies']=$RegistrationBodies->toArray();
         $data['counties']=$Counties->toArray();
         $data['model']=new Institution();
         
        
         return view('auth.institutions.register',$data);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
          
         
            
         $messages = [
    'password.regex' => 'Password must be mixture of letter,number and special characters !',
    'phone.regex'=>'Telephone Must start with 07 followed by 8 numerical values with no spacing e.g 07xxyyyzzz',
    'InstitutionBody_Number.unique'=>"Institution With Similar Registration Body  Number".$data['Registration_number']." Already In The System",
   
];


        return Validator::make($data, [
            'name' => ['nullable', 'string', 'max:255'],
            'Institution_EMail' => ['required','email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            'InstitutionBody_Number'=>['required', 'unique:INSTITUTIONS,InstitutionBody_Number'],

             'phone'=>'required|regex:/(07)[0-9]{8}/',

        ],$messages);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {

          
            DB::beginTransaction();


          $model=Institution::where(['Registration_body'=>$data['Registration_body'],'Registration_number'=>$data['Registration_number']])->first();
           
            if(!$model){
                //Check if New Then Create.If Old Return Error Message

                
          $model=new Institution();
          $model->Institution_Name=$data['Institution_Name'];
          $model->Institution_EMail=$data['Institution_EMail'];
          $model->Institution_Type=$data['Institution_Type'];
          $model->Registration_body=$data['Registration_body'];
          $model->Registration_number=$data['Registration_number'];
          $model->County=$data['County'];
          $model->Institution_telphone=$data['phone'];
          $model->INST_Code=Helper::generatePin(12);
          $model->DateCreated=date("Y-m-d H:i:s");
          $model->Financial_Year=Helper::getCurrenFinancialYear(date("Y-m-d"));
          $model->InstitutionBody_Number=$data['InstitutionBody_Number'];
          $model->Verified=0;
          $model->save();
          $model->INST_Code=$model->id;
          $model->save();
            
          

          
        $user= User::create([
            'sirname' => $data['Institution_Name'],
            'firstname'=>$data['Institution_Name'],
            'email' => $data['Institution_EMail'],
            'org_id'=>$model->Id,
            'telephone'=>$data['phone'],
            'username'=>$data['Registration_number'],
            'verification_code'=>Helper::generatePin(25),
            'user_type'=>"External",
            'user_status'=>"Active",
            'role_id'=>'Organization Manager',
            'password' => $data['password'],

        ]); 

         $roles="Organization Manager";
         $user->assignRole($roles);
         DB::commit();

                return $user;


            }

         
    }
}
