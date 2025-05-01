@extends("layouts.app")


@section('content')

<div>
		<div class="row row-bg"> <!-- .row-bg -->
					<div class="col-sm-6 col-md-3">
						<div class="statbox widget box box-shadow">
							<div class="widget-content">
								<div class="visual cyan">
									<div class="statbox-sparkline">30,20,15,30,22,25,26,30,27</div>
								</div>
								<div class="title">Value Chains</div>
								<div class="value" id="TotalJobAdvert">-</div>
								<a class="more" href="{{url('/System/ValueChain/Index')}}">View More <i class="pull-right icon-angle-right"></i></a>
							</div>
						</div> <!-- /.smallstat -->
					</div> <!-- /.col-md-3 -->

					<div class="col-sm-6 col-md-3">
						<div class="statbox widget box box-shadow">
							<div class="widget-content">
								<div class="visual green">
									<div class="statbox-sparkline">20,30,30,29,22,15,20,30,32</div>
								</div>
								<div class="title">Total VCOs</div>
								<div class="value" id="TotalInternalUsers">-</div>
								<a class="more" href="{{url('/System/Entities/Index')}}">View More <i class="pull-right icon-angle-right"></i></a>
							</div>
						</div> <!-- /.smallstat -->
					</div> <!-- /.col-md-3 -->

					<div class="col-sm-6 col-md-3 hidden-xs">
						<div class="statbox widget box box-shadow">
							<div class="widget-content">
								<div class="visual yellow">
									<i class="icon-dollar"></i>
								</div>
								<div class="title">Total VCOs Members</div>
								<div class="value" id="TotalApplicants">-</div>
								<a class="more" href="{{url('/System/VCOMembers/Index')}}">View More <i class="pull-right icon-angle-right"></i></a>
							</div>
						</div> <!-- /.smallstat -->
					</div> <!-- /.col-md-3 -->

					<div class="col-sm-6 col-md-3 hidden-xs">
						<div class="statbox widget box box-shadow">
							<div class="widget-content">
								<div class="visual red">
									<i class="icon-user"></i>
								</div>
								<div class="title">Prioritised value chains</div>
								<div class="value" id="Prioritized">143</div>
								<a class="more" href="#">View More <i class="pull-right icon-angle-right"></i></a>
							</div>
						</div> <!-- /.smallstat -->
					</div> <!-- /.col-md-3 -->
				</div> <!-- /.row -->

	

</div>


<div class="row">
					 <!-- /.col-md-12 -->
					<div class="col-md-6" style="margin-top:1%;">
							<div class="widget box">
							<div class="widget-header">
								<h4><i class="icon-reorder"></i>Value chains By Nodes</h4>
								<div class="toolbar no-padding">
									<div class="btn-group">
										<span class="btn btn-xs widget-collapse"><i class="icon-angle-down"></i></span>
									</div>
								</div>
							</div>
							<div class="widget-content">
								
								<div id="MaleStat" style="height: 350px;">
							
						</div>
							</div>
						</div>
						
						
					</div>


					<div class="col-md-6" style="margin-top:1%;">
							<div class="widget box">
							<div class="widget-header">
								<h4><i class="icon-reorder"></i>Top 10 Value Chains</h4>
								<div class="toolbar no-padding">
									<div class="btn-group">
										<span class="btn btn-xs widget-collapse"><i class="icon-angle-down"></i></span>
									</div>
								</div>
							</div>
							<div class="widget-content">
								
								<div class="table-responsive">
									<table class="table table-bordered">
										<thead>
											<tr class="bg-success">
												<th>Value Chain</th>
												<th>Qty Available</th>
												<th>Estimate Value</th>
											</tr>
										</thead>
										<tbody id="TableBodyYangu">
											
										</tbody>
										
									</table>
									
								</div>
							
						</div>
							</div>
						</div>
						
						
					</div>

					<div class="row">
						<div class="col-md-3">
							<select id="CountyId" class="form-control">
								  <?php foreach($models as $model):?>
								  	<option <?php if($model->id==44):?>selected <?php endif;?> value="{{$model->id}}">{{$model->county_name}}</option>

								  <?php endforeach;?>
								
							</select>
							
						</div>

						<div class="col-md-3 pull-right">
							<select id="ValueChain" class="form-control" >

								 <option value="5">---Select Value chain--</option>

								
							</select>
							
						</div>





					</div>



















































<div class="row">
	


					<div class="col-md-6" style="margin-top:1%;">
							<div class="widget box">
							<div class="widget-header">
								<h4><i class="icon-reorder"></i>Value Chain Quantities</h4>
								<div class="toolbar no-padding">
									<div class="btn-group">
										<span class="btn btn-xs widget-collapse"><i class="icon-angle-down"></i></span>
									</div>
								</div>
							</div>
							<div class="widget-content">
								
								<div id="Qualification" style="height: 300px;">
							
						</div>
							</div>
						</div>
						
						
					</div>
					<div class="col-md-6 " style="margin-top:1%;">
							<div class="widget box">
							<div class="widget-header">
								<h4><i class="icon-reorder"></i>Number Of Members</h4>
								<div class="toolbar no-padding">
									<div class="btn-group">
										<span class="btn btn-xs widget-collapse"><i class="icon-angle-down"></i></span>
									</div>
								</div>
							</div>
							<div class="widget-content">
								
								<div id="MeberNo" style="height: 300px;">
						</div>
							</div>
						</div>
						</div>
						
			




@endsection
@push('scripts')
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
<script type="text/javascript">
	 $("#CountyId").on("change",function(e){
	 	e.preventDefault();
	 	  var id=$(this).val();
             if(id.length>0)
             {
               var url="<?=url('/System/Entities/GetValueChains')?>/"+id;
                 $.get(url,function(data){
                  $("#ValueChain").html(data);
                 });
             }

	 })
</script>
<script type="text/javascript">

	var url="<?=url('/System/Dashboard/MainData')?>";
	  $.get(url,function(data){
	  	$("#TotalJobAdvert").html(data.Adverts);
	  	$("#TotalInternalUsers").html(data.UserCount);
	  	$("#TotalApplicants").html(data.ApplicantCount);
	  	$("#TotalJobApplications").html(data.JobApplicantions);


	  });






   drawGenderGraph();
	 function drawGenderGraph()
	 {
	 	
	 	  var url="<?=url('/System/Node/GetGenStats')?>";
	 	   $.get(url,function(data){
	 	   	//data=JSON.parse(data);

	 	   		Highcharts.chart('MaleStat', {
    chart: {
        plotBackgroundColor: null,
        plotBorderWidth: 1,
        plotShadow: false,
        type: 'pie'
    },
    title: {
        text: 'No of VCOs'
    },
   
   
    plotOptions: {
        pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            dataLabels: {
                enabled: true,
                format: '<b>{point.name}</b>: {point.y}'
            }
        }
    },
    series: [{
        name: 'Number',
        colorByPoint: true,
        data: data
    }]
});


	 	   })
	 

	 }
	
</script>

<script type="text/javascript">
	 drawCountyTable();

	   function drawCountyTable()
	   {
	   	var id= $("#JobDescription").val();
	 	  var url="<?=url('/System/JobAdvert/GetCountyStats')?>/"+id;
	 	   $.get(url,function(data){
             $("#CountyBody").html(data);
	 	   });

	   }
	
</script>

<script type="text/javascript">
   drawEthinicityGraph();
	 function drawEthinicityGraph()
	 {
	    var url="<?=url('/System/Dashboard/getToptenProductByValue')?>";
	        $.get(url,function(data){
            $("#TableBodyYangu").html(data);
	        });
	 

	 }
	
</script>
<script type="text/javascript">
	
	$("#ValueChain").on("change",function(e){
		e.preventDefault();
		 drawQualification();
		 drawMembership();

	});

	 function drawMembership()
	 {
	 	 	var CountyId= $("#CountyId").val();
	  	var ValueChain=$("#ValueChain").val();
	  	 

	 	 var url="<?=url('/System/Dashboard/GetMonthStats')?>";
	 	   $.get(url,{'CountyID':CountyId,'ValueChain':ValueChain},function(data){
	 	   
           
            Highcharts.chart('MeberNo', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Registered Members'
    },
    
    accessibility: {
        announceNewData: {
            enabled: true
        }
    },
    xAxis: {
        type: 'category'
    },
    yAxis: {
        title: {
            text: 'Total Number'
        }

    },
    legend: {
        enabled: false
    },
    plotOptions: {
        series: {
            borderWidth: 0,
            dataLabels: {
                enabled: true,
                format: '{point.y}'
            }
        }
    },

    tooltip: {
        headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
        pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y}</b><br/>'
    },

    series: [
        {
            name: "Sub County",
            colorByPoint: true,
            data: data
        }
    ],
    drilldown: {
        series: [
           
            
        ]
    }
});


	 	   })
	 }
	
	  function drawQualification()
	  {
	  	var CountyId= $("#CountyId").val();
	  	var ValueChain=$("#ValueChain").val();

	  	  var url="<?=url('/System/Dashboard/CountValueQty')?>";
	  	   $.get(url,{'CountyID':CountyId,'ValueChain':ValueChain},function(data){

	  	   	Highcharts.chart('Qualification', {
    chart: {
        type: 'bar'
    },
    title: {
        text: 'Analysis At Sub County Level'
    },
    subtitle: {
        text: 'Source: <?=config("app.name")?>'
    },
    xAxis: {
        categories: data.categories,
        title: {
            text: null
        }
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Units',
            align: 'high'
        },
        labels: {
            overflow: 'justify'
        }
    },
   
    plotOptions: {
        bar: {
            dataLabels: {
                enabled: false
            }
        }
    },
    legend: {
        layout: 'vertical',
        align: 'right',
        verticalAlign: 'top',
        x: -40,
        y: 80,
        floating: true,
        borderWidth: 1,
        backgroundColor:
            Highcharts.defaultOptions.legend.backgroundColor || '#FFFFFF',
        shadow: true
    },
    credits: {
        enabled: false
    },
    series: [{
        name: 'Qty',
        data: data.dataset
    },]
});

	  	   });
	  	 

	  }

</script>


@endpush