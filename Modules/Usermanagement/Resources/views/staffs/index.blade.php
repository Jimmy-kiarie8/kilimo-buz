@extends("layouts.app")


@section('content')
 <p>
                                    
                                    <a href="<?=url('System/Staff/CreateNew')?>" class="btn btn-sm btn-primary"><span class="fa fa-bars"><span>Add New Staff</a>

                                        <a href="<?=url('/System/Staff/Index')?>" class="btn btn-sm btn-success"><span class="fa fa-bars"><span>List of Staffs </a>



                                </p>


        <div class="row">
          <div class="col-md-12">
            <div class="widget box">
              <div class="widget-header">
                <h4><i class="icon-reorder"></i> List Of Registered County Staffs</h4>
                <div class="toolbar no-padding">
                  <div class="btn-group">
                    <span class="btn btn-xs widget-collapse"><i class="icon-angle-down"></i></span>
                  </div>
                </div>
              </div>
              <div class="widget-content no-padding"> 
                <div class="table-responsive"  style="overflow-x:auto;">
                   <table class="table table-striped table-bordered table-hover no-padding " style="width: 100%;" id="role-datatable"  >
                     <thead>
                                    <tr class="btn-info">
                                       
                                        <th>Action</th>
                                        <th>Title</th>
                                        <th>Full Names</th>
                                        <th>Personal No</th>
                                        <th>Designition</th>
                                        <th>Job Group</th>
                                        <th>D.O.B</th>
                                        <th>Gender</th>
                                        <th>Ethnicity</th>
                                        <th>Religion</th>
                                        <th>Qualification</th>
                                        <th>Department</th>
                                        <th>Employment Type</th>
                                       
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
        responsive: true,
         pageLength:50,
        "order": [[ 3, "desc" ]],
        ajax: {
            url: '<?=url("System/Staffs/fetchList")?>',
             'type': 'POST',  
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              },
          },
          columns: [
            {data: 'action', name: 'action',searchable:false,orderable:false},
            {data: 'title', name: 'title'},
            {data: 'name', name: 'name'},
            {data: 'personal_number', name: 'personal_number'},
            {data: 'designition_name', name: 'designition_name'},
            {data: 'job_group_name', name: 'job_group_name'},
            {data: 'dob', name: 'dob'},
            {data: 'gender', name: 'gender'},
       
            {data: 'ethinicity', name: 'ethinicity'},
            {data: 'religion', name: 'religion'},
            {data: 'qualification', name: 'qualification'},
            {data: 'department_name', name: 'department_name'},
            {data: 'employment_type', name: 'employment_type'},
            ],

            dom: 'Bfrtip',

        buttons: [
            { 
      extend: 'excelHtml5',
      className:'btn-danger',
      exportOptions: {
               columns: [1,2,3,4,5,6,7,8,9,10,11,12]
                
            },
      text: '<span>Excel</span>',
      
       },

          { 
      extend: 'csvHtml5',
       className:'btn-success',
      text: '<span>CSV</span>',
      exportOptions: {
               columns: [1,2,3,4,5,6,7,8,9,10,11,12]
                
            },
     
      
       },
        
        {extend: 'print',
         className:'btn-info',
        exportOptions: {
            columns: [1,2,3,4,5,6,7,8,9,10,11,12]
                
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