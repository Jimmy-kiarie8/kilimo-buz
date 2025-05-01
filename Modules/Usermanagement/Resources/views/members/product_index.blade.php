@extends("layouts.app")


@section('content')



        <!--=== Blue Chart ===-->
         

        <div class="row">
          <div class="col-md-12">
            <div class="widget box">
              <div class="widget-header">
                <h4><i class="icon-reorder"></i> List Of Posted Products</h4>
                <div class="toolbar no-padding">
                  <div class="btn-group">
                    <span class="btn btn-xs widget-collapse"><i class="icon-angle-down"></i></span>
                  </div>
                </div>
              </div>
              <div class="widget-content"> 

                <div class="row">

                  <div class="form-group col-md-3">
                      <label>County Name</label>
                      

                      {{ Form::select('org_id',([null=>'--Select County Name--'] + $counties), null, ['class'=>'form-controls','required'=>'required','id'=>'countyName','style'=>'width:100%']) }}
                    </div>
                    <div class="form-group col-md-3">
                      <label>VCO Name</label>
                      

                      {{ Form::select('county_id',([null=>'--Select VCO Name--'] + array()), null, ['class'=>'form-controls','required'=>'required','id'=>'VCOName','style'=>'width:100%']) }}
                    </div>
                    <div class="form-group col-md-3">
                      <label>Action</label><br>
                      <button class="btn btn-sm btn-success">Filter</button>
                      

                     
                    </div>
                  

                </div>

                  <div class="row">
                    <div class="col-md-12">
                      
                   

                     <div class="table-responsive"  style="overflow-x:auto;">
                   
                   <table class="table table-striped table-bordered table-hover "  id="ProductTable"  style="width:100%;">
                     <thead>
                                    <tr class="btn-success">
                                       
                                        <th>Action</th>
                                        <th>County Name</th>
                                        <th>Value Chain</th>
                                        <th>Product Details</th>
                                        <th>Quantity</th>
                                        <th>UOM</th>
                                        <th>Unit Price</th>
                                        <th>Number</th>
                                        <th>Member Name</th>
                                        <th>Telephone</th>
                                        <th>VCO Group Name</th>
                                      
                                        <th>Posted At</th>
                                      
                                        
                                       
                                       
                                        
                                       
                                       
                                        
                                        
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
        </div>
      



    


@stop
@push('scripts')
     <script>
        $("#countyName,#VCOName").select2();

        $("#countyName").on("change",function(e){
          e.preventDefault();
             var value=$(this).val();
               var url="<?=url('/System/VCOMembers/GetCountyList')?>/"+value;
                 $.get(url,function(data){
                   $("#VCOName").html(data);

                 });

        });
        
       
    </script>
    <script type="text/javascript">

      $('#ProductTable').DataTable({
        processing: true,
        serverSide: true,
         pageLength:10,
        "order": [[ 11, "desc" ]],
           ajax: '<?=url("System/MemberProducts/fetchAdminList")?>',
          columns: [
            {data: 'action', name: 'action',searchable:false,orderable:false},
             {data: 'county_name', name: 'county_name'},
            {data: 'value_name', name: 'value_name'},
            {data: 'variety', name: 'variety'},
            {data: 'quantity_available', name: 'quantity_available'},
            {data: 'uom', name: 'uom'},
            {data: 'unit_price', name: 'unit_price'},
            {data: 'member_number', name: 'member_number'},
            {data: 'member_name', name: 'member_name'},
            {data: 'member_telephone', name: 'member_telephone'},
            {data: 'org_name', name: 'org_name'},
            {data: 'created_at', name: 'created_at'},
            ],

            dom: 'Bfrtip',

        buttons: [
            { 
      extend: 'excelHtml5',
      className:'btn btn-sm btn-danger',
      exportOptions: {
               columns: [1,2,3,4,5,6,7,8,9,10,11]
                
            },
      text: '<span>Excel</span>',
      
       },

          { 
      extend: 'csvHtml5',
       className:'btn btn-sm btn-success',
      text: '<span>CSV</span>',
      exportOptions: {
               columns: [1,2,3,4,5,6,7,8,9,10,11]
                
            },
     
      
       },
        
        {extend: 'print',
         className:'btn btn-sm btn-info',
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