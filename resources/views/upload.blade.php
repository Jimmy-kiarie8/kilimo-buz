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
                <h4><i class="icon-reorder"></i> List Of Users Registered In The System</h4>
                <div class="toolbar no-padding">
                  <div class="btn-group">
                    <span class="btn btn-xs widget-collapse"><i class="icon-angle-down"></i></span>
                  </div>
                </div>
              </div>
              <div class="widget-content"> 
                <div>
                  <img name="images" width="200" height="200" id="image_array1" value="" src="{{asset('/placeholder.png')}}" style="width: 100%;height: 159px;" />
                  <!--<div id="image_array1"   ></div> Use This if You want to display Multiple Images--> 
                  <input type="hidden" class="form-control validate" name="primary_image" value="" id="img_ids1" required>
                  <br/>
                  <a href="#modal-message" class="uploadmodalwidget btn btn-success btn-sm" data-toggle="modal" id="uploadmodal" data-inputid="img_ids1" data-mode="single" data-divid="image_array1" style="position: absolute;z-index: 1;">Upload Image</a>
                   <!-- Change Data Mode to Multiple if you want to be able to select Multiple Images -->                                   
               
                </div>
               
              </div>
            </div>
          </div>
        </div>
      



    
@include('partials.upload_widget')

@stop
@push('scripts')
 
    
@endpush