<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0" />
      <title><?=(isset($page_title))?$page_title:config('app.name')?></title>

  <!--=== CSS ===-->

  <!-- Bootstrap -->

  
  <link href="{{asset('bootstrapAsset/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />

 
  <link href="{{asset('AdminAssets/css/main.css')}}" rel="stylesheet" type="text/css" />
  <link href="{{asset('AdminAssets/css/plugins.css')}}" rel="stylesheet" type="text/css" />
  <link href="{{asset('AdminAssets/css/responsive.css')}}" rel="stylesheet" type="text/css" />
  <link href="{{asset('AdminAssets/css/icons.css')}}" rel="stylesheet" type="text/css" />
   <meta name="csrf-token" content="{{ csrf_token() }}" />

  <link rel="stylesheet" href="{{asset('AdminAssets/css/fontawesome/font-awesome.min.css')}}">
 
  <link rel="stylesheet" href="{{asset('AdminAssets/css/fontawesome/font-awesome-ie7.min.css')}}">
 
  <!--[if IE 8]>
    <link href="assets/css/ie8.css" rel="stylesheet" type="text/css" />
  <![endif]-->
  <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,600,700' rel='stylesheet' type='text/css'>

   <link rel="stylesheet" href="{{ asset('backend/vendor/datatables/media/css/dataTables.bootstrap4.css') }}" />
  <style type="text/css">
     td.details-control {
    background: url('{{asset("/details_open.png")}}') no-repeat center center;
    cursor: pointer;
}
tr.shown td.details-control {
    background: url('{{asset("/details_close.png")}}') no-repeat center center;
}
    th, td { white-space: nowrap; }

    .navbar {
    background: #56964d;
    min-height: 48px;
    
}
  </style>

  <!--=== Upload CSS Files ===-->

  <!-- End Upload CSS Files -->

  <script type="text/javascript">
    var imageid;
    var inputid;   
    var mode;
    var images = [];
    var imageids = [];
    var dataid;
    var dataurl;
    var baseurl='<?php echo url('/'); ?>';
    var counter=0;
  </script>
  <script type="text/javascript">
      var uploadurl="<?php echo url('/System/file/upload'); ?>";
  </script>

  <link rel="stylesheet" href="{{ asset ('file_upload/css/style.css') }}">
  <!-- blueimp Gallery styles -->
  <link rel="stylesheet" href="//blueimp.github.io/Gallery/css/blueimp-gallery.min.css">
  <!-- CSS to style the file input field as button and adjust the Bootstrap progress bars -->
  <link rel="stylesheet" href="{{ asset ('file_upload/css/jquery.fileupload.css') }}">
  <link rel="stylesheet" href="{{ asset ('file_upload/css/jquery.fileupload-ui.css') }}">
  <!-- CSS adjustments for browsers with JavaScript disabled -->
  <noscript><link rel="stylesheet" href="{{ asset ('css/jquery.fileupload-noscript.css') }}"></noscript>
  <noscript><link rel="stylesheet" href="{{ asset ('css/jquery.fileupload-ui-noscript.css') }}"></noscript>
  <!-- End of file upload css -->
  <style type="text/css">
    .superbox-list{
     float: left;
     width: 12%;
     margin-right: 5px;
    } 
    .radios
    {
       margin-top: 5px;
    }
    .files img
    {
       width: 100px !important;
    }
    .superbox img{
       width: 100% !important;
       height: 75px;
    }

   </style>

</head>

<body>

  <!-- Header -->
  <header class="header navbar navbar-fixed-top" role="banner">
    <!-- Top Navigation Bar -->
    <div class="container">

      <!-- Only visible on smartphones, menu toggle -->
      <ul class="nav navbar-nav">
        <li class="nav-toggle"><a href="javascript:void(0);" title=""><i class="icon-reorder"></i></a></li>
      </ul>

      <!-- Logo -->
     <a class="navbar-brand" href="{{url('/home')}}">
       <strong>Value Chain</strong> 
       
      </a>
      <!-- /logo -->

      <!-- Sidebar Toggler -->
      <a href="#" class="toggle-sidebar bs-tooltip" data-placement="bottom" data-original-title="Toggle navigation">
        <i class="icon-reorder"></i>
      </a>
      <!-- /Sidebar Toggler -->

      <!-- Top Left Menu -->
      <ul class="nav navbar-nav navbar-left hidden-xs hidden-sm">
        <li>
          <a href="#">
            Dashboard
          </a>
        </li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            Users
            <i class="icon-caret-down small"></i>
          </a>
          <ul class="dropdown-menu">
            <li><a href="#"><i class="icon-user"></i>List of Users</a></li>
            <li><a href="#"><i class="icon-calendar"></i>System Roles</a></li>
            <li class="divider"></li>
            <li><a href="#"><i class="icon-tasks"></i>System Permissions</a></li>
          </ul>
        </li>

      
      </ul>
      <!-- /Top Left Menu -->

      <!-- Top Right Menu -->
      <ul class="nav navbar-nav navbar-right">
        <!-- Notifications -->
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <i class="icon-warning-sign"></i>
            <span class="badge">5</span>
          </a>
          <ul class="dropdown-menu extended notification">
            <li class="title">
              <p>You have 5 new notifications</p>
            </li>
            <li>
              <a href="javascript:void(0);">
                <span class="label label-success"><i class="icon-plus"></i></span>
                <span class="message">New user registration.</span>
                <span class="time">1 mins</span>
              </a>
            </li>
            <li>
              <a href="javascript:void(0);">
                <span class="label label-danger"><i class="icon-warning-sign"></i></span>
                <span class="message">High CPU load on cluster #2.</span>
                <span class="time">5 mins</span>
              </a>
            </li>
            <li>
              <a href="javascript:void(0);">
                <span class="label label-success"><i class="icon-plus"></i></span>
                <span class="message">New user registration.</span>
                <span class="time">10 mins</span>
              </a>
            </li>
            <li>
              <a href="javascript:void(0);">
                <span class="label label-info"><i class="icon-bullhorn"></i></span>
                <span class="message">New items are in queue.</span>
                <span class="time">25 mins</span>
              </a>
            </li>
            <li>
              <a href="javascript:void(0);">
                <span class="label label-warning"><i class="icon-bolt"></i></span>
                <span class="message">Disk space to 85% full.</span>
                <span class="time">55 mins</span>
              </a>
            </li>
            <li class="footer">
              <a href="javascript:void(0);">View all notifications</a>
            </li>
          </ul>
        </li>

        <!-- Tasks -->
        <li class="dropdown hidden-xs hidden-sm">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <i class="icon-tasks"></i>
            <span class="badge">7</span>
          </a>
          <ul class="dropdown-menu extended notification">
            <li class="title">
              <p>You have 7 pending tasks</p>
            </li>
            <li>
              <a href="javascript:void(0);">
                <span class="task">
                  <span class="desc">Preparing new release</span>
                  <span class="percent">30%</span>
                </span>
                <div class="progress progress-small">
                  <div style="width: 30%;" class="progress-bar progress-bar-info"></div>
                </div>
              </a>
            </li>
            <li>
              <a href="javascript:void(0);">
                <span class="task">
                  <span class="desc">Change management</span>
                  <span class="percent">80%</span>
                </span>
                <div class="progress progress-small progress-striped active">
                  <div style="width: 80%;" class="progress-bar progress-bar-danger"></div>
                </div>
              </a>
            </li>
            <li>
              <a href="javascript:void(0);">
                <span class="task">
                  <span class="desc">Mobile development</span>
                  <span class="percent">60%</span>
                </span>
                <div class="progress progress-small">
                  <div style="width: 60%;" class="progress-bar progress-bar-success"></div>
                </div>
              </a>
            </li>
            <li>
              <a href="javascript:void(0);">
                <span class="task">
                  <span class="desc">Database migration</span>
                  <span class="percent">20%</span>
                </span>
                <div class="progress progress-small">
                  <div style="width: 20%;" class="progress-bar progress-bar-warning"></div>
                </div>
              </a>
            </li>
            <li class="footer">
              <a href="javascript:void(0);">View all tasks</a>
            </li>
          </ul>
        </li>

        <!-- Messages -->
        <li class="dropdown hidden-xs hidden-sm">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <i class="icon-envelope"></i>
            <span class="badge">1</span>
          </a>
          <ul class="dropdown-menu extended notification">
            <li class="title">
              <p>You have 3 new messages</p>
            </li>
            <li>
              <a href="javascript:void(0);">
                <span class="photo"><img src="assets/img/demo/avatar-1.jpg" alt="" /></span>
                <span class="subject">
                  <span class="from">Bob Carter</span>
                  <span class="time">Just Now</span>
                </span>
                <span class="text">
                  Consetetur sadipscing elitr...
                </span>
              </a>
            </li>
            <li>
              <a href="javascript:void(0);">
                <span class="photo"><img src="assets/img/demo/avatar-2.jpg" alt="" /></span>
                <span class="subject">
                  <span class="from">Jane Doe</span>
                  <span class="time">45 mins</span>
                </span>
                <span class="text">
                  Sed diam nonumy...
                </span>
              </a>
            </li>
            <li>
              <a href="javascript:void(0);">
                <span class="photo"><img src="assets/img/demo/avatar-3.jpg" alt="" /></span>
                <span class="subject">
                  <span class="from">Patrick Nilson</span>
                  <span class="time">6 hours</span>
                </span>
                <span class="text">
                  No sea takimata sanctus...
                </span>
              </a>
            </li>
            <li class="footer">
              <a href="javascript:void(0);">View all messages</a>
            </li>
          </ul>
        </li>

        <!-- .row .row-bg Toggler -->
        <li>
          <a href="#" class="dropdown-toggle row-bg-toggle">
            <i class="icon-resize-vertical"></i>
          </a>
        </li>

        <!-- Project Switcher Button -->
        

        <!-- User Login Dropdown -->
        <li class="dropdown user">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <!--<img alt="" src="assets/img/avatar1_small.jpg" />-->
            <i class="icon-male"></i>
            <span class="username">{{@auth::user()->name}}</span>
            <i class="icon-caret-down small"></i>
          </a>
          <ul class="dropdown-menu">
            <li><a href="#"><i class="icon-user"></i> My Profile</a></li>
            <li><a href="#"><i class="icon-calendar"></i> My Calendar</a></li>
            <li><a href="#"><i class="icon-tasks"></i> My Tasks</a></li>
            <li class="divider"></li>
            <li><a href="{{url('logout')}}"><i class="icon-key"></i> Log Out</a></li>
          </ul>
        </li>
        <!-- /user login dropdown -->
      </ul>
      <!-- /Top Right Menu -->
    </div>
    <!-- /top navigation bar -->

    
  </header> <!-- /.header -->

  <div id="container">
    <div id="sidebar" class="sidebar-fixed">
      <div id="sidebar-content">

        <!-- Search Input -->
        <form class="sidebar-search">
          <div class="input-box">
            <button type="submit" class="submit">
              <i class="icon-search"></i>
            </button>
            <span>
              <input type="text" placeholder="Search...">
            </span>
          </div>
        </form>

        <!-- Search Results -->
        <div class="sidebar-search-results">

          <i class="icon-remove close"></i>
          <!-- Documents -->
          
          
        </div> <!-- /.sidebar-search-results -->

        <!--=== Navigation ===-->
        @include('layouts.sidebar')
        
        <!-- /Navigation -->
        <div class="sidebar-title">
          <span>Notifications</span>
        </div>
        <ul class="notifications demo-slide-in"> <!-- .demo-slide-in is just for demonstration purposes. You can remove this. -->
          <li style="display: none;"> <!-- style-attr is here only for fading in this notification after a specific time. Remove this. -->
            <div class="col-left">
              <span class="label label-danger"><i class="icon-warning-sign"></i></span>
            </div>
            <div class="col-right with-margin">
              <span class="message">Server <strong>#512</strong> crashed.</span>
              <span class="time">few seconds ago</span>
            </div>
          </li>
          <li style="display: none;"> <!-- style-attr is here only for fading in this notification after a specific time. Remove this. -->
            <div class="col-left">
              <span class="label label-info"><i class="icon-envelope"></i></span>
            </div>
            <div class="col-right with-margin">
              <span class="message"><strong>John</strong> sent you a message</span>
              <span class="time">few second ago</span>
            </div>
          </li>
          <li>
            <div class="col-left">
              <span class="label label-success"><i class="icon-plus"></i></span>
            </div>
            <div class="col-right with-margin">
              <span class="message"><strong>Admin</strong> Logged In </span>
              <span class="time">4 Mins ago</span>
            </div>
          </li>
        </ul>

        <div class="sidebar-widget align-center">
          <div class="btn-group" data-toggle="buttons" id="theme-switcher">
            <label class="btn active">
              <input type="radio" name="theme-switcher" data-theme="bright"><i class="icon-sun"></i> Bright
            </label>
            <label class="btn">
              <input type="radio" name="theme-switcher" data-theme="dark"><i class="icon-moon"></i> Dark
            </label>
          </div>
        </div>

      </div>
      <div id="divider" class="resizeable"></div>
    </div>
    <!-- /Sidebar -->

    <div id="content">
      <div class="container">
        <!-- Breadcrumbs line -->

        <div class="crumbs">
          <ul id="breadcrumbs" class="breadcrumb">
            <li>
              <i class="icon-home"></i>
              <a href="index.html">Dashboard</a>
            </li>
            <li class="current">
              <a href="pages_calendar.html" title="">Calendar</a>
            </li>
          </ul>

          <ul class="crumb-buttons">
            <li><a href="charts.html" title=""><i class="icon-signal"></i><span>Statistics</span></a></li>
            <li class="dropdown"><a href="#" title="" data-toggle="dropdown"><i class="icon-tasks"></i><span>Users <strong>(+3)</strong></span><i class="icon-angle-down left-padding"></i></a>
              <ul class="dropdown-menu pull-right">
              <li><a href="form_components.html" title=""><i class="icon-plus"></i>Add new User</a></li>
              <li><a href="tables_dynamic.html" title=""><i class="icon-reorder"></i>Overview</a></li>
              </ul>
            </li>
            <li class="range"><a href="#">
              <i class="icon-calendar"></i>
              <span></span>
              <i class="icon-angle-down"></i>
            </a></li>
          </ul>
        </div>
       
        <!-- /Breadcrumbs line -->

        <!--=== Page Header ===-->
        <div class="page-header">
         

          <!-- Page Stats -->
         
          <!-- /Page Stats -->
        </div>
        <!-- /Page Header -->

        <!--=== Page Content ===-->
        <!--=== Statboxes ===-->
        @yield('content')
        

        <!-- /Blue Chart -->



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




                 <div class="modal fade" id="countymodal" role="dialog">
                <div class="modal-dialog modal-lg">
                  <div class="modal-content">        

                   
                    <div class="modal-header">
                      <h4 class="modal-title" > 
                          &nbsp;&nbsp;<span id="myheader">
                      Give Reason(s)</span></h4>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

                      
                    </div>
                   
                    
                    <div class="modal-body" id="load-county-details2">
                    
                    </div>               
                   
                     
                  </div>
                </div>
              </div>


      

       
        <!-- /Page Content -->
      </div>
      <!-- /.container -->

    </div>
  </div>

</body>
  <!--=== JavaScript ===-->

  <script type="text/javascript" src="{{asset('AdminAssets/js/libs/jquery-1.10.2.min.js')}}"></script>
  <script type="text/javascript" src="{{asset('plugins/jquery-ui/jquery-ui-1.10.2.custom.min.js')}}"></script>

      <script type="text/javascript" src="{{asset('bootstrapAsset/js/bootstrap.min.js')}}"></script>
  <script type="text/javascript" src="{{asset('AdminAssets/js/libs/lodash.compat.min.js')}}"></script>

  <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
  <!--[if lt IE 9]>
    <script src="assets/js/libs/html5shiv.js"></script>
  <![endif]-->

  <!-- Smartphone Touch Events -->
  <script type="text/javascript" src="{{asset('plugins/touchpunch/jquery.ui.touch-punch.min.js')}}"></script>
  <script type="text/javascript" src="{{asset('plugins/event.swipe/jquery.event.move.js')}}"></script>
  <script type="text/javascript" src="{{asset('plugins/event.swipe/jquery.event.swipe.js')}}"></script>

  <!-- General -->
  <script type="text/javascript" src="{{asset('AdminAssets/js/libs/breakpoints.js')}}"></script>
  <script type="text/javascript" src="{{asset('plugins/respond/respond.min.js')}}"></script> <!-- Polyfill for min/max-width CSS3 Media Queries (only for IE8) -->
  <script type="text/javascript" src="{{asset('plugins/cookie/jquery.cookie.min.js'
  )}}"></script>
  <script type="text/javascript" src="{{asset('plugins/slimscroll/jquery.slimscroll.min.js')}}"></script>
  <script type="text/javascript" src="{{asset('plugins/slimscroll/jquery.slimscroll.horizontal.min.js')}}"></script>


  <!-- Page specific plugins -->
  <!-- Charts -->
  <!--[if lt IE 9]>
    <script type="text/javascript" src="plugins/flot/excanvas.min.js"></script>
  <![endif]-->
  <script type="text/javascript" src="{{asset('plugins/sparkline/jquery.sparkline.min.js')}}"></script>
  <script type="text/javascript" src="{{asset('plugins/flot/jquery.flot.min.js')}}"></script>
  <script type="text/javascript" src="{{asset('plugins/flot/jquery.flot.tooltip.min.js')}}"></script>
  <script type="text/javascript" src="{{asset('plugins/flot/jquery.flot.resize.min.js')}}"></script>
  <script type="text/javascript" src="{{asset('plugins/flot/jquery.flot.time.min.js')}}"></script>
  <script type="text/javascript" src="{{asset('plugins/flot/jquery.flot.growraf.min.js')}}"></script>
  <script type="text/javascript" src="{{asset('plugins/easy-pie-chart/jquery.easy-pie-chart.min.js')}}"></script>

  <script type="text/javascript" src="{{asset('plugins/daterangepicker/moment.min.js')}}"></script>
  <script type="text/javascript" src="{{asset('plugins/daterangepicker/daterangepicker.js')}}"></script>
  <script type="text/javascript" src="{{asset('plugins/blockui/jquery.blockUI.min.js')}}"></script>

  <script type="text/javascript" src="{{asset('plugins/fullcalendar/fullcalendar.min.js')}}"></script>

  <!-- Noty -->
  <script type="text/javascript" src="{{asset('plugins/noty/jquery.noty.js')}}"></script>
  <script type="text/javascript" src="{{asset('plugins/noty/layouts/top.js')}}"></script>
  <script type="text/javascript" src="{{asset('plugins/noty/themes/default.js')}}"></script>

  
  <!-- Forms -->
  <script type="text/javascript" src="{{asset('plugins/uniform/jquery.uniform.min.js')}}"></script>
  <script type="text/javascript" src="{{asset('plugins/select2/select2.min.js')}}"></script>



    <!-- DataTables -->




  <!-- App -->
  <script type="text/javascript" src="{{asset('AdminAssets/js/app.js')}}"></script>
  <script type="text/javascript" src="{{asset('AdminAssets/js/plugins.js')}}"></script>
  <script type="text/javascript" src="{{asset('AdminAssets/js/plugins.form-components.js')}}"></script>
 
  <script src="{{ asset('AdminAssets/datatables/media/js/jquery.dataTables.min.js') }}"></script>    
    <script src="{{ asset('AdminAssets/datatables/media/js/dataTables.bootstrap4.min.js') }}"></script>    
    <script src="{{ asset('AdminAssets/datatables/extras/TableTools/Buttons-1.4.2/js/dataTables.buttons.min.js') }}"></script> 
    <script src="{{ asset('AdminAssets/datatables/extras/TableTools/Buttons-1.4.2/js/buttons.bootstrap4.min.js') }}"></script>   
    <script src="{{ asset('AdminAssets/datatables/extras/TableTools/Buttons-1.4.2/js/buttons.html5.min.js') }}"></script>    
    <script src="{{ asset('AdminAssets/datatables/extras/TableTools/Buttons-1.4.2/js/buttons.print.min.js') }}"></script>  
     <script type="text/javascript" src="{{asset('handlebars.js')}}"></script>  
    <script src="{{ asset('AdminAssets/datatables/extras/TableTools/JSZip-2.5.0/jszip.min.js') }}"></script>   



    <script src="{{ asset('AdminAssets/datatables/extras/TableTools/pdfmake-0.1.32/pdfmake.min.js') }}"></script>    
    <script src="{{ asset('AdminAssets/datatables/extras/TableTools/pdfmake-0.1.32/vfs_fonts.js') }}"></script>

  <script>
  $(document).ready(function(){
    "use strict";

    App.init(); // Init layout and core plugins
    Plugins.init(); // Init all plugins
    FormComponents.init(); // Init all form-specific plugins
  });
  </script>

   <script type="text/javascript">
  $(function () {
      $.ajaxSetup({
          headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
      });
  });
  </script>

    <script type="text/javascript">
      $(".number").on("keydown",function(event){

      if (event.shiftKey == true) {
            event.preventDefault();
        }

        if ((event.keyCode >= 48 && event.keyCode <= 57 ) || 
            (event.keyCode >= 96 && event.keyCode <= 105) || 
            event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 37 ||
            event.keyCode == 39 || event.keyCode == 46 || event.keyCode == 190 || event.keyCode == 110 || event.keyCode == 188) {

        } else {
            event.preventDefault();
        }
         if($(this).val().indexOf('.') !== -1 && event.keyCode == 190)
            event.preventDefault(); 


      });
  
      
    </script>


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




            $(document).on('click','.large-modal',function(){

              var head=$(this).attr('data-title');
                  
               var url=$(this).attr("data-url");
                $("#load-county-details2").html("");
                $("#myheader").html(" ");
                $("#myheader").html(head);
                $("#countymodal").modal("show");
            $("#load-county-details2").load(url,function(data){
            $("#countymodal").modal("show");
             
          });

           

       });




   $(document).on('click','.delete-record',function(){

    var name=$(this).attr("data-name");
    var message=confirm("Confirm you want to delete this "+name);
      if(message==true){
         var url=$(this).attr("data-url");
         var url_to=$(this).attr("data-redirect-to");
         var token="<?=csrf_token();?>";
          
             $.post(url,{'_token':token},function(){

              window.location.href=url_to;
             });

      }
        });



    $(document).on('click','.confirm-record',function(){

    var name=$(this).attr("data-name");
    var action=$(this).attr("data-action");
    var message=confirm("Confirm you want to "+action+" "+name);
      if(message==true){
         var url=$(this).attr("data-url");
         var url_to=$(this).attr("data-redirect-to");
         var token="<?=csrf_token();?>";
          
             $.post(url,{'_token':token},function(){

              window.location.href=url_to;
             });

      }
        });


      </script>


<!-- START OF FILE UPLOAD JS SCRIPTS-->

        <script type="text/javascript">
           $.ajaxSetup({
                headers:{ "X-csrf-Token":$("meta[name=_token]").attr("content")}
            });

        </script>
        <script src="{{ asset('js/form-multiple-upload.demo.min.js')}}"></script>
        <!-- The template to display files available for upload -->
        <script id="template-upload" type="text/x-tmpl">
        {% for (var i=0, file; file=o.files[i]; i++) { %}
            <tr class="template-upload fade">
                <td>
                    <span class="preview"></span>
                </td>
                <td>
                    <p class="name">{%=file.name%}</p>
                    <strong class="error text-danger"></strong>
                </td>
                <td>
                    <p class="size">Processing...</p>
                    <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0"><div class="progress-bar progress-bar-success" style="width:0%;"></div></div>
                </td>
                <td>
                    {% if (!i && !o.options.autoUpload) { %}
                        <button class="btn btn-primary start btn-sm" disabled>
                            <i class="glyphicon glyphicon-upload"></i>
                            <span>Upload</span>
                        </button>
                    {% } %}
                    {% if (!i) { %}
                        <button class="btn btn-danger cancel btn-sm">
                            <i class="glyphicon glyphicon-ban-circle"></i>
                            <span>Cancel</span>
                        </button>
                    {% } %}
                </td>
            </tr>
        {% } %}
        </script>
        <!-- The template to display files available for download -->
        <script id="template-download" type="text/x-tmpl">
        {% for (var i=0, file; file=o.files[i]; i++) { %}
            <tr class="template-download fade">
                <td>
                    <span class="preview">
                        {% if (file.thumbnailUrl) { %}
                            <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" data-gallery><img src="{%=file.thumbnailUrl%}"></a>
                        {% } %}
                    </span>
                </td>
                <td>
                    <p class="name">
                        {% if (file.url) { %}
                            <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" {%=file.thumbnailUrl?'data-gallery':''%}>{%=file.name%}</a>
                        {% } else { %}
                            <span>{%=file.name%}</span>
                        {% } %}
                    </p>
                    {% if (file.error) { %}
                        <div><span class="label label-danger">Error</span> {%=file.error%}</div>
                    {% } %}
                </td>
                <td>
                    <span class="size">{%=o.formatFileSize(file.size)%}</span>
                </td>
                <td>
                    {% if (file.deleteUrl) { %}
                        <button class="btn btn-danger delete" data-type="{%=file.deleteType%}" data-url="{%=file.deleteUrl%}"{% if (file.deleteWithCredentials) { %} data-xhr-fields='{"withCredentials":true}'{% } %}>
                            <i class="glyphicon glyphicon-trash"></i>
                            <span>Delete</span>
                        </button>
                        <input type="checkbox" name="delete" value="1" class="toggle">
                    {% } else { %}
                        <button class="btn btn-warning cancel">
                            <i class="glyphicon glyphicon-ban-circle"></i>
                            <span>Cancel</span>
                        </button>
                    {% } %}
                </td>
            </tr>
        {% } %}
        </script>

        <!-- The jQuery UI widget factory, can be omitted if jQuery UI is already included -->
        <script src="{{ asset('file_upload/js/vendor/jquery.ui.widget.js') }}"></script>
        <!-- The Templates plugin is included to render the upload/download listings -->
        <script src="//blueimp.github.io/JavaScript-Templates/js/tmpl.min.js"></script>
        <!-- The Load Image plugin is included for the preview images and image resizing functionality -->
        <script src="//blueimp.github.io/JavaScript-Load-Image/js/load-image.all.min.js"></script>
        <!-- The Canvas to Blob plugin is included for image resizing functionality -->
        <script src="//blueimp.github.io/JavaScript-Canvas-to-Blob/js/canvas-to-blob.min.js"></script>
        <!-- blueimp Gallery script -->
        <script src="//blueimp.github.io/Gallery/js/jquery.blueimp-gallery.min.js"></script>
        <!-- The Iframe Transport is required for browsers without support for XHR file uploads -->
        <script src="{{ asset('file_upload/js/jquery.iframe-transport.js') }}"></script>
        <!-- The basic File Upload plugin -->
        <script src="{{ asset('file_upload/js/jquery.fileupload.js') }}"></script>
        <!-- The File Upload processing plugin -->
        <script src="{{ asset('file_upload/js/jquery.fileupload-process.js') }}"></script>
        <!-- The File Upload image preview & resize plugin -->
        <script src="{{ asset('file_upload/js/jquery.fileupload-image.js') }}"></script>
        <!-- The File Upload audio preview plugin -->
        <script src="{{ asset('file_upload/js/jquery.fileupload-audio.js') }}"></script>
        <!-- The File Upload video preview plugin -->
        <script src="{{ asset('file_upload/js/jquery.fileupload-video.js') }}"></script>
        <!-- The File Upload validation plugin -->
        <script src="{{ asset('file_upload/js/jquery.fileupload-validate.js') }}"></script>
        <!-- The File Upload user interface plugin -->
        <script src="{{ asset('file_upload/js/jquery.fileupload-ui.js') }}"></script>
        <!-- The main application script -->

        <script type="text/javascript">

         $(document).on("click","#uploadmodal",function(){

            'use strict';

            if($("#fileupload").hasClass("initialized"))
            {

            }
            else
            {
            
                $("#fileupload").addClass("initialized"); 
                // Initialize the jQuery File Upload widget:
                $('#fileupload').fileupload({
                    // Uncomment the following to send cross-domain cookies:
                    //xhrFields: {withCredentials: true},
                    url: uploadurl,
                    autoUpload:false,
                    sequentialUploads:true,
                    type:'POST',
                    dataType:'json'
                }).bind('fileuploaddone', function (e, data) {
                  //console.log();
                  $.each(data.result.files, function(index, file) {
                    if(mode=="multiple")
                                            {
                                                if(file.ext=='pdf')
                                                {
                                                    var html_image_multiple="<div class='superbox-list'>"+
                                                        "<img src='"+base+"/img/pdf.png' style='width:100px;height: 75px;' class='superbox-img' />"+

                                                    "<div class='input-group'>"+
                                                        "<span class='input-group-addon'>"+
                                                            "<input data-url='"+file.url+"' data-id='"+file.id+"' type='checkbox' name='icons[]'>"+
                                                        "</span>"+
                                                        "<a href='#' class='form-control btn btn-primary btn-sm'>View</a>"+
                                                    "</div>"+

                                                    "</div>";
                                                }
                                                else
                                                {
                                                    var html_image_multiple="<div class='superbox-img' />"+

                                                    "<div class='input-group'>"+
                                                        "<span class='input-group-addon'>"+
                                                            "<input data-url='"+file.url+"' data-id='"+file.id+"' checked type='checkbox' name='icons[]'>"+
                                                        "</span>"+
                                                        "<input type='text' readonly class='form-control' value='Select'>"+
                                                    "</div>"+

                                                    "</div>";
                                                }
                                                
                                                    $("#gallery-manager").prepend(html_image_multiple);
                                            }
                                            else
                                            {
                                                if(file.ext=='pdf')
                                                {
                                                    var html_image_multiple="<div class='superbox-list'>"+
                                                        "<img src='"+base+"/img/pdf.png' style='width:100px;height: 75px;' class='superbox-img' />"+

                                                    "<div class='input-group'>"+
                                                        "<span class='input-group-addon'>"+
                                                            "<input data-url='"+file.url+"' data-id='"+file.id+"' type='radio' name='icon'>"+
                                                        "</span>"+
                                                        "<a href='#' class='form-control btn btn-primary btn-sm'>View</a>"+
                                                    "</div>"+

                                                    "</div>";
                                                }
                                                else
                                                {
                                                    var html_image_single="<div class='superbox-list'>"+
                                                        "<img src='"+file.url+"' class='superbox-img' />"+

                                                    "<div class='input-group'>"+
                                                        "<span class='input-group-addon'>"+
                                                            "<input data-url='"+file.url+"' data-id='"+file.id+"' checked type='radio' name='icon'>"+
                                                        "</span>"+
                                                        "<input type='text' readonly class='form-control' value='Select'>"+
                                                    "</div>"+

                                                    "</div>";
                                                }
                                                
                                                    $("#gallery-manager").prepend(html_image_single);
                                            }
                  });
                                            
                                                    


                                            
                  //$(".files").html("");
                  
                });
            }

         });

        </script>

        <script type="text/javascript">

           $(document).on("click",".uploadmodalwidget",function(){

                        $(".files").html("");
                        $("#gallery-manager").html("");

                        inputid=$(this).attr("data-inputid");
                        mode=$(this).attr("data-mode");
                        imageid=$(this).attr("data-divid");


                        var url="<?=url('System/file/fetch')?>";
                        
                        $.post(url).done(function(data){
                            var data=$.parseJSON(data);          
                            if(mode=="multiple")
                            {
                               // imageid=$(this).attr("data-divid");
                                $.each(data, function(key,value){
                                    if(value.extention=="pdf")
                                    {
                                        var html_image_multiple="<div class='superbox-list'>"+
                                                "<img src='"+baseurl+"/img/pdf.png' style='width:100px;height: 75px;' class='superbox-img' />"+
                                                "<div class='input-group'>"+
                                                "<span class='input-group-addon'>"+
                                                    "<input data-url='"+baseurl+"/uploads/"+value.filename+"' data-id='"+value.id+"' type='checkbox' name='icon'>"+
                                                "</span>"+
                                                    "<a href='#' class='form-control'>View</a>"+
                                                "</div>"+

                                                "</div>";
                                    }
                                    else
                                    {
                                        var html_image_multiple="<div class='superbox-list'>"+
                                        "<a href='"+baseurl+"/uploads/"+value.filename+"' class='image-link'><img src='"+baseurl+"/uploads/"+value.filename+"' style='width:100px;height: 75px;' class='superbox-img' /></a>"+
                                            "<div class='input-group'>"+
                                                "<span class='input-group-addon'>"+
                                                    "<input data-url='"+baseurl+"/uploads/"+value.filename+"' data-id='"+value.id+"' type='checkbox' name='icon'>"+
                                                "</span>"+
                                                "<input type='text' readonly class='form-control' value='Select'>"+
                                            "</div>"+
                                        "</div>";
                                    }
                                    
                                    $("#gallery-manager").prepend(html_image_multiple);  

                                    //console.log(value);
                                });
                            }
                            else
                            {
                                
                                $.each(data, function(key,value){

                                    var html_image_single="<div class='superbox-list'>"+
                                        "<img src='"+baseurl+"/uploads/"+value.filename+"' style='width:100px;height: 75px;' class='superbox-img' />"+
                                            "<div class='input-group'>"+
                                                "<span class='input-group-addon'>"+
                                                    "<input data-url='"+baseurl+"/uploads/"+value.filename+"' data-id='"+value.id+"' type='radio' name='icon'>"+
                                                "</span>"+
                                                "<input type='text' readonly class='form-control' value='Select'>"+
                                            "</div>"+
                                        "</div>";

                                    $("#gallery-manager").prepend(html_image_single); 
                                    //console.log(value);
                                });
                            }
                            //console.log(data);
                        });


                      });
            </script>

            <script type="text/javascript">
                $("#insert_image").on("click",function(){


                if(mode=="multiple")
                {
                    images=[];
                    imagesids=[];
                    $("#gallery-manager input:checkbox:checked").each(function(){ 
                        images.push($(this).attr('data-url')); 
                        imageids.push($(this).attr('data-id'));
                    });


                    $.each(images, function(index, item) {
                        
                        var html_image="<div style='float: left;' class='col-md-2'><div class='superbox-list' style='width:100%;'>"+
                                "<span title='Delete Image' class='close delete_image' data-id='"+imageids[index]+"' style='opacity:.9;float: left;width:100%;color: red'>x</span>"+
                                "<a class='image-link' href='"+item+"'><img src='"+item+"' style='height: 100px;width:100%;' class='superbox-img' /></a>"+
                                "</div></div>";

 
                        $("#"+imageid).prepend(html_image);         

                    });

                    var ids="";

                      var images = $("#"+inputid).val();
                      if(images !="")
                      {
                          var temp = new Array();
                          temp = images.split(',');
                          
                          $.each(temp, function( index, value ) {
                            if(value !="")
                            {
                              ids=ids+value+",";
                            }
                            
                          });  
                      }
                                          

                    $.each(imageids, function(index, item) {
                        
                        ids=ids+item+",";
                        //console.log(imageid);                               
                    });
                    //console.log(ids);
                    $("#"+inputid).val(ids);    
                    //$("#"+inputid).val(new_array);
                }
                else
                {
                    dataurl=$("#gallery-manager input:radio:checked").attr('data-url');
                    dataid = $("#gallery-manager input:radio:checked").attr('data-id');    
                 
                    console.log();

                    $("#"+inputid).val(dataid);
                    $("#"+imageid).attr("src",dataurl);   



                }

                counter++;
                
                $("#modal-message").modal('hide');
            });

            </script>
<!-- END OF FILE UPLOAD JS SCRIPTS-->



<script type="text/javascript">

    $(".search").on("change",function(e){
      var id=$(this).val();
      var url=$(this).data('url')+"/"+id;
      window.location.href=url;
        

    });


 var hash = document.location.hash;
  var prefix = "tab_";
  if (hash) {
      $('.nav-tabs a[href="'+hash.replace(prefix,"")+'"]').tab('show');
  } 

  // Change hash for page-reload
  $('.nav-tabs a').on('shown', function (e) {
      window.location.hash = e.target.hash.replace("#", "#" + prefix);
  });


  $("ul li").on("click", function() {
    $("li").removeClass("active");
    $(this).addClass("active");
  });





</script>





@stack('scripts')

  

</html>