@extends("layouts.app")


@section('content')



        <!--=== Blue Chart ===-->
          

        <div class="row">
          <div class="col-md-12">
            <div class="widget box">
              <div class="widget-header">
                <h4><i class="icon-reorder"></i> List Of Product  Orders Received</h4>
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
                                        <th>County</th>
                                        <th>Organization Name</th>
                                        <th>Order Date</th>
                                        <th>Ref No</th>
                                        <th>Buyer Name</th>
                                        <th>Buyer Telephone</th>
                                        <th>Value Chain</th>
                                        <th>Product Name</th>
                                        
                                        <th>Quantity</th>
                                        <th>Units</th>
                                       
                                        <th>Seller Name</th>
                                        <th>Seller Phone</th>

                                        
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
        "order": [[ 2, "desc" ]],
        ajax: {
            url: '<?=url("System/Orders/fetchList")?>',
             'type': 'POST',  
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              },
          },
          columns: [
            {data: 'countyname', name: 'countyname'}, 
            {data: 'vconame', name: 'vconame'},
            {data: 'order_date', name: 'order_date'},
            {data: 'ref_number', name: 'ref_number'},
            {data: 'customer_name', name: 'customer_name'},
            {data: 'customer_phone', name: 'customer_phone'},
            {data: 'value_chain_name', name: 'value_chain_name'},
            {data: 'variety', name: 'variety'},
            {data: 'qty', name: 'qty'},
            {data: 'unit', name: 'unit'},
            {data: 'sellername', name: 'sellername'},
            {data: 'sellermobilenumber', name: 'sellermobilenumber'},
            
            ],

            dom: 'Bfrtip',

        buttons: [
            { 
      extend: 'excelHtml5',
      className:'btn-xs btn-danger',
      exportOptions: {
               columns: [1,2,3,4,5,6,7,8,9,10,11]
                
            },
      text: '<span>Excel</span>',
      
       },

          { 
      extend: 'csvHtml5',
       className:'btn-xs btn-success',
      text: '<span>CSV</span>',
      exportOptions: {
               columns: [1,2,3,4,5,6,7,8,9,10,11]
                
            },
     
      
       },
        
        {extend: 'print',
         className:'btn-xs btn-info',
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