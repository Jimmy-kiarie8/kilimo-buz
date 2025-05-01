@extends("layouts.app")


@section('content')



        <!--=== Blue Chart ===-->
         
          <p>
            <a href="{{url('/System/VCOMembers/Create')}}" class="btn btn-info">Add Member</a>

            <a href="{{url('/System/VCOMembers/ImportMembers')}}" class="btn btn-danger">Import Members</a>
          </p>
        <div class="row">
          <div class="col-md-12">
            <div class="widget box">
              <div class="widget-header">
                <h4><i class="icon-reorder"></i> List Of  Registered VCO Members</h4>
                <div class="toolbar no-padding">
                  <div class="btn-group">
                    <span class="btn btn-xs widget-collapse"><i class="icon-angle-down"></i></span>
                  </div>
                </div>
              </div>
              <div class="widget-content"> 
              
                   <div class="table-responsive"  style="overflow-x:auto;">
                   
                   <table class="table table-striped table-bordered table-hover "  id="Orgdatatable"  style="width:100%;">
                     <thead>
                                    <tr class="btn-success">
                                       
                                        <th>Action</th>
                                        <th>Number</th>
                                        <th>Member Name</th>
                                        <th>Telephone</th>
                                        <th>Group Name</th>
                                        <th>County</th>
                                        
                                        <th>Node</th>
                                        <th>Value Chain</th>
                                        <th>Gender</th>
                                        
                                        <th>Datetime Created</th>
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
        
          
       $('#Orgdatatable').DataTable({
        processing: true,
        serverSide: true,
         pageLength:50,
        "order": [[ 1, "desc" ]],
           ajax: '<?=url("System/Member/fetchAdminList")?>',
          columns: [
            {data: 'action', name: 'action',searchable:false,orderable:false},
            {data: 'member_number', name: 'member_number'},
            {data: 'member_name', name: 'member_name'},
             {data: 'member_telephone', name: 'member_telephone'},
            {data: 'org_name', name: 'org_name'},
            {data: 'county_name', name: 'county_name'},
            {data: 'node_name', name: 'node_name'},
            {data: 'value_name', name: 'value_name'},
            {data: 'gender', name: 'gender'},
            {data: 'created_at', name: 'created_at'},
            ],

            dom: 'Bfrtip',

        buttons: [
            { 
      extend: 'excelHtml5',
      className:'btn-danger',
      exportOptions: {
               columns: [1,2,3,4,5,6,7,8]
                
            },
      text: '<span>Excel</span>',
      
       },

          { 
      extend: 'csvHtml5',
       className:'btn-success',
      text: '<span>CSV</span>',
      exportOptions: {
               columns: [1,2,3,4,5,6,7,8]
                
            },
     
      
       },
        
        {extend: 'print',
         className:'btn-info',
        exportOptions: {
            columns: [1,2,3,4,5,6,7,8]
                
            },
           text: '<span >Print</span>',
                     customize: function (win){
                            $(win.document.body).addClass('white-bg');
                            $(win.document.body).css('font-size', '10px');

                            $(win.document.body).find('table')
                                    .addClass('compact')
                                    .css('font-size', 'inherit');
        }},
        ],
        });
    </script>
    
@endpush