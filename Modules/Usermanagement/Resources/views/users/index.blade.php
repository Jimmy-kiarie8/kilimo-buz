@extends("layouts.app")


@section('content')


        <!--=== Blue Chart ===-->
           <p>
                                    <a href="<?=url('/System/Users/Create')?>" class="btn btn-sm btn-info"><span class="fa fa-plus"><span>Add New User</a>

                                        <a href="<?=url('/System/Users/Index')?>" class="btn btn-sm btn-success"><span class="fa fa-bars"><span>List of System Users</a>



                                </p>

        <div class="row">
          <div class="col-md-12">
            <div class="widget box">
              <div class="widget-header">
                <h4><i class="icon-reorder"></i> List Of Users Registered In The System</h4>
                <div class="toolbar no-padding">
                  <div class="btn-group">
                    <span class="btn btn-xs widget-collapse"><i class="icon-angle-down"></i></span>
                  </div>
                </div>
              </div>
              <div class="widget-content"> 
                <div class="table-responsive"   style="overflow-x:auto;">
                   <table class="table table-striped table-bordered table-hover "  id="role-datatable"  style="width:100%;">
                     <thead>
                                    <tr class="success">
                                       <th>Action</th>
                                        <th>Staff Name</th>
                                         <th>Email Address</th>
                                         <th>Telephone</th>
                                         <th>Role</th>
                                         <th>Gender</th>
                                         <th>County</th>
                                         <th>Account Status</th>
                                         <th>Account Creation</th>
                                         <th>Last Login Date</th>
                                       
                                       
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>


                  
                </table>
                  
                </div>
               
              </div>
            </div>
          </div>
        </div>
      



    


@stop
@push('scripts')
     <script>
        
          
       $('#role-datatable').DataTable({
       processing: true,
        serverSide: true,
        pageLength:100,
        "lengthMenu": [[100, 250, 500,1000,2500,5000, -1], [100, 250, 500,1000,2500,5000, "All"]],

        
        "order": [[ 8, "desc" ]],
        ajax: {
            url: '<?=url("System/Users/fetchList")?>',
             'type': 'POST',  
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              },
          },
          columns: [
            {data: 'action', name: 'action',searchable:false,orderable:false},
           
            {data: 'name', name: 'name'},
            {data: 'email', name: 'email'},
            {data: 'phone', name: 'phone'},
            {data: 'user_role', name: 'user_role'},
            {data: 'gender', name: 'profiles.gender'},
            {data: 'county_name', name: 'county_name'},
            {data: 'user_status', name: 'user_status'},
            {data: 'created_at', name: 'created_at'},
            {data: 'lastlogindate', name: 'lastlogindate'},
            ],

            dom: '<"html5buttons"B>lTfgitp',
                buttons: [
                    
                    {extend: 'csv', title: 'Internal Library Users',
                    exportOptions: {
                 columns: [1,2,3,4,5,6,7],
            },
             className: 'btn btn-info',

        },
                    {extend: 'excel', title: 'Internal Library Users',
                     exportOptions: {
                 columns: [1,2,3,4,5,6,7],
                 orientation: 'landscape',
            },
            className: 'btn btn-success',


                  },
                    {extend: 'pdf', title: 'Internal Library Users',orientation: 'landscape',exportOptions: {
                 columns: [1,2,3,4,5,6,7],
                 orientation: 'landscape',
            },className: 'btn btn-danger',},


                    {extend: 'print',
                      columns: [1,2,3,4,5,6,7],

                     customize: function (win){
                            $(win.document.body).addClass('white-bg');
                            $(win.document.body).css('font-size', '10px');

                            $(win.document.body).find('table')
                                    .addClass('compact')
                                    .css('font-size', 'inherit');
                    }
                    },


                ],
        });
    </script>
    
@endpush