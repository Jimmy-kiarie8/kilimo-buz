<?php

namespace Modules\Usermanagement\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller ;
use Modules\Usermanagement\Entities\Department;
use Modules\Usermanagement\Entities\County;
use Modules\Usermanagement\Entities\ValueChain;
use Modules\Usermanagement\Entities\ProductName;
use Modules\Usermanagement\Entities\TrainingPhoto;
use Modules\Usermanagement\Entities\ProductMetaData;
use Modules\Usermanagement\Entities\CountyValueChain;
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
use Excel;
use App\Imports\MemberImport;
use App\Helpers\Helper;
use Modules\Usermanagement\Entities\UnitOfMeasure;
use Modules\Usermanagement\Entities\Training;
use Modules\Usermanagement\Entities\TrainingAttendance;
class TrainingController extends Controller
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
        if(Auth::User()->hasRole('County Co-ordinator'))
         {
             $data['page_title']="List of Trainings";
       
         return view('usermanagement::trainings.index',$data);

    }else{
        return view("forbidden");
    }
    }

    public function Admin()
    {
       if(Auth::User()->hasRole('SuperAdmin'))
         {
             $data['page_title']="List of Trainings";
       
         return view('usermanagement::trainings.adminindex',$data);

    }else{
        return view("forbidden");
    }

    }

    public function TrainedActors()
    {
        if(Auth::User()->hasRole('County Co-ordinator'))
         {
             $data['page_title']="Trained Actors/Service Providers";
       
         return view('usermanagement::trainings._index',$data);

    }else{
        return view("forbidden");
    }

    }

    public function Trainees()
    {
       if(Auth::User()->hasRole('SuperAdmin'))
         {
             $data['page_title']="list of Trainees";
       
         return view('usermanagement::trainings.trainees',$data);

    }else{
        return view("forbidden");
    }

    }

    public function ViewDetails($id)
    {
       $model=TrainingAttendance::find($id);
       $traing=Training::find($model->training_id);
       $data['model']=$model;
       $data['training']=$traing;
       return view('usermanagement::trainings._view',$data);

    }

    public function ViewGallery($id)
    {
      $model=Training::find($id);
       $data['model']=$model;
        $data['photos']=DB::select("SELECT training_photos.id,uploads.filename,`image_id` FROM `training_photos` join uploads on uploads.id=training_photos.image_id WHERE training_id=?",[$id]);

       return view('usermanagement::trainings._gallery',$data);


    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create(Request $request)
    {
         if(Auth::User()->hasRole('County Co-ordinator'))
         {
             $data['page_title']="New Training";
             $data['model']=new Training();
             $data['url']=url()->current();
                if($request->isMethod("post"))
                {
                    $this->validate($request,[
                  'file'=>'required|file|mimes:pdf|max:10000',
                  'training_name'=>'required|string',
                  'training_venue'=>'required',
                  'training_date'=>'required',
                  'training_facilitator'=>'required',

                 ]);
         $data=$request->all();
                     $data=$request->all();
                      DB::beginTransaction();
                      $model=new Training();
                      $model->county_id=$this->sid;
                      $model->training_code=Helper::generatePin(8);
                      $model->training_name=$data['training_name'];
                      $model->training_venue=$data['training_venue'];
                      $model->training_date=date('Y-m-d',strtotime($data['training_date']));
                      $model->training_facilitator=$data['training_facilitator'];
                      $model->category=$data['category'];
                      $model->male_attendees=$data['male_attendees'];
                      $model->female_attendees=$data['female_attendees'];
                      $model->youth_attendees=$data['youth_attendees'];
                      $model->training_objectives=$data['training_objectives'];
                      $model->cover_image=$data['primary_image'];
                      $model->save();
                        if(isset($data['primary_images']))
                        {
                             $images=$data['primary_images'];
                              if(is_array($images) && sizeof($images)>0)
                              {
                                  $images=$images[0];
                             $image_array=explode(",", $images);
                               foreach($image_array as $key)
                               {
                                  if(strlen($key))
                                  {
                                    $image=new TrainingPhoto();
                                    $image->county_id=$model->county_id;
                                    $image->training_id=$model->id;
                                    $image->image_id=$key;
                                    $image->created_by=$this->userID;
                                    $image->save();
                                  }

                               }

                              }
                            


                        }
                     

                       


                       $photo=$data['file'];

    $extension =$photo->getClientOriginalExtension();


    $doc_name="training_".$model->id.'_regform'.".".$extension;
      
     $fileName =date('Ymdhis').'_doc.'.$extension; // renameing image
     $directory="trainingDocuments";
     $str=str_replace('/', '',  $doc_name);
     $str=str_replace('-', '', $str);
     $result = \File::exists($photo);

     if($result)
     {
       \Storage::disk('local')->put($directory."/".$str,  \File::get($photo));
       $file_name=$photo->getFilename().'.'.$extension;
       $model->support_evidence=$doc_name;
       $model->save();

   }
      DB::commit();



                      //add training images
                      Session::flash("success_msg","Training Added Successfully");
                      return redirect('/System/TrainingModule/Index');
                     
                }
        return view('usermanagement::trainings.create',$data);

         }else{

            return view("forbidden");

         }
       
    }

    public function fetchAdminList()
    {
        $models=DB::select("SELECT trainings.id,counties.county_name,cover_image,training_name,training_date,category,training_venue,training_facilitator,male_attendees,filename,female_attendees,youth_attendees,trainings.created_at FROM trainings
join counties on counties.id=trainings.county_id
join uploads on uploads.id=trainings.cover_image
");
           return Datatables::of($models)
            ->rawColumns(['action','cover_image'])
              ->addColumn('details_url', function($user) {
            return url('/System/TrainingModule/getMyAttendance/' . $user->id);
        })
             ->editColumn('cover_image',function($model){
              
                if(strlen($model->cover_image)>0)
                {

                   $url=asset('uploads/'.$model->filename); 
                }else{
                      $url=asset("placeholder.png");
                }
              

               $view_url=url('/backend/directors/view/'.$model->id);

              return '<img src='.$url.' data-title="View Manager-Summary View" border="0" width="120" height="100"  data-url="'.$view_url.'" class="img-rounded pop-modal" align="center" cursor="pointer"  style="cursor:pointer;border-radius:5%" title="View Details"    />';

           })
         
          ->addColumn('action', function ($model) {
              $edit_url=url('/System/Entities/EditDetails/'.$model->id);
              $trainee_url=url('/System/TrainingModule/AddAttendance/'.$model->id);

               $view_url=url('/System/TrainingModule/ViewEvidence/'.$model->id);
                $gallery_url=url('/System/TrainingModule/ViewGallery/'.$model->id);
                        return '

                         <div class="dropdown">
  <button class="btn btn-success btn-xs dropdown-toggle" type="button" data-toggle="dropdown">Action
  <span class="caret"></span></button>
  <ul class="dropdown-menu">

   <li><a style="cursor:pointer;" class="reject-modal"  data-title="View Attendace Sign Sheet" data-url="'.$view_url.'"><i class="icol-font"></i> Support Evidence</a></li>
   
  
  
   

     <li><a style="cursor:pointer;" class="reject-modal"   data-title="View Gallery" data-url="'.$gallery_url.'"><i class="icon-camera-retro"></i>Training Gallery</a></li>

      <li><a style="cursor:pointer;"   data-title="View Attendace Sign Sheet" ><i class="icol-picture"></i>Print Certficates</a></li>
    
    </ul>
</div> 
';
            })->make(true);

    }


    public function fetchList()
    {
         $models=DB::select("SELECT trainings.id,counties.county_name,training_name,training_date,category,training_venue,training_facilitator,male_attendees,female_attendees,youth_attendees,trainings.created_at FROM trainings
join counties on counties.id=trainings.county_id
WHERE county_id=?",[$this->sid]);
           return Datatables::of($models)
          ->rawColumns(['action'])
          ->addColumn('action', function ($model) {
              $edit_url=url('/System/Entities/EditDetails/'.$model->id);
              $add_url=url('/System/TrainingModule/AddAttendance/'.$model->id);

               $view_url=url('/System/TrainingModule/ViewEvidence/'.$model->id);
                        return '<div class="dropdown">
  <button class="btn btn-success btn-xs dropdown-toggle" type="button" data-toggle="dropdown">Action
  <span class="caret"></span></button>
  <ul class="dropdown-menu">
    <li><a style="cursor:pointer;"  title="Edit" href="'.$edit_url.'">&nbsp;&nbsp;&nbsp;&nbsp;Edit Details</a></li>
 <li><div class="dropdown-divider"></div></li>

    <li><a style="cursor:pointer;" class="reject-modal"  data-title="Add New Attendee" data-url="'.$add_url.'">&nbsp;&nbsp;&nbsp;&nbsp;Add Service Provider</a></li>
 <li><div class="dropdown-divider"></div></li>
    <li><a style="cursor:pointer;" class="reject-modal"  data-title="View Attendace Sign Sheet" data-url="'.$view_url.'">&nbsp;&nbsp;&nbsp;&nbsp;Support Evidence</a></li>
    
    </ul>
</div> 
';
            })->make(true);
    }


    public function fetchTRainees()
    {
       $models=DB::select("SELECT  county_name,trainings.training_name,trainings.category,training_attendances.id,fullnames,telephone,gender,email_address,id_number,station_location,age_bracket,training_attendances.created_at FROM `training_attendances` 
join counties on counties.id=training_attendances.county_id
join trainings on trainings.id=training_attendances.training_id");

          return Datatables::of($models)
          ->rawColumns(['action'])
          ->addColumn('action', function ($model) {
              $edit_url=url('/System/TrainingAttendance/ViewDetails/'.$model->id);
             
                        return '<div class="dropdown">
  <button class="btn btn-success btn-xs dropdown-toggle" type="button" data-toggle="dropdown">Action
  <span class="caret"></span></button>
  <ul class="dropdown-menu">
     <li><a style="cursor:pointer;" class="reject-modal"  data-title="View Trainee Details" data-url="'.$edit_url.'">&nbsp;&nbsp;&nbsp;&nbsp;View Details</a></li>

    </ul>
</div> 
';
            })->make(true);

    }


    public function getMyAttendance($id)
    {
       $models=TrainingAttendance::where(['training_id'=>$id]);
       return Datatables::of($models)->make(true);

    }


    public function fetchAttendances()
    {
        $models=DB::select("SELECT  county_name,trainings.training_name,trainings.category,training_attendances.id,fullnames,telephone,gender,email_address,id_number,station_location,age_bracket,training_attendances.created_at FROM `training_attendances` 
join counties on counties.id=training_attendances.county_id
join trainings on trainings.id=training_attendances.training_id
WHERE training_attendances.county_id=?",[$this->sid]);

          return Datatables::of($models)
          ->rawColumns(['action'])
          ->addColumn('action', function ($model) {
              $edit_url=url('/System/TrainingAttendance/EditDetails/'.$model->id);
             
                        return '<div class="dropdown">
  <button class="btn btn-success btn-xs dropdown-toggle" type="button" data-toggle="dropdown">Action
  <span class="caret"></span></button>
  <ul class="dropdown-menu">
     <li><a style="cursor:pointer;" class="reject-modal"  data-title="Edit Details" data-url="'.$edit_url.'">&nbsp;&nbsp;&nbsp;&nbsp;Edit Details</a></li>

    </ul>
</div> 
';
            })->make(true);
    }



    public function AddAttendance($id,Request $request)
    {
         $model=new TrainingAttendance();
         $data['url']=url()->current();
         $data['model']=$model;
             if($request->isMethod("post"))
             {
                 $data=$request->all();
                   $model=new TrainingAttendance();
                   $model->county_id=$this->sid;
                   $model->training_id=$id;
                   $model->fullnames=$data['fullnames'];
                   $model->telephone=Helper::processNumber($data['telephone']);
                   $model->email_address=$data['email_address'];
                   $model->gender=$data['gender'];
                   $model->id_number=$data['id_number'];
                   $model->age_bracket=$data['age_bracket'];
                   $model->station_location=$data['station_location'];
                     if($model->gender=="Male")
                     {
                        $model->is_male=1;
                   $model->is_female=0;

                     }else{
                         $model->is_male=0;
                   $model->is_female=1;


                     }
                     $model->save();
                     Session::flash("success_msg","Actor/Provider added Successfully");
                     return redirect()->back();
                   
                  
             }
           return view('usermanagement::trainings._attendee',$data);

    }

    public function ViewEvidence($id)
    {
         $model=Training::find($id);
         $data['model']=$model;


           return view('usermanagement::trainings._evidence',$data);

    }

    public function EditAttendance($id,Request $request)
    {
          $model=TrainingAttendance::find($id);
         $data['url']=url()->current();
         $data['model']=$model;
             if($request->isMethod("post"))
             {
                 $data=$request->all();
                  
                   $model->fullnames=$data['fullnames'];
                   $model->telephone=Helper::processNumber($data['telephone']);
                   $model->email_address=$data['email_address'];
                   $model->gender=$data['gender'];
                   $model->id_number=$data['id_number'];
                   $model->age_bracket=$data['age_bracket'];
                   $model->station_location=$data['station_location'];
                     if($model->gender=="Male")
                     {
                        $model->is_male=1;
                   $model->is_female=0;

                     }else{
                         $model->is_male=0;
                   $model->is_female=1;


                     }
                     $model->save();
                     Session::flash("success_msg","Actor/Provider Updated Successfully");
                     return redirect()->back();
                   
                  
             }
           return view('usermanagement::trainings._e_attendee',$data);

    }


    public function ImportAttendance(Request $request)
    {
        if(Auth::user()->hasRole(["SuperAdmin","County Co-ordinator","Organization"]))
         {
            $data['page_title']="Import";
              if(Auth::User()->hasRole("SuperAdmin"))
              {
                 $data['counties']=County::pluck('county_name','id')->toArray();

              }else if(Auth::User()->hasRole("County Co-ordinator")){
                 $data['counties']=County::where('id',$this->sid)->pluck('county_name','id')->toArray();
              }else{
                 $data['counties']=array();
              }
              $data['trainings']=Training::where(['county_id'=>$this->sid])->get();

           
            $data['url']=url()->current();
                if($request->isMethod("Post"))
                { ini_set('memory_limit', '-1');
                   $data=$request->all();

                     
                    $file_name=$data['file_name'];
                      $path1 = $file_name->store('temp'); 
$path=storage_path('app').'/'.$path1;  
                 
                 $array=  Excel::toarray(new MemberImport, $path);
                  array_splice($array[0], 0, 1);
                  $not_list=array();
                     foreach($array[0] as $row)
                     {
                         $idnum=$row[0];
                         $name=$row[1];
                         $phone=$row[2];
                         $gender=$row[3];
                         $station_location=$row[4];
                         $ageset=$row[5];
                           if($gender=="Male")
                           {
                            $is_male=1;
                            $is_female=0;
                           }else{
                             $is_male=0;
                            $is_female=1;

                           }

                           $countyId=$data['county_id'];
                           $training_id=$data['training_id'];
                           $model=TrainingAttendance::where(['training_id'=>$training_id,'id_number'=>$idnum,'county_id'=>$countyId])->first();
                            if(!$model)
                            {
                                $model=new TrainingAttendance();
                                $model->training_id=$training_id;
                                $model->county_id=$countyId;

                            }
                            $model->fullnames=$name;
                            $model->id_number=$idnum;
                            $model->telephone=Helper::processNumber($phone);
                            $model->gender=$gender;
                            $model->is_male=$is_male;
                            $model->is_female=$is_female;
                            $model->station_location=$station_location;
                            $model->age_bracket= $ageset;
                            $model->save();

                          
                       
                       
                      
                     }
                       
               
                  
                   Session::flash("success_msg","Attendance Imported Succesfully");
                   return redirect('/System/TrainingModule/TrainedActors');
                }

        return view('usermanagement::trainings.import',$data);

    }else{
        return view("forbidden");
    }


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
