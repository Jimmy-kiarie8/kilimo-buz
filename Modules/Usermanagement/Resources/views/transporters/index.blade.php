@extends("layouts.appmain")



@section('content')

 <section class="section">
          <div class="section-body">
            
            <div class="row">
              <div class="col-md-12" style="margin-bottom: 1%;">
                 <a href="{{url('/System/MemberAccount/Create')}}" class="btn btn-sm btn-info">Add New Member</a>

                  <a href="{{url('/System/MemberAccount/Index')}}" class="btn btn-sm btn-success">Registered Transporters</a>

               
                
              </div>
              <div class="col-12 col-md-12 col-lg-12">
                <div class="card">
                  <div class="card-header">
                    <h4>List of Registered Transporters Registered By Counties</h4>
                  </div>
                  <div class="card-body">


                    <div class="table-responsive">
                   <table class="table table-striped table-bordered table-hover "  id="role-datatable"  style="width:100%;">
                     <thead>
                                    <tr class="info">
                                       
                                        <th>Action</th>
                                        <th>Member Number</th>
                                        <th>Name</th>
                                        <th>Id Number </th>
                                        <th>Location</th>
                                        <th>Gender</th>
                                        <th>Node </th>
                                        <th>Value Chain</th>
                                        <th>Status</th>
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
        </section>


               

@endsection
@push('scripts')
     <script>
        
          
       $('#role-datatable').DataTable({
        processing: true,
        serverSide: true,
         pageLength:50,
        "order": [[ 1, "desc" ]],
         "lengthMenu": [[50, 250, 500, -1], [50, 250, 500, "All"]],
         ajax: '<?=url("System/Members/fetchList")?>',
          columns: [
            {data: 'action', name: 'action',searchable:false,orderable:false},
            {data: 'member_number', name: 'member_number'},
            {data: 'member_name', name: 'member_name'},
            {data: 'id_number', name: 'id_number'},
            {data: 'location', name: 'location'},
            {data: 'gender', name: 'gender'},
            {data: 'node_name', name: 'node_name'},
             {data: 'value_name', name: 'value_name'},
             {data: 'member_status', name: 'member_status'},
            ],

            dom: 'Bfrtip',

        buttons: [

        'pageLength',
            { 
      extend: 'excelHtml5',
      className:'btn-danger',
      exportOptions: {
               columns: [1,2,3,4]
                
            },
      text: '<span>Excel</span>',
      
       },

          { 
      extend: 'csvHtml5',
       className:'btn-success',
      text: '<span>CSV</span>',
      exportOptions: {
               columns: [1,2,3,4]
                
            },
     
      
       },
        
        {extend: 'print',
         className:'btn-info',
        exportOptions: {
            columns: [1,2,3,4]
                
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