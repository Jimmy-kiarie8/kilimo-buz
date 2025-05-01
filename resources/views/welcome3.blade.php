@extends('layouts.masterfooterless')

@section('main')
<style type="text/css">
    
  .table {
    color: black;
}

 th, td { white-space: nowrap; }





</style>
    <main id="main">

        <!-- ======= Breadcrumbs ======= -->
        <section id="breadcrumbs" class="breadcrumbs">
            <div class="container">

                <div class="d-flex justify-content-between align-items-center">
                    <ol>
                        <li><a href="{{ url('/') }}">Home</a></li>
                        <li>Login</li>
                    </ol>
                </div>

            </div>
        </section>
        <!-- End Breadcrumbs -->

        <section id="login" class="contact">
            <div class="container-fluid">

   <div class="card">
  <div class="card-body">
     <div class="table-responsive">
        <table>
            <table class="table table-striped table-bordered table-hover "  id="Orgdatatable"  style="width:100%;">
                     <thead>
                        <tr style="background: white !important">
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
                                        <th>Units</th>
                                        <th>Price</th>
                                        <th>Last Updated At</th>
                                        
                                        
                                    </tr>
                                </thead>
                                <tbody  style="background:white;">
                                </tbody>


                  
                </table>
        </table>
         

     </div>
  </div>
</div>
    

</div>
        </section>

    </main>

    


@endsection

@push('scripts')
     <script>
        
          
    var otable=   $('#Orgdatatable').DataTable({
        processing: true,
        serverSide: true,
         pageLength:10,
          columnDefs: [{
                            render: function (data, type, full, meta) {
                                return "<div id='dvNotes' style='white-space: normal;width: 250px;'>" + data + "</div>";
                            },
                            targets: 1
                        },

                        {
                            render: function (data, type, full, meta) {
                                return "<div id='dvNotes' style='white-space: normal;width: 130px;'>" + data + "</div>";
                            },
                            targets: 5
                        },

                         {
                            render: function (data, type, full, meta) {
                                return "<div id='dvNotes' style='white-space: normal;width: 50px;'>" + data + "</div>";
                            },
                            targets: 6
                        },

                         {
                            render: function (data, type, full, meta) {
                                return "<div id='dvNotes' style='white-space: normal;width: 190px;'>" + data + "</div>";
                            },
                            targets: 9
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

            
        });


        $(".mysearch").on( 'keyup change', function () {
               
                
                otable
                    .column( $(this).parent().index()+':visible' )
                    .search( this.value )
                    .draw();
                    
            } );
    </script>
    
@endpush