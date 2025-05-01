<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Value Chain</title>

    <!-- Scripts -->

   
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
     <link rel="stylesheet" href="{{asset('AdminAssets/css/fontawesome/font-awesome.min.css')}}">
 
    <link rel="stylesheet" href="{{asset('AdminAssets/css/fontawesome/font-awesome-ie7.min.css')}}">
     <link rel="stylesheet" href="{{ asset('backend/vendor/datatables/media/css/dataTables.bootstrap4.css') }}" />
 
   
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}" />
        <style type="text/css">
            .navbar-default {
    background-color: #3a5b35;
   
    font:white;
}
        </style>
    <!-- Styles -->
    
</head>
<body>
    <div id="app">
        <nav class="navbar  navbar-default navbar-expand-md  navbar-light bg-green shadow-sm"  style="height:100px;margin-bottom: 60px;">


            <div class="container"  style="margin-top: -3%;">
                <a class="navbar-brand" href="{{ url('/') }}"   >
                   <img src="{{asset('loginAssets/market.png')}}"  style="margin-left:13%;" height="60px;"  width="650px'" >
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}"  style="color: white;">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    

                    <!-- Right Side Of Navbar -->
                    
                    
                       
                    


                    <ul class="nav navbar-nav navbar-right">
       
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"  style="color:white"><i class="fa fa-user"></i> Login </a>
          <ul class="dropdown-menu">
            <li><a href="{{url('/login')}}">Backend Login</a></li>
          
           
          </ul>
        </li>
      </ul>
                </div>
                 
            </div>
        </nav>

        <main class="py-4">
            @yield('content')

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
        </main>
    </div>
</body>
  <script type="text/javascript" src="{{asset('AdminAssets/js/libs/jquery-1.10.2.min.js')}}"></script>
  <script type="text/javascript" src="{{asset('plugins/jquery-ui/jquery-ui-1.10.2.custom.min.js')}}"></script>

      <script type="text/javascript" src="{{asset('bootstrapAsset/js/bootstrap.min.js')}}"></script>
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
</html>
