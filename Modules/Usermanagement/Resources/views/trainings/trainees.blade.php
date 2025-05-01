@extends("layouts.app")


@section('content')



        <!--=== Blue Chart ===-->
        <p>
                            <a href="<?=url('/System/TrainingModule/Admin')?>" class="btn btn-sm btn-success"><span class="fa fa-bars"><span>List of Trainings</a>

                                          <a href="<?=url('/System/System/TrainingModule/Trainees')?>" class="btn btn-sm btn-warning"><span class="fa fa-group"><span>Training Attendance</a>




                                </p>


        <div class="row">
          <div class="col-md-12">
            <div class="widget box">
              <div class="widget-header">
                <h4><i class="icon-reorder"></i> List Of Trained VCO/Service Providers</h4>
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
                                    <tr class="btn-success">
                                       
                                        <th>Action</th>
                                        <th>County Name</th>
                                        <th>Training Name</th>
                                        <th>Category</th>
                                        <th>Names</th>
                                        <th>Id Num</th>
                                        <th>Gender</th>
                                        <th>Telephone</th>
                                        <th>Email Address</th>
                                        <th>Station</th>
                                        <th>Age Bracket</th>
                                        <th>Created At</th>
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
         pageLength:50,
        "order": [[ 1, "asc" ]],
        ajax: {
            url: '<?=url("System/TrainingModule/fetchAdminAttendances")?>',
             'type': 'POST',  
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              },
          },
          columns: [
            {data: 'action', name: 'action',searchable:false,orderable:false},
            {data: 'county_name', name: 'county_name'},
            {data: 'training_name', name: 'training_name'},
            {data: 'category', name: 'category'},
            {data: 'fullnames', name: 'fullnames'},
            {data: 'id_number', name: 'id_number'},
            {data: 'gender', name: 'gender'},
            {data: 'telephone', name: 'telephone'},
            {data: 'email_address', name: 'email_address'},
            {data: 'station_location', name: 'station_location'},
            {data: 'age_bracket', name: 'age_bracket'},
            {data: 'created_at', name: 'created_at'},
            
            
            ],

            dom: 'Bfrtip',

        buttons: [
            { 
      extend: 'excelHtml5',
      className:'btn-danger',
      exportOptions: {
               columns: [1,2,3,4,5,6,7,8,9,10,11]
                
            },
      text: '<span>Excel</span>',
      
       },

          { 
      extend: 'csvHtml5',
       className:'btn-success',
      text: '<span>CSV</span>',
      exportOptions: {
               columns: [1,2,3,4,5,6,7,8,9,10,11]
                
            },
     
      
       },
        
        {extend: 'print',
         className:'btn-info',
        exportOptions: {
            columns: [1,2,3,4,5,6,7,8,9,10,11]
                
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