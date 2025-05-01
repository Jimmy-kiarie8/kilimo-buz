@extends("layouts.app")


@section('content')



      <p>
                                    <a title="Add New Department" href="<?=url('/System/TrainingModule/Create')?>" class="btn btn-sm btn-info"><span class="fa fa-plus"><span>New Training</a>

                                        <a href="<?=url('/System/TrainingModule/Index')?>" class="btn btn-sm btn-success"><span class="fa fa-bars"><span>List of Trainings</a>

                                          <a href="<?=url('/System/TrainingModule/TrainedActors')?>" class="btn btn-sm btn-warning"><span class="fa fa-group"><span>Training Attendance</a>


                                            <a href="<?=url('/System/TrainingModule/ImportAttendance')?>" class="btn btn-sm btn-danger"><span class="fa fa-upload"><span>Import Attendance</a>




                                </p>


        <div class="row">
          <div class="col-md-12">
            <div class="widget box">
              <div class="widget-header">
                <h4><i class="icon-reorder"></i> List Of Trainings Conducted</h4>
                <div class="toolbar no-padding">
                  <div class="btn-group">
                    <span class="btn btn-xs widget-collapse"><i class="icon-angle-down"></i></span>
                  </div>
                </div>
              </div>
              <div class="widget-content"> 
                <div class="table-responsive" style="overflow-x:auto;">
                   <table class="table table-striped table-bordered table-hover "  id="role-datatable"  style="width:100%;">
                     <thead>
                                    <tr class="btn-success">
                                       
                                        <th>Action</th>
                                        <th>County Name</th>
                                        
                                        <th>Training Name</th>
                                        <th>Category</th>
                                        <th>Venue</th>
                                        <th>Date</th>
                                        <th>Male Att</th>
                                        <th>Female Att</th>
                                        <th>Youth</th>
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
            url: '<?=url("System/TrainingModule/fetchList")?>',
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
            {data: 'training_venue', name: 'training_venue'},
            {data: 'training_date', name: 'training_date'},
            {data: 'male_attendees', name: 'male_attendees'},
            {data: 'female_attendees', name: 'female_attendees'},
            {data: 'youth_attendees', name: 'youth_attendees'},
             {data: 'created_at', name: 'created_at'},
            
            
            ],

            dom: 'Bfrtip',

        buttons: [
            { 
      extend: 'excelHtml5',
      className:'btn-danger',
      exportOptions: {
               columns: [1,2,3]
                
            },
      text: '<span>Excel</span>',
      
       },

          { 
      extend: 'csvHtml5',
       className:'btn-success',
      text: '<span>CSV</span>',
      exportOptions: {
               columns: [1,2,3]
                
            },
     
      
       },
        
        {extend: 'print',
         className:'btn-info',
        exportOptions: {
            columns: [1,2,3]
                
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