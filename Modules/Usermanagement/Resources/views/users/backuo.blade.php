@extends('layouts.main')


@section('breadcrumb')
<header class="page-header">
                        <h2>User Management</h2>
                    
                        <div class="right-wrapper text-right">
                            <ol class="breadcrumbs">
                                <li>
                                    <a href="<?=url('/home')?>">
                                        <i class="fa fa-home"></i>
                                    </a>
                                </li>

                                <li>
                                    <a href="<?=url()->current()?>">System Users</a>
                                </li>
                                <li class="active">
                                    <span>Index</span>
                                </li>

                
                            </ol>
                    
                            <a class="sidebar-right-toggle" data-open="sidebar-right"><i class="fa fa-chevron-left"></i></a>
                        </div>
</header>
@stop


@section('content')
    <p>

                             



                     <div class="col-lg-12">



 
                     



                    <div class="row">

                            <div class="col-md-12">
                              <p>
                                    <a href="<?=url('/System/Users/CreateAccount')?>" class="btn btn-sm btn-info"><span class="fa fa-plus"><span>Add New User</a>

                                        <a href="<?=url('/System/Users/Index')?>" class="btn btn-sm btn-success"><span class="fa fa-bars"><span>List of Users</a>
                               </p>
                                

                                <section class="card card-featured card-featured-info">
                                <header class="card-header">
                                    <div class="card-actions">
                                        <a href="#" class="card-action card-action-toggle" data-card-toggle=""></a>
                                        <!-- <a href="#" class="card-action card-action-dismiss" data-card-dismiss=""></a> -->
                                    </div>
                                    <h2 class="card-title">Create New Internal System User Account</h2>
                                </header>
                                <div class="card-body" style="display: block;">

                                    <form role="form" action="{{$url}}" method="post">
                                                            <?=csrf_field()?>
                                        <div class="row">

                                           <div class="form-group col-md-6">
                                                                <label>Name</label>
                                                                <span class="input-icon icon-right">
                                                                    <input type="text" class="form-control" id="userameInput" placeholder="Name" value="{{(isset($model->name))?$model->name:old('name')
                                                                }}"  name="name">
                                                                    <i class="glyphicon glyphicon-user circular"></i>
                                                                </span>
                                                            </div>
                                                            <div class="form-group col-md-6">
                                                                <label>Email Address</label>
                                                                <span class="input-icon icon-right">
                                                                    <input type="email" class="form-control" name="email" id="emailInput" placeholder="Email Address" value="{{(isset($model->email))?$model->email:old('email')
                                                                }}">
                                                                   
                                                                </span>
                                                            </div>
                                          

                                        </div>
                                        <div class="row">

                                           <div class="form-group col-md-6">
                                                                <label>Telephone</label>
                                                                <span class="input-icon icon-right">
                                                                  <input type="text" class="form-control" name="telephone" placeholder="Phone" value="{{old('telephone')}}" >
                                                                   
                                                                </span>
                                                            </div>

                                             <div class="form-group col-md-6">
                                                                <label>Personal Number</label>
                                                                <span class="input-icon icon-right">
                                                              <input type="text" class="form-control" name="id_number" placeholder="personal Number" value="{{old('id_number')}}">
                                                                   
                                                                </span>
                                                            </div>
                                            </div>
                                        <div class="row">
                                                <div class="form-group col-md-6">
                                                                <label>Gender</label>
                                                                <span class="input-icon icon-right">
                                                             {{ Form::select('gender',([null=>'--Select Gender--'] + array("Male"=>"Male","Female"=>"Female")), @$profile->gender, ['class'=>'form-control','required'=>'required','id'=>'Gender','style'=>'width:100%']) }}
                                                                   
                                                                </span>
                                                            </div>

                                                     <div class="form-group col-md-6">
                                                                <label>User Role</label>
                                                                <span class="input-icon icon-right">
                                                            {{ Form::select('role_id',([null=>'--Select Role--'] + $roles), $model->role_id, ['class'=>'form-control','required'=>'required','id'=>'Role','style'=>'width:100%']) }}
                                                                   
                                                                </span>
                                                            </div>

                                                      
                                      </div>

                                       <div class="row">
                                                <div class="form-group col-md-6">
                                                                <label>Password</label>
                                                        <span class="input-icon icon-right">
                                                        <input type="password" class="form-control" id="passwordInput" placeholder="Password" name="password" value="{{old('password')}}">
                                                                   
                                                                </span>
                                                            </div>

                                                     <div class="form-group col-md-6">
                                                                <label>Confirm Password</label>
                                                                <span class="input-icon icon-right">
                                                            <input type="password" class="form-control" id="confirmPasswordInput" name="password_confirmation" placeholder="Confirm Password" value="{{old('password_confirmation')}}">
                                                                   
                                                                </span>
                                                            </div>
                                      </div>

                                       <div class="row">
                                                <div class="form-group col-md-6">
                                                    <button class="btn btn-info"><?=($model->exists)?"Update":"Create"?></button>
                                                </div>
                                        </div>




                                      </form>

                                     

                                </div>
                            </section>
                            </div>

                           



                    </div>


    </div>


@stop
@push('scripts')
     <script>
      $("#Library").select2();
      

      $("body").on("change","#Role",function(e){
        e.preventDefault(); 
          var value=$(this).val();
             if(value.length>0)
             {
                 if(value=="Librarian" )
                 {
                   $(".library").removeClass("hidden");
                 }else{
                  $(".library").addClass("hidden");
                 }

             }

      });
        
      
    </script>
    
@endpush