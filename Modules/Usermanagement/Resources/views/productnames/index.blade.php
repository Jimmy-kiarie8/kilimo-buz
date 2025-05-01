@extends("layouts.app")


@section('content')



        <!--=== Blue Chart ===-->
           <p>
                                    <a title="Add New Department" href="<?=url('/System/ProductNames/Create')?>" class="btn btn-sm btn-info"><span class="fa fa-plus"><span>New Product Name</a>

                                        <a href="<?=url('/System/ProductNames/Index')?>" class="btn btn-sm btn-success"><span class="fa fa-bars"><span>List of Product Names </a>



                                </p>

        <div class="row">
          <div class="col-md-12">
            <div class="widget box">
              <div class="widget-header">
                <h4><i class="icon-reorder"></i> List Of Product Names</h4>
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
                                        <th>Value Chain</th>
                                        <th>avatar</th>
                                        <th>Product Name</th>
                                         <th>#</th>
                                        <th>Product Code</th>
                                        <th>Market Price</th>
                                        <th>Units</th>
                                        <th>Date Created</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>


                  
                </table>
                  
                </div>

                  <script id="details-template" type="text/x-handlebars-template">
                                            <br>
                        <div class="label label-info">Product Metadatas</div>
                        <br>
                        <table class="table table-bordered details-table" id="posts-@{{id}}" style="width:100% !important">
                            <thead>
                                <tr class="warning">
                                    <th>Action</th>
                                    <th>Meta Name</th>
                                    <th>Mata Value</th>
                                  
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
        "order": [[8, "desc" ]],
        ajax: {
            url: '<?=url("System/ProductNames/fetchList")?>',
             'type': 'POST',  
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              },
          },
          columns: [
            {data: 'action', name: 'action',searchable:false,orderable:false},
            {data: 'value_name', name: 'value_name'},
            {data: 'product_image', name: 'product_image'},
            {data: 'product_name', name: 'product_name'},
             {
                "className":      'details-control',
                "orderable":      false,
                "searchable":      false,
                "data":           null,
                "defaultContent": ''
            },
            {data: 'product_code', name: 'product_code'},
            {data: 'product_price', name: 'product_price'},
            {data: 'product_uom', name: 'product_uom'},
            {data: 'created_at', name: 'created_at'},
            ],

            dom: 'Bfrtip',

        buttons: [
            { 
      extend: 'excelHtml5',
      className:'btn-danger',
      exportOptions: {
               columns: [1,2,3,4,5,6]
                
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
            {data: 'action', name: 'action',searchable:false,orderable:false},
            {data: 'key', name: 'key'},
            {data: 'value', name: 'value'},
            ],


              
        })
    }
    </script>
    
@endpush