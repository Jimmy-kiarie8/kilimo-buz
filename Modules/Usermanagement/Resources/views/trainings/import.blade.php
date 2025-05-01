@extends("layouts.app")


@section('content')


        <!--=== Blue Chart ===-->
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
                <h4><i class="icon-reorder"></i>Import Training Attendance </h4>
                <div class="toolbar no-padding">
                  <div class="btn-group">
                    <span class="btn btn-xs widget-collapse"><i class="icon-angle-down"></i></span>
                  </div>
                </div>
              </div>
              <div class="widget-content"> 
                 <form role="form" action="{{$url}}" method="post"  enctype="multipart/form-data">
                                                            <?=csrf_field()?>
                                        
                                        

                                       <div class="row">
                                          <div class="col-md-6">

                                            <legend>Import Instuructions</legend>
                                           <ol>
                                            <li>Ensure You are using MS Office</li>
                                             <li>Only Excel/CSV Files are allowed</li>
                                              <li>A Maximum of 3000 record per sheet are allowed</li>

                                              <li>Stick To Provided Template</li>
                                              <li>Download  Import Template 
                                                <a href="{{url('memberTemplate.xlsx')}}">Download Link</a></li>
                                           </ol>
                                            
                                          </div>
                                          <div class="col-md-6">
                                            
                                         
                                                <div class="form-group col-md-12">
                                                                <label>County</label>
                                                        
                                                        {{ Form::select('county_id',([null=>'--Select County--'] + $counties), null, ['class'=>'form-control','required'=>'required','id'=>'County','style'=>'width:100%']) }}
                                                                   
                                                               
                                                            </div>

                                                            <div class="form-group col-md-12">
                                        <label>Training Name</label>
                                        <select name="training_id" class="form-control" required>
                                          <option value="">---Select Training--</option>
                                           <?php foreach($trainings as $training):?>
                                            <option value="{{$training->id}}">{{$training->training_name}}</option>

                                            <?php endforeach;?>
                                          
                                          
                                        </select>
                                                        
                                                       
                                                                   
                                                               
                                                            </div>

                                                   
                                    
                                       
                                                <div class="form-group col-md-12">
                                                                <label>Select File</label>
                                                        
                                                       <input type="file"
                                                                   class="form-control" name="file_name" placeholder="Ward"  required >
                                                                   
                                                               
                                                            </div>

                                                    
                                 


                                     
                                                <div class="form-group col-md-6">
                                                    <button class="btn btn-info">Import</button>
                                                </div>
                                      
                                      </div>




                                      </form>

               
              </div>
            </div>
          </div>
        </div>
      



    


@stop
@push('scripts')
     <script>
        $("#County").on("change",function(e){
          e.preventDefault();
             var value=$(this).val();
               var url="<?=url('/System/VCOMembers/GetCountyList')?>/"+value;
                 $.get(url,function(data){
                   $("#Name").html(data);

                 });

        });
      
          
          </script>
    
@endpush