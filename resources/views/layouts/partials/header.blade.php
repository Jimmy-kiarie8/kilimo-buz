
<header id="header" class="fixed-top"  >

    <div class="container-fluid d-flex" style="background-color:green; color: #fff; position: absolute; top: 0;">

        <div class="row d-none d-sm-block" style="width: 100%;">
            <div class="col">
                <span class="jtl-cl">E-mail: 
                    <!-- <i class="ri-mail-line"></i> -->
                     <a href="mailto: info@asdsp.go.ke" class="jtl-cl jtl-clh">info@asdsp.go.ke</a></span>
                |
                <span class="jtl-cl">website: 
                    <!-- <i class="ri-phone-line"></i>  -->
                    <a href="tel:www.asdsp.kilimo.go.ke" class="jtl-cl jtl-clh">www.asdsp.kilimo.go.ke</a></span>

                <span class="header-social-links float-right" style="text-align: right">
                    <a href="#" target="_blank" class="twitter jtl-cl jtl-clh"><i class="icofont-twitter"></i></a>
                    <a href="#" target="_blank" class="facebook jtl-cl jtl-clh"><i class="icofont-facebook"></i></a>
                    <a href="#" target="_blank" class="instagram jtl-cl jtl-clh"><i class="icofont-instagram"></i></a>
                    <!-- <a href="#" class="linkedin jtl-cl jtl-clh"><i class="icofont-linkedin"></i></i></a> -->
                </span>
            </div>
        </div>

    </div>

    <div class="container d-flex align-items-center nav-positioning">

   
        <!-- Uncomment below if you prefer to use an image logo -->
        <a href="{{ url('/') }}" class="logo mr-auto"><img src="{{asset('f/assets/img/greenlogo.png')}}" alt="" class="img-fluid">







        </a>
        <h1 class="logo mr-auto"><a href="{{ url('/') }}"></a></h1>
         

        <nav class="nav-menu d-none d-lg-block">
            <ul>
                
             
                     
                    <li  class="jtl-cl" ><a   href="{{ route('login') }}">{{ __('Home') }}</a></li>


                    <li  class="jtl-cl" ><a   href="{{ route('login') }}">{{ __('Login') }}</a></li>


                     <li class="jtl-cl"  ><a   href="{{ route('login') }}">Order</a></li>
                
                 

                <li><a href="#" data-toggle="modal" data-target="#searchModal"><img src="{{ asset('img/search.png') }}" style="height: 25px" alt="" class="img-fluid"></a></li>

            </ul>

        </nav><!-- .nav-menu -->

        <div class="header-social-links">
            <a href="#" class="twitter"><i class="icofont-twitter"></i></a>
            <a href="#" class="facebook"><i class="icofont-facebook"></i></a>
            <a href="#" class="instagram"><i class="icofont-instagram"></i></a>
            <a href="#" class="linkedin"><i class="icofont-linkedin"></i></i></a>
        </div>

    </div>
</header><!-- End Header -->



<!-- Modal -->
<div id="searchModal" class="modal fade" role="dialog">
  <div class="modal-dialog" style="margin-top: 8%; opacity: 0.9">

  <style>
    .jtl-search {
        width: 100%;
    }
  </style>

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-body">
        <div class="row">
            <div class="col-md-12">
                <button type="button" class="close" data-dismiss="modal" style="margin-bottom: 10px; color: #980D16">&times;</button>
            </div>
        </div>

        
            <form class="" method="GET" action="{{ url('search') }}">
                <div class="row">
                    <br/>
                    <div class="col-md-12">
                        <input class="form-control jtl-search" placeholder="Search here..." aria-label="Search" name="query" id="query" required value="{{ isset($searchterm) ? $searchterm : '' }}" />
                        
                        @error('query')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="col-md-12">
                        <br/>
                        <button class="btn btn-success btn-sm float-right" type="submit">Submit</button>
                    </div>
                </div>
            </form>
        
        
      </div>
    </div>

  </div>
</div>

237001
