@extends("layouts.app")


@section('content')



        <!--=== Blue Chart ===-->
          


        <div class="row">
          <div class="col-md-12">
            <div class="widget box">
              <div class="widget-header">
                <h4><i class="icon-reorder"></i>Number of Registered VCA By  Counties</h4>
                <div class="toolbar no-padding">
                  <div class="btn-group">
                    <span class="btn btn-xs widget-collapse"><i class="icon-angle-down"></i></span>
                  </div>
                </div>
              </div>
              <div class="widget-content"> 
              
                   <div class="table-responsive"  style="overflow-x:auto;">
                   
                   <table class="table table-striped table-bordered table-hover "  id="Orgdatatable"  style="width:100%;">
                     <thead>
                                    <tr class="btn-success">
                                        <th>County Name</th>
                                        <th>Male</th>
                                        <th>Female</th>
                                        <th>Number</th>
                                       
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
        
          
       $('#Orgdatatable').DataTable({
        processing: true,
        serverSide: true,
         pageLength:50,
        "order": [[ 1, "desc" ]],
           ajax: '<?=url("System/Reports/CountyVCAS")?>',
          columns: [
            {data: 'county_name', name: 'county_name'},
            {data: 'male', name: 'male'},

             {data: 'female', name: 'female'},

            {data: 'number', name: 'number'},
            
            ],

            dom: 'Bfrtip',

        buttons: [
            { 
      extend: 'excelHtml5',
      className:'btn-danger',
      exportOptions: {
               columns: [0,1,2,3]
                
            },
      text: '<span>Excel</span>',
      
       },

          { 
      extend: 'csvHtml5',
       className:'btn-success',
      text: '<span>CSV</span>',
      exportOptions: {
               columns: [0,1]
                
            },
     
      
       },
        
        {extend: 'print',
         className:'btn-info',
        exportOptions: {
            columns: [0,1]
                
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