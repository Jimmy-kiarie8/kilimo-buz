@extends("layouts.app")




@section('content')
    <p>

                             



                     <div class="col-lg-12">



 
                     



                    <div class="row">

                            <div class="col-md-12">
                                <p>
                                    <a href="<?=url('/System/Roles/Create')?>" class="btn btn-sm btn-info"><span class="fa fa-plus"><span>Add New Roles</a>

                                        <a href="<?=url('/System/Roles/Index')?>" class="btn btn-sm btn-success"><span class="fa fa-bars"><span>List of Roles</a>



                                </p>

                                <section class="card card-featured card-featured-info">
                                <header class="card-header">
                                    <div class="card-actions">
                                        <a href="#" class="card-action card-action-toggle" data-card-toggle=""></a>
                                        <!-- <a href="#" class="card-action card-action-dismiss" data-card-dismiss=""></a> -->
                                    </div>
                                    <h2 class="card-title">Define New System Roles</h2>
                                </header>
                                <div class="card-body" style="display: block;">
                                  <div class="col-md-12">
                                      <form method="post"  action="{{$url}}">
                                        <?=csrf_field()?>
        <div class="form-group col-md-12">
          <label >Name:</label>
          <div ><input type="text" name="name" value="{{old('name')}}" class="form-control"></div>
        </div>
     
       
        
        <div class="form-group col-md-12">
          <label >Description:</label>
          <div ><textarea name="description" class="form-control">{{old('description')}}</textarea> 

          </div>
        </div>
        <div class="form-group col-md-12">
           
             
           
          <legend> Attach Permissions</legend>
          <div class="row">
           <?php foreach($permissions as $permission): ?>
            <div class="col-md-6">
               <strong>{{$permission->perm_category}}</strong>

                <?php $permissions=$permission->getPerms($permission->perm_category); foreach($permissions as $perm):?>

                 <div class="checkbox">

                        <div class="task-check">
                                                        <div class="col-md-12">
                                                          
                                                         <div class="col-md-10">
                                                             <label>
                                                        <input name="permission[]" value="<?=$perm->id;?>"  type="checkbox" >
                                                        <span class="text"> <?=$perm->name;?> </span>
                                                       </label>
                                                             
                                                         </div>
                                                            
                                                        </div>
                                                    </div>
                            
                          </div>



                 <?php endforeach;?>
               </div>
            <?php endforeach;?>
           </div>



          
       
        

             
        </div>
              
        <div class="form-group col-md-12">
          
          
          <button class="btn btn-info">Create</button>
          
        </div>
        </form>
                                    
                                  </div>

                                     

                                </div>
                            </section>
                            </div>



                    </div>


    </div>


@stop
@push('scripts')
     <script>
        
       
    </script>
    
@endpush