@extends("layouts.app")


@section('content')



        <!--=== Blue Chart ===-->
           <p>
                                    <a data-title="Add New Clan" data-url="<?=url('/System/SubClans/Create')?>" class="btn btn-sm btn-info reject-modal"><span class="fa fa-plus"><span>Add New Sub Clan</a>

                                        <a href="<?=url('/System/Clans/Index')?>" class="btn btn-sm btn-success"><span class="fa fa-bars"><span>List of Sub Clans </a>



                                </p>

        <div class="row">
          <div class="col-md-12">
            <div class="widget box">
              <div class="widget-header">
                <h4><i class="icon-reorder"></i> List Of Sub Clans</h4>
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
                                    <tr class="btn-info">
                                       
                                        <th>Action</th>
                                        <th>Ethnic Group</th>
                                        <th>Clan Name</th>
                                        <th>Sub Clan Name</th>
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
        ajax: {
            url: '<?=url("System/SubClans/fetchList")?>',
             'type': 'POST',  
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              },
          },
          columns: [
            {data: 'action', name: 'action',searchable:false,orderable:false},
            {data: 'ethnic_name', name: 'ethnic_name'},
            {data: 'clan_name', name: 'clan_name'},
            {data: 'sub_clan_name', name: 'sub_clan_name'},
            {data: 'created_at', name: 'created_at'},
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