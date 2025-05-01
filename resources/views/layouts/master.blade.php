<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>ASDSP</title>
    <meta content="" name="descriptison">
    <meta content="" name="keywords">

@include('layouts.partials.stylesheets')

    <!-- =======================================================
    * Template Name: Company - v2.1.0
    * Template URL: https://bootstrapmade.com/company-free-html-bootstrap-template/
    * Author: BootstrapMade.com
    * License: https://bootstrapmade.com/license/
    ======================================================== -->
    <div class="view" id="intro" >
        <div class="ful-bg-img">

        </div>
    </div>
</head>

<body>

<!-- ======= Header ======= -->
@include('layouts.partials.header')

<!-- ======= Hero Section ======= -->

@yield('main')

 <div class="modal fade" id="county-modal" role="dialog">
                <div class="modal-dialog ">
                  <div class="modal-content">        

                   
                    <div class="modal-header">
                      <h4 class="modal-title" > 
                          &nbsp;&nbsp;<span id="my-header">
                      Give Reason(s)</span></h4>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

                      
                    </div>
                   
                    
                    <div class="modal-body" id="load-county-details">
                    
                    </div>               
                   
                     
                  </div>
                </div>
              </div>



<!-- ======= Footer ======= -->
@include('layouts.partials._footer')

<a href="#" class="back-to-top"><i class="icofont-simple-up"></i></a>

@include('layouts.partials.scripts')

 <script>


          $(document).on('click','.reject-modal',function(){

           

           var head=$(this).attr('data-title');
                  
               var url=$(this).attr("data-url");
                $("#load-county-details").html("");
                $("#my-header").html(" ");
                $("#my-header").html(head);
                $("#county-modal").modal("show");
            $("#load-county-details").load(url,function(data){
            $("#county-modal").modal("show");
             
          });
       });
  </script>




</body>

</html>
