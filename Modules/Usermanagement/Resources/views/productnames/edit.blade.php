@extends("layouts.app")


@section('content')



    
           <p>
                                    <a title="Add New Department" href="<?=url('/System/ProductNames/Create')?>" class="btn btn-sm btn-info"><span class="fa fa-plus"><span>New Product Name</a>

                                        <a href="<?=url('/System/ProductNames/Index')?>" class="btn btn-sm btn-success"><span class="fa fa-bars"><span>List of Product Names </a>



                                </p>


        <div class="row">
          <div class="col-md-12">
            <div class="widget box">
              <div class="widget-header">
                <h4><i class="icon-reorder"></i>Create New Product Name</h4>
                <div class="toolbar no-padding">
                  <div class="btn-group">
                    <span class="btn btn-xs widget-collapse"><i class="icon-angle-down"></i></span>
                  </div>
                </div>
              </div>
              <div class="widget-content"> 
              
                  <form  action="{{$url}}"  method="post">
                      <?=csrf_field()?>


                        <div class="col-md-12">
                          <div class="row">
                            <div class="form-group col-md-6">
            <label>Value Chain </label>
            <span class="input-icon icon-right">
             {{ Form::select('value_chain_id',([null=>'--Select Value Chain--'] + $values), $model->value_chain_id, ['class'=>'form-control','required'=>'required','id'=>'LibrarSy','style'=>'width:100%']) }}


           </span>
         </div>


          <div class="form-group col-md-6">
            <label>Product Name </label>
            <input type="text" name="product_name"  class="form-control" required   value="{{old('product_name')}}">
         </div>
                      
                            
                          </div>

                          <div class="row">

                            <div class="form-group col-md-6">
            <label>Product Color </label>
            <input type="text" name="product_color"  class="form-control" required   value="{{old('product_color')}}">
         </div>



                            <div class="form-group col-md-6">
            <label>Unit of Measure </label>
            <input type="text" name="product_uom"  class="form-control" required   value="{{$model->product_uom}}">
         </div>
                            

                          </div>

                          <div class="row">

                            <div class="form-group col-md-12">
            <label>Product Description</label>
            <textarea rows="4" name="product_description" class="form-control" required></textarea>
         </div>
                            
                          </div>

                          <div class="row">


                            <div class="form-group col-md-12">
                              <button class="btn btn-success">Create</button>
         </div>
                            
                          </div>

                            


                          
                        </div> 
                    


                  </form>
               
              </div>
            </div>
          </div>
        </div>
      



   
{{ Widget::MediaUploaderWidget() }} 


@stop
@push('scripts')
     <script>
        
          
      </script>
    
@endpush