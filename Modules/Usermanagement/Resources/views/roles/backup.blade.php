@extends('layouts.main')


@section('breadcrumb')
<header class="page-header">
                        <h2>User Management</h2>
                    
                        <div class="right-wrapper text-right">
                            <ol class="breadcrumbs">
                                <li>
                                    <a href="<?=url('/home')?>">
                                        <i class="fa fa-home"></i>
                                    </a>
                                </li>

                                <li>
                                    <a href="<?=url()->current()?>">Permissions</a>
                                </li>
                                <li class="active">
                                    <span>Index</span>
                                </li>

                
                            </ol>
                    
                            <a class="sidebar-right-toggle" data-open="sidebar-right"><i class="fa fa-chevron-left"></i></a>
                        </div>
</header>
@stop


@section('content')
    <p>

                             



                     <div class="col-lg-12">



 
                     



                    <div class="row">

                            <div class="col-md-12">
                                <p>
                                    <a href="<?=url('/System/Roles/Create')?>" class="btn btn-sm btn-info"><span class="fa fa-plus"><span>Add New Roles</a>

                                        <a href="<?=url('/System/Roles/Index')?>" class="btn btn-sm btn-success"><span class="fa fa-bars"><span>List of Roles</a>



                                </p>

                                <section class="card card-featured card-featured-info">
                                <header class="card-header">
                                    <div class="card-actions">
                                        <a href="#" class="card-action card-action-toggle" data-card-toggle=""></a>
                                        <!-- <a href="#" class="card-action card-action-dismiss" data-card-dismiss=""></a> -->
                                    </div>
                                    <h2 class="card-title">List Of System Permission</h2>
                                </header>
                                <div class="card-body" style="display: block;">

                                      <div class="table-responsive panel-collapse pull out">
                                    <table id="role-datatable" class="table table-hover table-bordered">
                                <thead>
                                    <tr class="info">
                                       
                                      
                                        <th>Category</th>
                                        <th>Name</th>
                                        <th>Guard</th>
                                         
                                         <th>Datetime Created</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>

                                </div>
                            </section>
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
        "order": [[ 3, "desc" ]],
        ajax: {
            url: '<?=url("System/Permissions/fetchList")?>',
             'type': 'POST',  
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              },
          },
          columns: [
            {data: 'perm_category', name: 'perm_category'},
            {data: 'name', name: 'name'},
            {data: 'guard_name', name: 'guard_name'},
            {data: 'created_at', name: 'created_at'},
            ],

            dom: 'Bfrtip',

        buttons: [
            { 
      extend: 'excelHtml5',
      exportOptions: {
               columns: [1,2,3,4]
                
            },
      text: '<span>Excel</span>',
      
       },

          { 
      extend: 'csvHtml5',
      text: '<span>CSV</span>',
      exportOptions: {
               columns: [1,2,3,4]
                
            },
     
      
       },
        
        {extend: 'print',
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