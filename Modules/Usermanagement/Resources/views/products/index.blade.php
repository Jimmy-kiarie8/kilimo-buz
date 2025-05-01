@extends("layouts.appmain")



@section('content')

 <section class="section">
          <div class="section-body">
            <div class="row">
              <div class="col-12 col-md-12 col-lg-12">
                <div class="card">
                  <div class="card-header">
                    <h4>List of  Member Products</h4>
                  </div>
                  <div class="card-body">


                    <div class="table-responsive">
                   <table class="table table-striped table-bordered table-hover "  id="role-datatable"  style="width:100%;">
                     <thead>
                                    <tr class="info">
                                       
                                        <th>Action</th>
                                        <th>Member Number</th>
                                        <th>Member Name</th>
                                        <th>Value Chain</th>
                                        <th>Variety</th>
                                        <th>Quantity</th>
                                        <th>Units </th>
                                        <th>Unit Selling Price</th>
                                        <th>Color</th>
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
        </div>
                  </section>


               

@endsection
@push('scripts')
     <script>
        
          
       $('#role-datatable').DataTable({
        processing: true,
        serverSide: true,
         pageLength:50,
        "order": [[ 1, "desc" ]],
         ajax: '<?=url("System/MemberProducts/fetchList")?>',
          columns: [
            {data: 'action', name: 'action',searchable:false,orderable:false},
            {data: 'member_number', name: 'member_number'},
            {data: 'member_name', name: 'member_name'},
            {data: 'value_name', name: 'value_name'},
            {data: 'variety', name: 'variety'},
            {data: 'quantity_available', name: 'quantity_available'},
            {data: 'uom', name: 'uom'},
            {data: 'unit_price', name: 'unit_price'},
             {data: 'product_color', name: 'product_color'},
            ],

            dom: 'Bfrtip',

        buttons: [
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
               columns: [1,2,3,4,5,6,7]
                
            },
     
      
       },
        
        {extend: 'print',
         className:'btn-info',
        exportOptions: {
            columns: [1,2,3,4,5,6,7]
                
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