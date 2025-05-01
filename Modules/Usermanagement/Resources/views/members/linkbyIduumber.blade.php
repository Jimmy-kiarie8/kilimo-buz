@extends("layouts.app")


@section('content')



    
         
         
        <div class="row">
          <div class="col-md-12">
            <div class="widget box">
              <div class="widget-header">
                <h4><i class="icon-reorder"></i>Link Members(VCA) To VCO </h4>
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


                    <div class="form-group col-md-4">
                      <label>County Name</label>
                      

                      {{ Form::select('org_id',([null=>'--Select County Name--'] + $counties), null, ['class'=>'form-controls','required'=>'required','id'=>'countyName','style'=>'width:100%']) }}
                    </div>
                    <div class="form-group col-md-4">
                      <label>VCO Name</label>
                      

                      {{ Form::select('county_id',([null=>'--Select County Name--'] + array()), null, ['class'=>'form-controls','required'=>'required','id'=>'VCOName','style'=>'width:100%']) }}
                    </div>
                     <div class="form-group col-md-4">
                      <label>Member  Name</label>
                     {{ Form::select('member_id',([null=>'--Select Member Name--'] + array()), null, ['class'=>'form-controls','required'=>'required','id'=>'MemberName','style'=>'width:100%']) }}

                    </div>

                  


                    
                 </div>

                  <div class="row">
                    <div class="form-group col-md-4">
                      <label>Gender</label>
                        {{ Form::select('gender',([null=>'--Select Sex--'] + array("Male"=>"Male","Female"=>"Female")), $model->gender, ['class'=>'form-control','required'=>'required','id'=>'county','style'=>'width:100%']) }}


                    </div>
                    <div class="form-group col-md-4">
                      <label>National ID Number</label>
                      <input type="text" id="IDNumber" name="id_number" class="form-control" value="{{$model->id_number}}" required>
                    </div>
                        <div class="form-group col-md-4">
                      <label>Telephone</label>
                      <input type="text" name="member_telephone" required="required" value="{{$model->member_telephone}}" class="form-control"  id="Telephone">
                    </div>
                      
                    

                 </div>
                 <div class="card-footer text-right">
                    <button class="btn btn-primary mr-1" type="submit">Complete/Link</button>
                  </div>
                      

                    </form>
                    

               
              </div>
            </div>
          </div>
        </div>
      



    


@stop
@push('scripts')
    
    <script>

       $("#countyName,#VCOName,#MemberName").select2();
        $("#countyName").on("change",function(e){
          e.preventDefault();
             var value=$(this).val();
               var url="<?=url('/System/VCOMembers/GetCountyList')?>/"+value;
                 $.get(url,function(data){
                   $("#VCOName").html(data);

                 });

        });



        $("#VCOName").on("change",function(e){
          e.preventDefault();
             var value=$(this).val();
               var url="<?=url('/System/VCOMembers/GetMemberList')?>/"+value;
                 $.get(url,function(data){
                   $("#MemberName").html(data);

                 });

        });



         $("#MemberName").on("change",function(e){
          e.preventDefault();
             var value=$(this).val();
               var url="<?=url('/System/VCOMembers/GetMemberDetails')?>/"+value;
                 $.get(url,function(data){
                   $("#IDNumber").val(data.IDNumber);
                    $("#Telephone").val(data.Telephone);

                 });

        });

      
          
          </script>
    
@endpush