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
                            
                         
                           <div class="col-md-8">
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
            <input type="text" name="product_uom"  class="form-control" required   value="{{old('product_uom')}}">
         </div>


                  <div class="form-group col-md-6">
            <label>Market Index/Average Price </label>
            <input type="text" name="product_price"  class="form-control" required   value="{{old('product_price')}}">
         </div>
                            

                          </div>

                           <div class="row">

                            <div class="form-group col-md-12">
            <label>Product Description</label>
            <textarea rows="4" name="product_description" class="form-control" required></textarea>
         </div>
                            
                          </div>
                             
                           </div>

                          <div class="col-md-4">
                            <label>Product Cover Image</label>
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
       <legend>Product Other Images</legend>


        
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
     <script>
        
          
      </script>
    
@endpush