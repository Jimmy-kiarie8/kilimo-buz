<!DOCTYPE html>

<html lang="en">
<!--<![endif]-->

<head>
	<meta charset="utf-8" />
	<title>KILIMOBUZ|E-Commerce</title>
	<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
	<meta content="" name="description" />
	<meta content="" name="author" />
	
	<!-- ================== BEGIN BASE CSS STYLE ================== -->
	<link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
	<link href="{{ asset('front/assets/plugins/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet" />
	<link href="{{ asset('front/assets/plugins/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet" />
	<link href="{{ asset('front/assets/css/style.min.css')}}" rel="stylesheet" />
	<link href="{{ asset('front/assets/css/style-responsive.min.css')}}" rel="stylesheet" />
	<link href="{{ asset('front/assets/css/theme/default.css')}}" id="theme" rel="stylesheet" />
	<link href="{{ asset('front/assets/css/animate.min.css')}}" rel="stylesheet" />

	<link rel="stylesheet" href="{{ asset('backend/vendor/datatables/media/css/dataTables.bootstrap4.css') }}" />
	<!-- ================== END BASE CSS STYLE ================== -->
	
	<!-- ================== BEGIN BASE JS ================== -->
	<script src="{{ asset('front/assets/plugins/pace/pace.min.js')}}"></script>
	<!-- ================== END BASE JS ================== -->
</head>
<body>

<!-- BEGIN #page-container -->
<div id="page-container" class="fade">

@include('front.header')
@yield('crumb')
@yield('content')

   <div class="modal fade " id="county-modal" role="dialog">
                <div class="modal-dialog modal-lg">
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

              
@include('front.footer')
</div>
    <!-- END #page-container -->

	<!-- ================== BEGIN BASE JS ================== -->
	<script src="{{ asset('front/assets/plugins/jquery/jquery-1.9.1.min.js')}}"></script>
	<script src="{{ asset('front/assets/plugins/jquery/jquery-migrate-1.1.0.min.js')}}"></script>
	<script src="{{ asset('front/assets/plugins/bootstrap/js/bootstrap.min.js')}}"></script>
	<!--[if lt IE 9]>
		<script src="{{ asset('front/assets/crossbrowserjs/html5shiv.js')}}"></script>
		<script src="{{ asset('front/assets/crossbrowserjs/respond.min.js')}}"></script>
		<script src="{{ asset('front/assets/crossbrowserjs/excanvas.min.js')}}"></script>
	<![endif]-->

	   <script src="{{ asset('AdminAssets/datatables/media/js/jquery.dataTables.min.js') }}"></script>    
    <script src="{{ asset('AdminAssets/datatables/media/js/dataTables.bootstrap4.min.js') }}"></script>    
    <script src="{{ asset('AdminAssets/datatables/extras/TableTools/Buttons-1.4.2/js/dataTables.buttons.min.js') }}"></script> 
    <script src="{{ asset('AdminAssets/datatables/extras/TableTools/Buttons-1.4.2/js/buttons.bootstrap4.min.js') }}"></script>   
    <script src="{{ asset('AdminAssets/datatables/extras/TableTools/Buttons-1.4.2/js/buttons.html5.min.js') }}"></script>    
    <script src="{{ asset('AdminAssets/datatables/extras/TableTools/Buttons-1.4.2/js/buttons.print.min.js') }}"></script>    
    <script src="{{ asset('AdminAssets/datatables/extras/TableTools/JSZip-2.5.0/jszip.min.js') }}"></script>   



    <script src="{{ asset('AdminAssets/datatables/extras/TableTools/pdfmake-0.1.32/pdfmake.min.js') }}"></script>    
    <script src="{{ asset('AdminAssets/datatables/extras/TableTools/pdfmake-0.1.32/vfs_fonts.js') }}"></script>
    <script>
	<script src="{{ asset('front/assets/plugins/jquery-cookie/jquery.cookie.js')}}"></script>
	<script src="{{ asset('front/assets/js/apps.min.js')}}"></script>
	<!-- ================== END BASE JS ================== -->
	
	<script>
	    $(document).ready(function() {
	        App.init();
	    });
	</script>

	 <script type="text/javascript">
   
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

	 @stack('scripts')

</body>

</html>

