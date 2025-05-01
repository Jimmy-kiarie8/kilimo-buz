 <div class="main-sidebar sidebar-style-2">
        <aside id="sidebar-wrapper">
          <div class="sidebar-brand">
            <a href="{{url('home')}}"> 
           <img src="{{asset('assetsError/images/baner3.png')}}" height="60" alt="Aero"  class="header-logo">


            
            </a>
          </div>
          <ul class="sidebar-menu">
            <li class="menu-header">Main</li>
            <li class="dropdown">
              <a href="{{url('home')}}" class="nav-link"><i data-feather="monitor"></i><span>Dashboard</span></a>
            </li>
            <li class="dropdown">
              <a href="#" class="menu-toggle nav-link has-dropdown"><i
                  data-feather="briefcase"></i><span>My Profile</span></a>
              <ul class="dropdown-menu">
                <li><a class="nav-link" href="{{url('System/Profile/BasicDetails')}}">Basic Details</a></li>
                
              </ul>
            </li>
            <li class="dropdown">
              <a href="#" class="menu-toggle nav-link has-dropdown"><i data-feather="command"></i><span>Manage Members</span></a>
              <ul class="dropdown-menu">
                <li><a class="nav-link" href="{{url('System/MemberAccount/Create')}}">Add New Member</a></li>
                  <li><a class="nav-link" href="{{url('System/MemberAccount/Index')}}">List Of Members</a></li>
               
              </ul>
            </li>
            <li class="dropdown">
              <a href="#" class="menu-toggle nav-link has-dropdown"><i data-feather="mail"></i><span>Member Products</span></a>
              <ul class="dropdown-menu">
                <li><a class="nav-link" href="{{url('System/MemberAccount/AddProduct')}}">Add Product</a></li>
                 <li><a class="nav-link" href="{{url('System/MemberAccount/ProductList')}}">List of Product</a></li>
                
              </ul>
            </li>

             <li class="dropdown">
              <a href="#" class="menu-toggle nav-link has-dropdown"><i data-feather="mail"></i><span>Manage Orders</span></a>
              <ul class="dropdown-menu">
                
                 <li><a class="nav-link" href="{{url('System/Orders/Pending')}}">Pending Orders</a></li>

                  <li><a class="nav-link" href="{{url('System/Orders/Completed')}}">Completed Orders</a></li>
                
              </ul>
            </li>





             <li class="dropdown">
              <a href="#" class="menu-toggle nav-link has-dropdown"><i data-feather="lock"></i><span>Security</span></a>
              <ul class="dropdown-menu">
                <li><a class="nav-link" href="{{url('System/Security/ChangePassword')}}">Change Password</a></li>
                
              </ul>
            </li>
           <li><a class="nav-link" href="{{url('logout')}}"><i data-feather="log-out"></i><span>Log Out</span></a></li>
           </ul>
        </aside>
      </div>