      <!-- BEGIN #top-nav -->
        <div id="top-nav" class="top-nav">
            <!-- BEGIN container -->
            <div class="container">
                <div class="collapse navbar-collapse">
                    <ul class="nav navbar-nav">
                        <li class="dropdown dropdown-hover">
                            <a href="#" data-toggle="dropdown"><img src="{{ asset('front/assets/img/kenya.png')}}" class="flag-img" alt="" /> Kenya <i class="fa fa-angle-down"></i></a>
                           
                        </li>
                     
                        <li><a href="#">E-mail:info@asdsp.go.ke </a></li>
                        <li><a href="#">Order Tracker</a></li>
                    </ul>
                   
                </div>
            </div>
            <!-- END container -->
        </div>
        <!-- END #top-nav -->

<!-- BEGIN #header -->
        <div id="header" class="header" data-fixed-top="true">
            <!-- BEGIN container -->
            <div class="container">
                <!-- BEGIN header-container -->
                <div class="header-container">
                    <!-- BEGIN navbar-header -->
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <div class="header-logo">
                            <a href="{{url('/')}}">
                                <span class="brands"> <img src="{{ asset('kilimo_buz_img.png')}}" alt="logo" height="90" /></span>
                            </a>
                        </div>
                    </div>
                    <!-- END navbar-header -->
                    <!-- BEGIN header-nav -->
                    <div class="header-nav">
                        <div class=" collapse navbar-collapse" id="navbar-collapse">
                            <ul class="nav">
                                <li><a href="{{url('/')}}">Home</a></li>
                                   <li><a href="{{url('/')}}">Products</a></li>
                                
                                <li class="dropdown dropdown-hover">
                                    <a href="#" data-toggle="dropdown">
                                        VCOs 
                                        <i class="fa fa-angle-down"></i> 
                                        <span class="arrow top"></span>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li><a href="{{url('/VCOs/Registered')}}">Value Chain Organizations</a></li>
                                       
                                    </ul>
                                </li>
                                 

                               
                                <li><a href="{{url('/County/Statistics')}}">Statistics</a></li>


                               

                                <li>
                                <?php

                                if(Auth::check())
                                {
                                    ?>
                                    <a href="{{url('/logout')}}">
                                        
                                        <span class="hidden-md hidden-sm hidden-xs">Log Out</span>
                                    </a>
                                    <?php
                                }else{
                                     ?>
                                      <li><a href="{{url('/login')}}">Login</a></li>


                                      <?php

                                }
                            
                                ?>
                                
                            </li>
                                
                                <li class="dropdown dropdown-hover">
                                    <a href="#" data-toggle="dropdown">
                                        <i class="fa fa-search search-btn"></i>
                                        <span class="arrow top"></span>
                                    </a>
                                    <div class="dropdown-menu p-15">
                                        <form action="" method="POST" name="search_form">
                                            <div class="input-group">
                                                <input type="text" placeholder="Search" class="form-control bg-silver-lighter" />
                                                <span class="input-group-btn">
                                                    <button class="btn btn-inverse" type="submit"><i class="fa fa-search"></i></button>
                                                </span>
                                            </div>
                                        </form>
                                    </div> 
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!-- END header-nav -->
                    <!-- BEGIN header-nav -->
                    <div class="header-nav">
                        <ul class="nav pull-right">
                           
                            <li class="divider"></li>
                           

                              
                        </ul>
                    </div>
                    <!-- END header-nav -->
                </div>
                <!-- END header-container -->
            </div>
            <!-- END container -->
        </div>
        <!-- END #header -->        