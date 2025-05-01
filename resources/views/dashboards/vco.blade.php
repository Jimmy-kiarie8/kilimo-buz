@extends("layouts.appmain")

<style type="text/css">
  .form-control, .input-group-text, .custom-select, .custom-file-label {
   
    border-color: #ca7857 !important;
}


</style>

@section('content')


 <section class="section">
  <div class="row  d-none" style="margin-bottom: 4%;">
            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-xs-12">

              <a href="{{url('/applicant/Account/SetUp')}}" class="btn btn-info btn-sm" style="margin-left: 15%;">
                <i
                  data-feather="briefcase"></i>
                <span class="fa fa-pencil"></span>Update Personal Profile</a>


            </div>
      </div>
          <div class="row ">
            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-xs-12">
              <div class="card">
                <div class="card-statistic-4">
                  <div class="align-items-center justify-content-between">
                    <div class="row ">
                      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
                        <div class="card-content">
                          <h5 class="font-15">Total Members</h5>
                          <h2 class="mb-3 font-18" id="TotalAdverts">-</h2>
                          <p class="mb-0"><span class="col-green"><a class="col-green" href="{{url('/System/MemberAccount/Index')}}">View List</a></span></p>
                        </div>
                      </div>
                      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pl-0">
                        <div class="banner-img">
                          <img src="assets/img/banner/1.png" alt="">
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-xs-12">
              <div class="card">
                <div class="card-statistic-4">
                  <div class="align-items-center justify-content-between">
                    <div class="row ">
                      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
                        <div class="card-content">
                          <h5 class="font-15">Male</h5>
                          <h2 class="mb-3 font-18" id="TotalApplications">-</h2>
                           <p class="mb-0"><span class="col-orange"><a class="col-orange" href="{{url('/System/MemberAccount/Index')}}">View List</a></span></p>

                         
                        </div>
                      </div>
                      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pl-0">
                        <div class="banner-img">
                          <img src="assets/img/banner/2.png" alt="">
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-xs-12">
              <div class="card">
                <div class="card-statistic-4">
                  <div class="align-items-center justify-content-between">
                    <div class="row ">
                      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
                        <div class="card-content">
                          <h5 class="font-15">Female</h5>
                          <h2 class="mb-3 font-18" id="PendingApproval">-</h2>
                            <p class="mb-0"><span class="col-green"><a class="col-green" href="{{url('/System/MemberAccount/Index')}}">View List</a></span></p>
                        </div>
                      </div>
                      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pl-0">
                        <div class="banner-img">
                          <img src="assets/img/banner/3.png" alt="">
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-xs-12">
              <div class="card">
                <div class="card-statistic-4">
                  <div class="align-items-center justify-content-between">
                    <div class="row ">
                      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
                        <div class="card-content">
                          <h5 class="font-15">Orders Recei...</h5>
                          <h2 class="mb-3 font-18" id="Rejected">-</h2>
                          <p class="mb-0"><span class="col-green"><a class="col-orange" href="#">View List</a></span></p>
                        </div>
                      </div>
                      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pl-0">
                        <div class="banner-img">
                          <img src="assets/img/banner/4.png" alt="">
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          
         
          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-header">
                  <h4>Recently Updated Member Products</h4>
                  <div class="card-header-form">
                    <form>
                      <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search" id="seachTable">
                        <div class="input-group-btn" >
                          <button class="btn btn-success" style="height:100%;" ><i class="fas fa-search"></i></button>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
                <div class="card-body p-0">
                  <div class="table-responsive">
                    <table class="table table-bordered">
                      <thead>
                          <tr  style="background-color: #b8e1ac !important">
                        <th>Datetime</th>
                        <th>Value Chain</th>
                        <th>Product</th>
                       
                        <th>Quantity</th>
                        <th>Unit Price</th>
                        <th>Member Name</th>
                        <th>Telephone</th>
                        
                      </tr>
                        
                      </thead>
                      <tbody id="MyData">
                         
                        
                      </tbody>
                    
                      
                    
                      
                     
                     
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
          
        </section>


               

@endsection
@push('scripts')
<script type="text/javascript">
  var url="<?=url('/System/Product/GetMostRecentPosts')?>";
       $.get(url,function(data){
         $("#MyData").html(data);
       });

   var url="<?=url('/System/VCODashboard/GetMainData')?>";

       $.get(url,function(data){
        $("#TotalAdverts").html(data.Total);
         $("#TotalApplications").html(data.MyTotal);
          $("#PendingApproval").html(data.PendingApproval);
            $("#Rejected").html(data.Rejected);


       });


        $("body").on("input","#seachTable",function(e){
          
    var value = this.value.toLowerCase().trim();

    $("table tr").each(function (index) {
        if (!index) return;
        $(this).find("td").each(function () {
            var id = $(this).text().toLowerCase().trim();
            var not_found = (id.indexOf(value) == -1);
            $(this).closest('tr').toggle(!not_found);
            return not_found;
        });
    });


  });
</script>


@endpush