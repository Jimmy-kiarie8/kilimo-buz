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
<div>
  @yield('main')  
</div>
<div>
    @include('layouts.partials._footer')

    </div>







<!-- ======= Footer ======= -->


<a href="#" class="back-to-top"><i class="icofont-simple-up"></i></a>

@include('layouts.partials.scripts')




</body>

</html>
