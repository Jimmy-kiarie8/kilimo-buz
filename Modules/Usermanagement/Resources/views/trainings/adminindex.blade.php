@extends("layouts.app")


@section('content')



      <p>
                                    

                                        <a href="<?=url('/System/TrainingModule/Index')?>" class="btn btn-sm btn-success"><span class="fa fa-bars"><span>List of Trainings</a>

                                          <a href="<?=url('/System/TrainingModule/TrainedActors')?>" class="btn btn-sm btn-warning"><span class="fa fa-group"><span>Training Attendance</a>


                                            




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
                                        <th>#</th>
                                        <th>Avatar</th>
                                        <th>Training Name</th>
                                        <th>Facilitator</th>
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



                 <script id="details-template" type="text/x-handlebars-template">
                                            <br>
                        <div class="label label-info">List Of Trainees</div>
                        <br>
                        <table class="table table-bordered details-table" id="posts-@{{id}}" style="width:100% !important">
                            <thead>
                                <tr class="warning">
                                    <th>ID No</th>
                                    <th>Name</th>
                                    <th>Email Addres</th>
                                    <th>Telephone</th>
                                    <th>Gender</th>
                                    <th>Station</th>
                                    <th>Age Group</th>
                                  </tr>
                            </thead>
                        </table>


                       </script>
               
              </div>
            </div>
          </div>
        </div>
      



    


@stop
@push('scripts')
     <script>
         var template = Handlebars.compile($("#details-template").html());
          
       var otable=$('#role-datatable').DataTable({
        processing: true,
        serverSide: true,
         pageLength:50,
         columnDefs: [{
                            render: function (data, type, full, meta) {
                                return "<div id='dvNotes' style='white-space: normal;width: 175px;'>" + data + "</div>";
                            },
                            targets: 4
                        },

                        {
                            render: function (data, type, full, meta) {
                                return "<div id='dvNotes' style='white-space: normal;width: 150px;'>" + data + "</div>";
                            },
                            targets: 5
                        },

                        {
                            render: function (data, type, full, meta) {
                                return "<div id='dvNotes' style='white-space: normal;width: 130px;'>" + data + "</div>";
                            },
                            targets: 7
                        },
                        




                        ],
        "order": [[ 11, "desc" ]],
        ajax: {
            url: '<?=url("System/TrainingModule/fetchAdminList")?>',
             'type': 'POST',  
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              },
          },
          columns: [
            {data: 'action', name: 'action',searchable:false,orderable:false},
            {data: 'county_name', name: 'county_name'},
             {
                "className":      'details-control',
                "orderable":      false,
                "searchable":      false,
                "data":           null,
                "defaultContent": ''
            },
            {data: 'cover_image', name: 'cover_image'},
            {data: 'training_name', name: 'training_name'},
            {data: 'training_facilitator', name: 'training_facilitator'},
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
               columns: [1,3,4,5,6,7,8,9,10,11]
                
            },
      text: '<span>Excel</span>',
      
       },

          { 
      extend: 'csvHtml5',
       className:'btn-success',
      text: '<span>CSV</span>',
      exportOptions: {
               columns: [1,3,4,5,6,7,8,9,10,11]
                
            },
     
      
       },
        
        {extend: 'print',
         className:'btn-info',
        exportOptions: {
            columns: [1,3,4,5,6,7,8,9,10,11]
                
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


       $('#role-datatable tbody').on('click', 'td.details-control', function () {
          
         
        var tr = $(this).closest('tr');

        var row = otable.row(tr);

        var tableId = 'posts-' + row.data().id;
     


        if (row.child.isShown()) {
            // This row is already open - close it
            row.child.hide();
            tr.removeClass('shown');
        } else {
            // Open this row
            row.child(template(row.data())).show();
            initTable(tableId, row.data());
            tr.addClass('shown');
            tr.next().find('td').addClass('no-padding bg-gray');
        }
    });


        function initTable(tableId, data) {
              
            $('#' + tableId).DataTable({
            processing: true,
            serverSide: true,
             "bSort": false,
            "lengthMenu": [[ -1], ["All"]],
             scrollY: "300px",
        scrollX: true,
        scrollCollapse: true,

        columnDefs: [{
                            render: function (data, type, full, meta) {
                                return "<div id='dvNotes' style='white-space: normal;width: 190px;'>" + data + "</div>";
                            },
                            targets: 1
                        },
                        {
                            render: function (data, type, full, meta) {
                                return "<div id='dvNotes' style='white-space: normal;width: 1.0px;'>" + data + "</div>";
                            },
                            targets: 0
                        }




                        ],
           

            ajax:{
            url:data.details_url,
        'type': 'POST',  
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }},




            columns: [
            {data: 'id_number', name: 'id_number'},
            {data: 'fullnames', name: 'fullnames'},
            {data: 'email_address', name: 'email_address'},
            {data: 'telephone', name: 'telephone'},
            {data: 'gender', name: 'gender'},
            {data: 'station_location', name: 'station_location'},
            {data: 'age_bracket', name: 'age_bracket'},
                 ],


                  dom: 'Bfrtip',

        buttons: [
            { 
      extend: 'excelHtml5',
      className:'btn-danger',
      exportOptions: {
               columns: [0,1,3,4,5,6]
                
            },
      text: '<span>Excel</span>',
      
       },

          { 
      extend: 'csvHtml5',
       className:'btn-success',
      text: '<span>CSV</span>',
      exportOptions: {
               columns: [0,1,3,4,5,6]
                
            },
     
      
       },
        
        {extend: 'print',
         className:'btn-info',
        exportOptions: {
            columns: [0,1,3,4,5,6]
                
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
        })
    }
    </script>
    
@endpush