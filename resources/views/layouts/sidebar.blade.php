 <ul id="nav">
          <li class="current">
            <a href="{{url('/home')}}">
              <i class="icon-dashboard"></i>
              Dashboard
            </a>
          </li>
            </li>

           <?php if(Auth::User()->hasRole(['SuperAdmin'])):?>
               
          <li>
            <a href="javascript:void(0);">
              <i class=" icon-cog"></i>
              System Settings
              
            </a>
            <ul class="sub-menu">
              <li  class="active">
                <a href="{{url('/System/Counties/Index')}}">
                <i class="icon-angle-right"></i>
                List of Counties
                </a>
              </li>
              <li class="hidden">
                <a href="{{url('/System/SubCounties/Index')}}">
                <i class="icon-angle-right"></i>
                List of Sub Counties
                </a>
              </li>

               <li>
                <a href="{{url('/System/ValueChain/Index')}}">
                <i class="icon-angle-right"></i>
               Value Chain Names
                </a>
              </li>
              <li>
                <a href="{{url('/System/ProductNames/Index')}}">
                <i class="icon-angle-right"></i>
               Product Names
                </a>
              </li>
               <li>
                <a href="{{url('/System/NodeTypes/Index')}}">
                <i class="icon-angle-right"></i>
                List of Nodes
                </a>
              </li>

              <li>
                <a href="{{url('/System/ValueChain/CountyIndex')}}">
                <i class="icon-angle-right"></i>
                 Prioritised Value Chain
                </a>
              </li>

               <li>
                <a href="{{url('/System/UnitOfMeasure/Index')}}">
                <i class="icon-angle-right"></i>
                Units of Measure
                </a>
              </li>




               
            
            </ul>
          </li>
           <?php endif;?>
            
          <li>
            <a href="javascript:void(0);">
              <i class="icon-edit"></i>
              VCO Management
            </a>
            <ul class="sub-menu">
              <li>
                <a href="{{url('/System/Entities/Create')}}">
                <i class="icon-angle-right"></i>
               New Organization
                </a>
              </li>
              <li>
                <a href="{{url('/System/Entities/Index')}}">
                <i class="icon-angle-right"></i>
                List of VCOs
                </a>
              </li>
              
            </ul>
          </li>

          <li>
            <a href="javascript:void(0);">
              <i class="icon-list"></i>
              VCO Members
            </a>
            <ul class="sub-menu">


              <li>
                <a href="{{url('/System/MemberToVCOByID/Index')}}">
                <i class="icon-angle-right"></i>
                Link VCAs To  VCO By ID Number
                </a>
              </li>


              
              <li>
                <a href="{{url('/System/VCOMembers/Index')}}">
                <i class="icon-angle-right"></i>
                List of VCO Members
                </a>
              </li>


               <li>
                <a href="{{url('/System/VCOMemberOTP/Index')}}">
                <i class="icon-angle-right"></i>
                Retrieve Member Mobile OTP
                </a>
              </li>



              
            </ul>
          </li>

          <li>
            <a href="javascript:void(0);">
              <i class="icon-list"></i>
              Member Products
            </a>
            <ul class="sub-menu">
              
              <li>
                <a href="{{url('/System/MemberProducts/Index')}}">
                <i class="icon-angle-right"></i>
                List of Products
                </a>
              </li>
              
            </ul>
          </li>


           <li>
            <a href="javascript:void(0);">
              <i class="icon-list"></i>
              Transport Node
            </a>
            <ul class="sub-menu">
              
              <li>
                <a href="{{url('/System/TransportNode/Create')}}">
                <i class="icon-angle-right"></i>
                Add New Transporter
                </a>
              </li>

              <li>
                <a href="{{url('/System/TransportNode/Index')}}">
                <i class="icon-angle-right"></i>
                Registered Transporter
                </a>
              </li>
              
            </ul>
          </li>


          <li>
            <a href="javascript:void(0);">
              <i class="icon-briefcase"></i>
             Reports Module
            </a>
            <ul class="sub-menu">
              
              <li>
                <a href="{{url('/System/Reports/CountyVsVCOs')}}">
                <i class="icon-angle-right"></i>
                VCO By Counties
                </a>
              </li>

              <li>
                <a href="{{url('/System/Reports/ValueVCO')}}">
                <i class="icon-angle-right"></i>
                Value Chain VCOs Number
                </a>
              </li>

               <li>
                <a href="{{url('/System/Reports/NodeVCO')}}">
                <i class="icon-angle-right"></i>
                Node VCOs Number
                </a>
              </li>

               <li>
                <a href="{{url('/System/Reports/VCAByCounty')}}">
                <i class="icon-angle-right"></i>
                VCA Statistics By Counties
                </a>
              </li>


               <li>
                <a href="{{url('/System/Reports/General')}}">
                <i class="icon-angle-right"></i>
                General VCA Statistics
                </a>
              </li>
               <?php if(Auth::User()->hasRole(['County Co-ordinator'])):?>



               <li>
                <a href="{{url('/System/Reports/VCAByVCO')}}">
                <i class="icon-angle-right"></i>
                VCA Statistics By VCO
                </a>
              </li>



                  <?php endif;?>



              
            </ul>
          </li>
    <?php if(Auth::User()->hasRole(['SuperAdmin'])):?>
          <li>
            <a href="javascript:void(0);">
              <i class="icon-table"></i>
             Training  Module
            </a>
            <ul class="sub-menu">
              
              <li>
                <a href="{{url('/System/TrainingModule/Admin')}}">
                <i class="icon-angle-right"></i>
                Uploaded Trainings
                </a>
              </li>

              <li>
                <a href="{{url('/System/TrainingModule/Trainees')}}">
                <i class="icon-angle-right"></i>
                Trained Service Providers
                </a>
              </li>

              

              
            </ul>
          </li>
           <?php endif;?>

             <?php if(Auth::User()->hasRole(['County Co-ordinator'])):?>


             <?php if(Auth::user()->email=="mildrith7791@gmail.com"):?>


              <li>
            <a href="javascript:void(0);">
              <i class="icon-table"></i>
             Survey Module
            </a>
            <ul class="sub-menu">
              
              <li  class="active">
                <a href="{{url('/System/Survey/Dashboard')}}">
                <i class="icon-angle-right"></i>
                Survey Dashbaord
                </a>
              </li>

              <li>
                <a href="{{url('/System/TrainingModule/Index')}}">
                <i class="icon-angle-right"></i>
                Survey Response
                </a>
              </li>

              
              
            </ul>
          </li>
          <?php endif;?>


             <li>
            <a href="javascript:void(0);">
              <i class="icon-table"></i>
             Training Module
            </a>
            <ul class="sub-menu">
              
              <li>
                <a href="{{url('/System/TrainingModule/Create')}}">
                <i class="icon-angle-right"></i>
                Add New Training
                </a>
              </li>

              <li>
                <a href="{{url('/System/TrainingModule/Index')}}">
                <i class="icon-angle-right"></i>
                List of Training
                </a>
              </li>

               <li>
                <a href="{{url('/System/TrainingModule/TrainedActors')}}">
                <i class="icon-angle-right"></i>
                Trained Actors/Members
                </a>
              </li>
              
            </ul>
          </li>

             <li>
            <a href="javascript:void(0);">
              <i class="icon-group"></i>
             System Users
            </a>
            <ul class="sub-menu">
              
               <li>
                <a href="{{url('System/Users/Create')}}">
                <i class="icon-angle-right"></i>
                Add New County User
                </a>
              </li>
              <li>
                <a href="{{url('System/Users/Index')}}">
                <i class="icon-angle-right"></i>
                List of Users
                </a>
              </li>

              
              
            </ul>
          </li>


           <li>
            <a href="javascript:void(0);">
              <i class="icon-cog"></i>
             Settings
            </a>
            <ul class="sub-menu">
              
              
              <li>
                <a href="{{url('/System/SubCounties/Index')}}">
                <i class="icon-angle-right"></i>
                List of Sub Counties
                </a>
              </li>

              
              
            </ul>
          </li>


           <?php endif;?>

 <?php if(Auth::User()->hasRole(['SuperAdmin'])):?>
            <li>
            <a href="javascript:void(0);">
              <i class="icon-windows"></i>
             System Users
            </a>
            <ul class="sub-menu">
              
               <li>
                <a href="{{url('System/Users/Create')}}">
                <i class="icon-angle-right"></i>
                Add New User
                </a>
              </li>
              <li>
                <a href="{{url('System/Users/Index')}}">
                <i class="icon-angle-right"></i>
                System Users
                </a>
              </li>

               <li>
                <a href="{{url('System/Roles/Index')}}">
                <i class="icon-angle-right"></i>
                 System Roles
                </a>
              </li>

               <li>
                <a href="{{url('System/Permissions/Index')}}">
                <i class="icon-angle-right"></i>
                 System Permissions
                </a>
              </li>
              <li>
                <a href="{{url('System/SystemAudit/Index')}}">
                <i class="icon-angle-right"></i>
                 System Recent Audits
                </a>
              </li>
              
            </ul>
          </li>
           <?php endif;?>


             <li>
            <a href="javascript:void(0);">
              <i class="icon-list"></i>
             Manage Orders
            </a>
            <ul class="sub-menu">
              
              
              <li>
                <a href="{{url('System/AdminOrders/Index')}}">
                <i class="icon-angle-right"></i>
               List of Orders
                </a>
              </li>

             
              
            </ul>
          </li>
          <li>
            <a href="javascript:void(0);">
              <i class="icon-list"></i>
             Help
            </a>
            <ul class="sub-menu">
              
              
              <li>
                <a href="{{url('UserGuide.pdf')}}">
                <i class="icon-angle-right"></i>
               Download User manauls
                </a>
              </li>

             
              
            </ul>
          </li>



            <li>
            <a href="{{url('/')}}">
              <i class="icon-windows"></i>
             E-Commerce Frontend
            </a>
           
          </li>

         
          
          
         
        </ul>
        