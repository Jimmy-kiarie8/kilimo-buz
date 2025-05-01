@extends("layouts.app")


@section('content')


<!--=== Blue Chart ===-->
<p>
  <a href="<?=url('/System/Users/Create')?>" class="btn btn-sm btn-info"><span class="fa fa-plus"><span>Add New User</a>

    <a href="<?=url('/System/Users/Index')?>" class="btn btn-sm btn-success"><span class="fa fa-bars"><span>List of System Users</a>



    </p>

    <div class="row">
      <div class="col-md-12">
        <div class="widget box">
          <div class="widget-header">
            <h4><i class="icon-reorder"></i>Create New County User Account</h4>
            <div class="toolbar no-padding">
              <div class="btn-group">
                <span class="btn btn-xs widget-collapse"><i class="icon-angle-down"></i></span>
              </div>
            </div>
          </div>
          <div class="widget-content"> 
           <form role="form" action="{{$url}}" method="post">
            <?=csrf_field()?>
            <div class="row">




             <div class="form-group col-md-6">
              <label>Staff Name</label>
              <input type="text" class="form-control" id="Name" placeholder="Name" value="{{(isset($model->name))?$model->name:old('name')
            }}"  name="name" required>
          </div>

          <div class="form-group col-md-6">
            <label>Email Address</label>
            <input type="email" class="form-control" name="email" id="email" placeholder="Email Address" value="{{(isset($model->email))?$model->email:old('email')}}"  required>
          </div>



        </div>
        <div class="row">


         <div class="form-group col-md-6">
          <label>Telephone</label>

          <input type="text"
          id="Phone" class="form-control" name="telephone" placeholder="Phone" value="{{old('telephone')}}" required >


        </div>

        <div class="form-group col-md-3">
          <label>User Role</label>
          <span class="input-icon icon-right">
            {{ Form::select('role_id',([null=>'--Select Role--'] + $roles), $model->role_id, ['class'=>'form-control','required'=>'required','id'=>'Role','style'=>'width:100%']) }}

          </span>
        </div>


         <div class="form-group col-md-3 ">
          <label>Node Name</label>
          <span class="input-icon icon-right">
            {{ Form::select('node_id',([null=>'--Select Node--'] + $nodes), $model->sid, ['class'=>'form-control','required'=>false,'id'=>'CountyId','style'=>'width:100%']) }}
            
          </span>
        </div>



      </div>


      <div class="row">
        <div class="form-group col-md-6">
          <label>Password</label>

          <input type="password" class="form-control" id="passwordInput" placeholder="Password" name="password" value="{{old('password')}}">


        </div>

        <div class="form-group col-md-6">
          <label>Confirm Password</label>

          <input type="password" class="form-control" id="confirmPasswordInput" name="password_confirmation" placeholder="Confirm Password" value="{{old('password_confirmation')}}">


        </div>
      </div>

      <div class="row">
        <div class="form-group col-md-6">
          <button class="btn btn-info"><?=($model->exists)?"Update":"Create"?></button>
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

   $("#Role").on("click",function(e){
    e.preventDefault();
       var value=$(this).val();
          if(value=="County Co-ordinator")
          {
            $(".CountyControls").removeClass("hidden");
             $(".CountyId").attr("required",true);
          }else{
            $(".CountyControls").addClass("hidden");
            $(".CountyId").attr("required",false);
          }

   });


</script>

@endpush