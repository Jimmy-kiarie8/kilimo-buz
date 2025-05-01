@extends("layouts.app")


@section('content')



        <!--=== Blue Chart ===-->
           

        <div class="row">
          <div class="col-md-12">
            <div class="widget box">
              <div class="widget-header">
                <h4><i class="icon-reorder"></i>403 Permission Error</h4>
                <div class="toolbar no-padding">
                  <div class="btn-group">
                    <span class="btn btn-xs widget-collapse"><i class="icon-angle-down"></i></span>
                  </div>
                </div>
              </div>
              <div class="widget-content"> 

                <div class="alert alert-warning">
                  <h4>You do not have permission to access this function.Please Contact System Admin for more information</h4>
                  
                </div>
                
               
              </div>
            </div>
          </div>
        </div>
      



    


@stop
@push('scripts')
     
    
@endpush