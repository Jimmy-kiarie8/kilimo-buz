@extends('front.main')

@section('crumb')
<!-- BEGIN #page-header -->
        <div id="page-header" class="section-container page-header-container bg-black">
            <!-- BEGIN page-header-cover -->
            <div class="page-header-cover">
                <img src="{{ asset('f/assets/img/maizevco.jpg')}}" alt="" />
            </div>
            <!-- END page-header-cover -->
            <!-- BEGIN container -->
            <div class="container">
                <h1 class="page-header">Search Results for <b>VCOs</b></h1>
            </div>
            <!-- END container -->
        </div>
        <!-- BEGIN #page-header -->
@endsection

@section('content')

<!-- BEGIN search-results -->
        <div class="section-container">
            <!-- BEGIN container -->
            <div class="container">
                <!-- BEGIN search-container -->
                <div class="checkout">
                    <!-- BEGIN search-content -->
                    <div class="search-content">
                        <!-- BEGIN search-toolbar -->
                        <div class="search-toolbar">
                            <!-- BEGIN row -->
                            <div class="row">
                                <!-- BEGIN col-6 -->
                                <div class="col-md-6">
                                    <h4>We found {{$count}} Items for County Statistics</h4>
                                </div>
                                <!-- END col-6 -->
                                <!-- BEGIN col-6 -->
                                <div class="col-md-6 text-right">
                                    <ul class="sort-list">
                                        <li class="text"><i class="fa fa-filter"></i> Sort by:</li>
                                        <li class="active"><a href="#">Popular</a></li>
                                        <li><a href="#">County</a></li>
                                        <li><a href="#">Value Chain</a></li>
                                        
                                    </ul>
                                </div>
                                <!-- END col-6 -->
                            </div>
                            <!-- END row -->
                        </div>
                        <!-- END search-toolbar -->
                        <!-- BEGIN search-item-container -->
                        <div class="search-item-container">
                            <div class="row">
                                <div class="col-md-12">
                                    
                               
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped" id="Orgdatatable"  style="width:100%;">
                                        <thead>
                                            <tr class="success">
                                                <th>County Name</th>
                                                <th>No of VCOs</th>
                                                <th>Males</th>
                                                <th>Females</th>
                                                <th>Total</th>
                                            </tr>
                                        </thead>
                                        
                                    </table>
                                    
                                </div>
                            </div>
                                
                            </div>
                            <!-- BEGIN item-row -->





                          
                              
                           
                        </div>
                        <!-- END search-item-container -->
                        <!-- BEGIN pagination -->
                       
                        <!-- END pagination -->
                    </div>
                    <!-- END search-content -->
                    <!-- BEGIN search-sidebar -->
                   
                </div>
                <!-- END search-container -->
            </div>
            <!-- END container -->
        </div>
        <!-- END search-results -->
@endsection
@push('scripts')
     <script>
        
          
    var otable=   $('#Orgdatatable').DataTable({
        processing: true,
        serverSide: true,
         pageLength:12,
          columnDefs: [{
                            render: function (data, type, full, meta) {
                                return "<div id='dvNotes' style='white-space: normal;width: 120px;'>" + data + "</div>";
                            },
                            targets: 0
                        },
                        



                        ],
        "order": [[ 0, "asc" ]],
           ajax: '<?=url("CountyStats/fetchList")?>',
          columns: [
            
            {data: 'county_name', name: 'county_name'},
            {data: 'vcos', name: 'vcos'},
            {data: 'Males', name: 'Males'},
            {data: 'Female', name: 'Female'},
            {data: 'total', name: 'total'},
             ],

            
        });


    </script>
    
@endpush