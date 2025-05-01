@extends("layouts.app")


@section('content')
           <p>
<a href="<?=url('System/Staff/CreateNew')?>" class="btn btn-sm btn-primary"><span class="fa fa-bars"><span>Add New Staff</a>
<a href="<?=url('/System/Staff/Index')?>" class="btn btn-sm btn-success"><span class="fa fa-bars"><span>List of Staffs </a>
 </p>
<div class="row">
          <div class="col-md-12">
            <div class="widget box">
              <div class="widget-header">
                <h4><i class="icon-reorder"></i>Add New Staff Details</h4>
                <div class="toolbar no-padding">
                  <div class="btn-group">
                    <span class="btn btn-xs widget-collapse"><i class="icon-angle-down"></i></span>
                  </div>
                </div>
              </div>
              <div class="widget-content"> 
                <form action="{{$url}}" method="post">
                   <?=csrf_field()?>
                   <div class="row">
                   <div class="col-md-4 form-group">
                    <label>Title</label>
                     {{ Form::select('title',([null=>'--Select Title--'] + $titles), $model->title, ['class'=>'form-control','required'=>'required','id'=>'LibrarSy','style'=>'width:100%']) }}
                     </div>
                    <div class="col-md-4 form-group">
                      <label>Full Names</label>
                      <input type="text" name="name" class="form-control" required value="{{$model->name}}" style="text-transform: uppercase;">
                      
                    </div>

                    <div class="col-md-4 form-group">
                      <label>ID Number</label>
                      <input type="text" name="id_no" class="form-control" required value="{{$model->id_no}}" >
                      
                    </div>


                     
                   </div>
                    <div class="row">

                      <div class="col-md-4 form-group">
                    <label>Designition</label>
                     {{ Form::select('designition',([null=>'--Select Designition--'] + $designitions), $model->designition, ['class'=>'form-control','required'=>'required','id'=>'degnition','style'=>'width:100%']) }}
                     </div>


                    <div class="col-md-4 form-group">
                    <label>Job Group</label>
                     {{ Form::select('job_group_id',([null=>'--Select Job Group--'] + $job_groups), $model->job_group_id, ['class'=>'form-control','required'=>'required','id'=>'LibrarSy','style'=>'width:100%']) }}
                     </div>


                      <div class="col-md-4 form-group">
                    <label>Department Name</label>
                     {{ Form::select('dep_id',([null=>'--Select Department--'] + $departments), $model->dep_id, ['class'=>'form-control','required'=>'required','id'=>'Dep','style'=>'width:100%']) }}
                     </div>

                     <div class="col-md-4 form-group">
                      <label>Personal Number</label>
                      <input type="text" name="personal_number" class="form-control" required value="{{$model->personal_number}}" >
                      
                    </div>
                    <div class="col-md-4 form-group">
                      <label>Official Email Address</label>
                      <input type="email" name="email" class="form-control" required value="{{$model->email}}" >
                      
                    </div>
                     <div class="col-md-4 form-group">
                      <label>Telephone</label>
                      <input type="text" name="telephone" class="form-control" required value="{{$model->telephone}}" >
                      
                    </div>
                  </div>

                   <div class="row">
                    <div class="col-md-4 form-group">
                      <label>Date of Birth</label>
                      <input type="text" name="dob" class="form-control" required value="{{$model->dob}}" id="dob">
                      
                    </div>
                     <div class="col-md-4 form-group">
                      <label>Gender</label>
                      {{ Form::select('gender',([null=>'--Select Gender--'] + array("Male"=>"Male","Female"=>"Female","Intersex"=>"Intersex")), $model->gender, ['class'=>'form-control','required'=>'required','id'=>'Status','style'=>'width:100%']) }}
                      
                    </div>
                      <div class="form-group col-md-4">
                                <label>County</label>
                                {{ Form::select('county',([null=>'--Select County--'] + $counties), $model->county, ['class'=>'form-control','required'=>'required','id'=>'county','style'=>'width:100%']) }}
                                
                            </div>
                            <div class="form-group col-md-4">
                                <label>Sub County</label>
                                {{ Form::select('sub_county',([null=>'--Select Sub County--'] +$subcounties), $model->sub_county, ['class'=>'form-control','required'=>'required','id'=>'subCounty','style'=>'width:100%']) }}
                                
                            </div>

                            <div class="form-group col-md-4">
                                <label>Ward</label>
                                <input type="text" class="form-control"  value="{{$model->ward}}" name="ward" required>
                                
                            </div>
                             <div class="form-group col-md-4">
                                <label>Ethnicity</label>
                                {{ Form::select('ethinicity',([null=>'--Select Tribe--'] +$tribes), $model->ethinicity, ['class'=>'form-control','required'=>'required','id'=>'ethinicity','style'=>'width:100%']) }}
                                
                            </div>
                             <div class="form-group col-md-4">
                                <label>Religion</label>
                                {{ Form::select('religion',([null=>'--Select Religion--'] +$religions), $model->religion, ['class'=>'form-control','required'=>'required','id'=>'ethinicity','style'=>'width:100%']) }}
                                
                            </div>
                             <div class="form-group col-md-4">
                                <label>Highiest Academic Qualification</label>
                                {{ Form::select('qualification',([null=>'--Select Qualifications--'] +$qualifications), $model->religion, ['class'=>'form-control','required'=>'required','id'=>'ethinicity','style'=>'width:100%']) }}
                                
                            </div>
                             <div class="col-md-4 form-group">
                      <label>Qualification Field/Description</label>
                      <input type="text" name="qualification_field" class="form-control" required value="{{$model->qualification_field}}" >
                      
                    </div>
                    <div class="col-md-4 form-group">
                      <label>Date of Employment</label>
                      <input type="text" name="date_employed" class="form-control" required value="{{$model->date_employed}}" id="doe">
                      
                    </div>

                   

                     <div class="col-md-4 form-group">
                      <label>Terms Of Service</label>
                      {{ Form::select('terms_of_service',([null=>'--Select Employment Type--'] + array("Permanent & Pensionable"=>"Permanent & Pensionable","Contract"=>"Contract","Temporary"=>"Temporary")), $model->employment_type, ['class'=>'form-control','required'=>'required','id'=>'Terms','style'=>'width:100%']) }}
                      
                    </div>
                     <div class="col-md-4 form-group contract hidden">
                      <label>Contract Start Date</label>
                      <input type="text" name="contract_start_date" class="form-control mycontract"  value="{{$model->contract_start_date}}" id="from">
                      
                    </div>

                     <div class="col-md-4 form-group contract hidden">
                      <label>Contract End Date</label>
                      <input type="text" name="contract_end_date" class="form-control mycontract"  value="{{$model->contract_end_date}}" id="to">
                      
                    </div>
                     <div class="col-md-4 form-group ">
                      <label>Living With Disabilities</label>
                      {{ Form::select('living_with_disability',([null=>'--Select One--'] + array("Yes"=>"Yes","No"=>"No")), $model->living_with_disability, ['class'=>'form-control','required'=>'required','id'=>'IsDisabled','style'=>'width:100%']) }}
                      
                    </div>
                     <div class="form-group col-md-4 disabled hidden">
                                <label>NCPWD Reg No</label>
                                <input type="text" class="form-control"  value="{{$model->ncpwd_regno}}" name="ncpwd_regno" >
                                
                  </div>
                     <div class="form-group col-md-4 disabled hidden">
                                <label>Disability Type</label>
                                <input type="text" class="form-control"  value="{{$model->disability_type}}" name="disability_type" >
                                
                  </div>
                  <input type="hidden" id="Eighteen" value='<?=date('Y', strtotime(date('Y-m-d') . "-18 years"))?>'>



 



                     
                   </div>
                  
                  
                   <div class="row">
                    <div class="col-md-12 form-group">
                      <button class="btn btn-primary"><?=($model->exists)?"Update"  :"Create"?></button>
                    </div>
                  </div>
                  

                </form>
               
              </div>
            </div>
          </div>
        </div>
      



    


@stop
@push('scripts')
<script src="{{ asset ('http://cdn.ckeditor.com/4.5.7/standard/ckeditor.js')}}" type="text/javascript"></script>

      <script>
  $( function() {
    var dateFormat = "mm/dd/yy",
      from = $( "#from" )
        .datepicker({
          defaultDate: "+1w",
          changeMonth: true,
          numberOfMonths: 1
        })
        .on( "change", function() {
          to.datepicker( "option", "minDate", getDate( this ) );
        }),
      to = $( "#to" ).datepicker({
        defaultDate: "+1w",
        changeMonth: true,
        numberOfMonths: 1
      })
      .on( "change", function() {
        from.datepicker( "option", "maxDate", getDate( this ) );
      });
 
    function getDate( element ) {
      var date;
      try {
        date = $.datepicker.parseDate( dateFormat, element.value );
      } catch( error ) {
        date = null;
      }
 
      return date;
    }
  } );
  </script>
  <script type="text/javascript">
    
   $("#Terms").on("change",function(e){
      e.preventDefault();
          var value=$(this).val();
              if(value=="Contract")
              {
                $(".contract").removeClass("hidden");
                $(".mycontract").attr("required",true);
              }else{
                 $(".mycontract").attr("required",false);
                 $(".contract").addClass("hidden");
              }
     });


    $("#IsDisabled").on("change",function(e){
      e.preventDefault();
         var value=$(this).val();
            if(value=="Yes")
            {
                $(".disabled").removeClass("hidden");
                $(".npwd").attr("required",true);
            }else{
                 $(".disabled").addClass("hidden");
                  $(".npwd").attr("required",false);
            }

     });


  </script>
  <script type="text/javascript">
    var start=$("#Eighteen").val();
    var end=start-75;
    var myrange=end+":"+start;
    

    $( "#dob" )
        .datepicker({
          defaultDate: "+1w",
          changeMonth: true,
          changeYear:true,
           yearRange: myrange,
          numberOfMonths: 1
        });

        $("#doe").datepicker({
          defaultDate: "+1w",
          changeMonth: true,
          changeYear:true,
          numberOfMonths: 1,
          maxDate:0,
          yearRange: "-55:+0"
        });

  </script>
    
@endpush