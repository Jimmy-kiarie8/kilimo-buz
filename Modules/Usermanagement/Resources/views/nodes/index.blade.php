@extends("layouts.app")


@section('content')



        <!--=== Blue Chart ===-->
           <p>
                                    <a data-title="Add New Node" data-url="<?=url('/System/NodeTypes/Create')?>" class="btn btn-sm btn-info reject-modal"><span class="fa fa-plus"><span>Add New Node</a>

                                        <a href="<?=url('/System/NodeTypes/Index')?>" class="btn btn-sm btn-success"><span class="fa fa-bars"><span>List of  Nodes </a>



                                </p>

        <div class="row">
          <div class="col-md-12">
            <div class="widget box">
              <div class="widget-header">
                <h4><i class="icon-reorder"></i> List Of Nodes</h4>
                <div class="toolbar no-padding">
                  <div class="btn-group">
                    <span class="btn btn-xs widget-collapse"><i class="icon-angle-down"></i></span>
                  </div>
                </div>
              </div>
              <div class="widget-content"> 
                <div class="table-responsive">
                   <table class="table table-striped table-bordered table-hover "  id="role-datatable"  style="width:100%;">
                     <thead>
                                    <tr class="btn-success">
                                       
                                        <th>Action</th>
                                        <th>Node Name</th>
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
        
          
       $('#role-datatable').DataTable({
        processing: true,
        serverSide: true,
         pageLength:50,
        "order": [[ 1, "asc" ]],
      
           ajax: '<?=url("System/Node/fetchList")?>',
          columns: [
            {data: 'action', name: 'action',searchable:false,orderable:false},
            {data: 'node_name', name: 'node_name'},
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