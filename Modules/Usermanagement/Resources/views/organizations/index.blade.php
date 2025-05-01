@extends("layouts.app")


@section('content')



        <!--=== Blue Chart ===-->
          <p>
           <a href="<?=url('/System/Entities/Create')?>" class="btn btn-sm btn-info"><span class="fa fa-plus"><span>Add New</a>
           <a href="<?=url('/System/Entities/Index')?>" class="btn btn-sm btn-success"><span class="fa fa-bars"><span>List of VCOs</a>
              <?php if(Auth::User()->hasRole("SuperAdmin")):?>
             <a href="<?=url('/System/Entities/Import')?>" class="btn btn-sm btn-danger"><span class="fa fa-upload"><span>Import VCOs</a>
               <?php endif;?>

           </p>


        <div class="row">
          <div class="col-md-12">
            <div class="widget box">
              <div class="widget-header">
                <h4><i class="icon-reorder"></i> List Of  Registered VCOs</h4>
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
                                        <th>VCO Name</th>
                                        <th>County</th>
                                        <th>Sub County</th>
                                        <th>Node</th>
                                        <th>Value Chain</th>
                                        <th>Email</th>
                                        <th>Telephone</th>
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
        "order": [[ 9, "desc" ]],
         "lengthMenu": [[50, 250, 500, -1], [50, 250, 500, "All"]],
           ajax: '<?=url("System/Entities/fetchList")?>',
          columns: [
            {data: 'action', name: 'action',searchable:false,orderable:false},
            {data: 'org_number', name: 'org_number'},
            {data: 'org_name', name: 'org_name'},
            {data: 'county_name', name: 'county_name'},
            {data: 'subcountyname', name: 'subcountyname'},
            {data: 'node_name', name: 'node_name'},
            {data: 'value_name', name: 'value_name'},
            {data: 'org_email', name: 'org_email'},
            {data: 'org_tephone', name: 'org_tephone'},
            {data: 'created_at', name: 'created_at'},
            ],

            dom: 'Bfrtip',

        buttons: [
         'pageLength',
            { 
      extend: 'excelHtml5',
      className:'btn-danger',
      exportOptions: {
               columns: [1,2,3,4,5,6,7]
                
            },
      text: '<span>Excel</span>',
      
       },

          { 
      extend: 'csvHtml5',
       className:'btn-success',
      text: '<span>CSV</span>',
      exportOptions: {
               columns: [1,2]
                
            },
     
      
       },
        
        {extend: 'print',
         className:'btn-info',
        exportOptions: {
            columns: [1,2]
                
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