@extends('layouts.frontend')
@section('content')
<div class="container-fluid">

   <div class="card">
  <div class="card-body">
     <div class="table-responsive">
        <table>
            <table class="table table-striped table-bordered table-hover "  id="Orgdatatable"  style="width:100%;">
                     <thead>
                        <tr>
                            <th></th>
                            <th><input type="text" name="" class="form-control mysearch"></th>
                             <th><input type="text" name="" class="form-control mysearch"></th>
                              <th><input type="text" name="" class="form-control mysearch"></th>
                               <th><input type="text" name="" class="form-control mysearch"></th>
                                <th><input type="text" name="" class="form-control mysearch"></th>
                                 <th><input type="text" name="" class="form-control mysearch"></th>
                                 <th><input type="text" name="" class="form-control mysearch"></th>
                                <th><input type="text" name="" class="form-control mysearch"></th>
                                 <th><input type="text" name="" class="form-control mysearch"></th>
                        </tr>
                                    <tr class="btn-success">
                                       
                                        <th>Action</th>
                                         <th>VCO Group Name</th>
                                          <th>County</th>
                                        <th>Sub County</th>
                                       
                                       
                                        <th>Value Chain</th>
                                        <th>Product</th>
                                        <th>Quantity</th>
                                        <th>UOM</th>
                                        <th>Unit Price</th>
                                        <th>Last Updated At</th>
                                        
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>


                  
                </table>
        </table>
         

     </div>
  </div>
</div>
    

</div>



@stop
@push('scripts')
     <script>
        
          
    var otable=   $('#Orgdatatable').DataTable({
        processing: true,
        serverSide: true,
         pageLength:10,
          columnDefs: [{
                            render: function (data, type, full, meta) {
                                return "<div id='dvNotes' style='white-space: normal;width: 180px;'>" + data + "</div>";
                            },
                            targets: 1
                        },
                        



                        ],
        "order": [[ 9, "desc" ]],
           ajax: '<?=url("MemberProducts/fetchList")?>',
          columns: [
            {data: 'action', name: 'action',searchable:false,orderable:false},
            {data: 'org_name', name: 'org_name'},
            {data: 'county_name', name: 'county_name'},
            {data: 'sub_county_name', name: 'sub_county_name'},
            {data: 'value_name', name: 'value_name'},
            {data: 'variety', name: 'variety'},
            {data: 'quantity_available', name: 'quantity_available'},
            {data: 'unit_abbreviation', name: 'unit_abbreviation'},
            {data: 'unit_price', name: 'unit_price'},
             {data: 'updated_at', name: 'updated_at'},
            
            ],

            dom: 'Bfrtip',

        buttons: [
            { 
      extend: 'excelHtml5',
      className:'btn-danger',
      exportOptions: {
               columns: [1,2,3,4,5,6,7,8,9]
                
            },
      text: '<span>Excel</span>',
      
       },

          { 
      extend: 'csvHtml5',
       className:'btn-success',
      text: '<span>CSV</span>',
      exportOptions: {
               columns: [1,2,3,4,5,6,7,8,9]
                
            },
     
      
       },
        
        {extend: 'print',
         className:'btn-info',
        exportOptions: {
            columns: [1,2,3,4,5,6,7,8,9]
                
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


        $(".mysearch").on( 'keyup change', function () {
               
                
                otable
                    .column( $(this).parent().index()+':visible' )
                    .search( this.value )
                    .draw();
                    
            } );
    </script>
    
@endpush
