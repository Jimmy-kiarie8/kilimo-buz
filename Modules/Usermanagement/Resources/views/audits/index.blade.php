@extends("layouts.app")


@section('content')
<div class="row">
          <div class="col-md-12">
            <div class="widget box">
              <div class="widget-header">
                <h4><i class="icon-reorder"></i> Most Recent System Audit Trails</h4>
                <div class="toolbar no-padding">
                  <div class="btn-group">
                    <span class="btn btn-xs widget-collapse"><i class="icon-angle-down"></i></span>
                  </div>
                </div>
              </div>
              <div class="widget-content"> 
                <div class="table-responsive"  style="overflow-x:auto;">
                   <table class="table table-striped table-bordered table-hover no-padding " style="width: 100%;" id="role-datatable"  >
                     <thead>
                                    <tr class="btn-info">
                                       
                                        <th>Datetime</th>
                                        <th>User Names</th>
                                        <th>Access Right</th>
                                        <th>Event Name</th>
                                        <th>Module Name</th>
                                      
                                        <th>Ip Address</th>
                                        <th>Severity</th>
                                        <th>Description</th>                                    </tr>
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
        "order": [[ 0, "desc" ]],
        ajax: '<?=url("System/Audit/fetchList")?>',
               columns: [
          
            {data: 'event_date', name: 'event_date'},
            {data: 'name', name: 'name'},
            {data: 'access_level', name: 'access_level'},
            {data: 'event_name', name: 'event_name'},
            {data: 'module_name', name: 'module_name'},
            {data: 'ip_address', name: 'ip_address'},
            {data: 'severity', name: 'severity'},
            {data: 'event_description', name: 'event_description'},
          ],

            dom: 'Bfrtip',

        buttons: [
            { 
      extend: 'excelHtml5',
      className:'btn-danger',
      exportOptions: {
               columns: [1,2]
                
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