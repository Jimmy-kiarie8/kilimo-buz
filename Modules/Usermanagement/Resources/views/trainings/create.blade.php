@extends("layouts.app")


@section('content')



    
         <p>
                                    <a title="Add New Department" href="<?=url('/System/TrainingModule/Create')?>" class="btn btn-sm btn-info"><span class="fa fa-plus"><span>New Training</a>

                                        <a href="<?=url('/System/TrainingModule/Index')?>" class="btn btn-sm btn-success"><span class="fa fa-bars"><span>List of Trainings</a>

                                          <a href="<?=url('/System/TrainingModule/TrainedActors')?>" class="btn btn-sm btn-warning"><span class="fa fa-group"><span>Training Attendace</a>


                                            <a href="<?=url('/System/TrainingModule/ImportAttendance')?>" class="btn btn-sm btn-danger"><span class="fa fa-upload"><span>Import Attendance</a>




                                </p>


        <div class="row">
          <div class="col-md-12">
            <div class="widget box">
              <div class="widget-header">
                <h4><i class="icon-reorder"></i>Create Training</h4>
                <div class="toolbar no-padding">
                  <div class="btn-group">
                    <span class="btn btn-xs widget-collapse"><i class="icon-angle-down"></i></span>
                  </div>
                </div>
              </div>
              <div class="widget-content"> 
              
                   <form action="{{$url}}" method="post"  enctype="multipart/form-data">

                      <?=csrf_field()?>


                        <div class="col-md-12">
                          <div class="row">
                            
                         
                           <div class="col-md-8">
                            <div class="row">
                            <div class="form-group col-md-6">
            <label>Training Name </label>
            



               <input type="text" name="training_name"  class="form-control" required   value="{{old('training_name')}}">
             


           </span>
         </div>


          <div class="form-group col-md-6">
            <label>Training Venue </label>
            <input type="text" name="training_venue"  class="form-control" required   value="{{old('training_venue')}}">
         </div>
                      
                            
                          </div>
                          <div class="row">

                            <div class="form-group col-md-6">
            <label>Training Date </label>
            <input type="text" name="training_date" id="datePicker"  class="form-control" required   value="{{old('training_date')}}">
         </div>



                            <div class="form-group col-md-6">
            <label>Training Facilitator </label>
            <input type="text" name="training_facilitator"  class="form-control" required   value="{{old('training_facilitator')}}">
         </div>
                            

                          </div>

                            <div class="row">

                                <div class="form-group col-md-6">
            <label>Targetted Group </label>
              {{ Form::select('category',([null=>'--Select Group--'] + array("Service Providers"=>"Service Provider","Value Chain Actors"=>"Value Chain Actors","Women & Youth"=>"Women & Youth")), $model->category, ['class'=>'form-control','required'=>'required','id'=>'LibrarSy','style'=>'width:100%']) }}
         </div>

                            <div class="form-group col-md-6">
            <label>Total Male </label>
            <input type="text" name="male_attendees"  class="form-control" required   value="{{old('male_attendees')}}">
         </div>



                            <div class="form-group col-md-6">
            <label>Total Female </label>
            <input type="text" name="female_attendees"  class="form-control" required   value="{{old('female_attendees')}}">
         </div>

          <div class="form-group col-md-6">
            <label>Total Youths </label>
            <input type="text" name="youth_attendees"  class="form-control" required   value="{{old('youth_attendees')}}">
         </div>
                     
                            

                          </div>



                              <div class="row"  style=",margin-top: 5%;">
                               
                                    <div class="form-group col-md-12">
            <label>Training Key Objectives</label>
            <textarea rows="4" name="training_objectives" class="form-control" required></textarea>
         </div>
                                  
                              

                          
                            
                          </div>
                          <p>
                           <div class="row">

                            <div class="form-group col-md-12">
                              <label>Scanned Signed Attendance Sheet(Only PDF Allowed)</label>

                              <input type="file" name="file" required>

                              <span color="green">
                              Image to pdf <a target="_new" href="https://smallpdf.com/jpg-to-pdf">Click Here to Convert</a>
                              
                            </div>
                             

                           </div>

                        
                             
                           </div>

                          <div class="col-md-4">
                            <label>Training Cover Image</label>
                             <div>
                  <img name="images" width="200" height="320" id="image_array1" value="" src="{{asset('placeholder.png')}}" style="width: 100%;height: 200px;" />
                  <!--<div id="image_array1"   ></div> Use This if You want to display Multiple Images--> 
                  <input type="hidden" class="form-control validate" name="primary_image" value="" id="img_id_cover" required>
                  <br/>
                  <a href="#modal-message" class="uploadmodalwidget btn btn-default btn-sm" data-toggle="modal" id="uploadmodal" data-inputid="img_id_cover" data-mode="single" data-divid="image_array1" style="position: absolute;z-index: 1;">Upload Image</a>
                   <!-- Change Data Mode to Multiple if you want to be able to select Multiple Images -->                                   
               
                </div>
                             
                           </div>
                             
                         </div>






                          <div class="row">
    <div class="col-md-12">
       <legend>Training Other Images</legend>
         <h5>Hint:max of 7 images</h5>


        
                  <div class="row">
                    <div id="image_array11"   ></div> 
                  </div>
                 
               
                  <input type="hidden" class="form-control validate" name="primary_images[]"  id="img_ids1" required>
                  <br/>
                  <a href="#modal-message" class="uploadmodalwidget btn btn-default btn-sm" data-toggle="modal" id="uploadmodal" data-inputid="img_ids1" data-mode="multiple" data-divid="image_array11" style="position: absolute;z-index: 1;">Upload Image</a>
                   <!-- Change Data Mode to Multiple if you want to be able to select Multiple Images -->                                   
               
                
      
    </div>
    
    
  </div>
                          
  </div>

 
                          



                          



                           
                             
                          

                         
                        

                          


                            <div class="form-group col-md-12"  style="margin-top:5%;">
                              <div class="row">
                              <button class="btn btn-success">Create</button>
         </div>
                            
                          </div>

                            


                          
                        </div> 
                    


                  </form>
               
              </div>
            </div>
          </div>
        </div>
      



   
@include('partials.upload_widget')


@stop
@push('scripts')
<script src="https://code.jquery.com/ui/1.13.0/jquery-ui.js"></script>
     <script>
        
      
        $( "#datePicker" )
        .datepicker({
          defaultDate: "+0w",
          changeMonth: true,
          changeYear:true,
          numberOfMonths: 1
        });
          
      </script>
    
@endpush