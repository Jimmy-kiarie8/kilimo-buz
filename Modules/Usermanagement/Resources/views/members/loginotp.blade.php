@extends("layouts.app")


@section('content')



    
         
         
        <div class="row">
          <div class="col-md-12">
            <div class="widget box">
              <div class="widget-header">
                <h4><i class="icon-reorder"></i>Retrieve Member/VCA Mobile OTP  </h4>
                <div class="toolbar no-padding">
                  <div class="btn-group">
                    <span class="btn btn-xs widget-collapse"><i class="icon-angle-down"></i></span>
                  </div>
                </div>
              </div>
              <div class="widget-content"> 

                <div class="row">

                  <div class="col-md-3">
                    <input type="text" name="Telephone" placeholder="Mobile Number" id="Telephone" class="form-control">
                    
                  </div>
                   <div class="col-md-1">
                    <button class="btn btn-xs btn-success" id="Retrieve"> <span class="fa fa-search"></span>  Query/Retrieve</button>
                    
                  </div>
                  
                </div>
                 <div class="row">

                  <div class="col-md-12" id="Results">
                    

                  </div>


                 </div>
              
                  
                    

               
              </div>
            </div>
          </div>
        </div>
      



    


@stop
@push('scripts')
    
    <script>
       
        $("#Retrieve").on("click",function(e){
          e.preventDefault();
          var Telephone=$("#Telephone").val();
           if(Telephone.length>0)
           {

             var url="<?=url('/System/VCOMemberOTP/GetOTP')?>";

              $.get(url,{'Telephone':Telephone},function(data){
                 $("#Results").html("");
                 $("#Results").html(data);


              });



           }



        });




      
          
          </script>
    
@endpush