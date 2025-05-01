@extends("layouts.app")


@section('content')

<div class="row">
	  <select  id="JobDescription">
                           
					  	 <?php foreach($models as $model):?>
                         <option value="{{$model->id}}">{{$model->job_description}}</option>

					  	  <?php endforeach;?>


					  	
					  </select>
	<!--=== Page Content ===-->
				<!--=== Statboxes ===-->
				<div class="row row-bg"> <!-- .row-bg -->
					<div class="col-sm-6 col-md-3">
						<div class="statbox widget box box-shadow">
							<div class="widget-content">
								<div class="visual cyan">
									<div class="statbox-sparkline">30,20,15,30,22,25,26,30,27</div>
								</div>
								<div class="title">Job Adverts</div>
								<div class="value" id="TotalJobAdvert">-</div>
								<a class="more" href="{{url('/System/JobAdvert/Index')}}">View More <i class="pull-right icon-angle-right"></i></a>
							</div>
						</div> <!-- /.smallstat -->
					</div> <!-- /.col-md-3 -->

					<div class="col-sm-6 col-md-3">
						<div class="statbox widget box box-shadow">
							<div class="widget-content">
								<div class="visual green">
									<div class="statbox-sparkline">20,30,30,29,22,15,20,30,32</div>
								</div>
								<div class="title">Internal Users</div>
								<div class="value" id="TotalInternalUsers">-</div>
								<a class="more" href="{{url('/System/Users/Index')}}">View More <i class="pull-right icon-angle-right"></i></a>
							</div>
						</div> <!-- /.smallstat -->
					</div> <!-- /.col-md-3 -->

					<div class="col-sm-6 col-md-3 hidden-xs">
						<div class="statbox widget box box-shadow">
							<div class="widget-content">
								<div class="visual yellow">
									<i class="icon-dollar"></i>
								</div>
								<div class="title">Total Applicants</div>
								<div class="value" id="TotalApplicants">-</div>
								<a class="more" href="{{url('/System/Applicants/Index')}}">View More <i class="pull-right icon-angle-right"></i></a>
							</div>
						</div> <!-- /.smallstat -->
					</div> <!-- /.col-md-3 -->

					<div class="col-sm-6 col-md-3 hidden-xs">
						<div class="statbox widget box box-shadow">
							<div class="widget-content">
								<div class="visual red">
									<i class="icon-user"></i>
								</div>
								<div class="title">Total Applications</div>
								<div class="value" id="TotalJobApplications">-</div>
								<a class="more" href="System/JobApplications/Index">View More <i class="pull-right icon-angle-right"></i></a>
							</div>
						</div> <!-- /.smallstat -->
					</div> <!-- /.col-md-3 -->
				</div> <!-- /.row -->

				
					  
					

				<!-- /Statboxes -->
	
</div>


				

				<!--=== Blue Chart ===-->
				<div class="row">
					 <!-- /.col-md-12 -->
					<div class="col-md-6" style="margin-top:1%;">
							<div class="widget box">
							<div class="widget-header">
								<h4><i class="icon-reorder"></i>Analysis By Gender</h4>
								<div class="toolbar no-padding">
									<div class="btn-group">
										<span class="btn btn-xs widget-collapse"><i class="icon-angle-down"></i></span>
									</div>
								</div>
							</div>
							<div class="widget-content">
								
								<div id="MaleStat" style="height: 290px;">
							
						</div>
							</div>
						</div>
						
						
					</div>


					<div class="col-md-6" style="margin-top:1%;">
							<div class="widget box">
							<div class="widget-header">
								<h4><i class="icon-reorder"></i>Top Ten Ethnicity Applications</h4>
								<div class="toolbar no-padding">
									<div class="btn-group">
										<span class="btn btn-xs widget-collapse"><i class="icon-angle-down"></i></span>
									</div>
								</div>
							</div>
							<div class="widget-content">
								
								<div id="EthinicityStat" style="height: 290px;">
							
						</div>
							</div>
						</div>
						
						
					</div>


					<div class="col-md-6" style="margin-top:1%;">
							<div class="widget box">
							<div class="widget-header">
								<h4><i class="icon-reorder"></i>Analysis By Qualifications</h4>
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
					<div class="col-md-6" style="margin-top:1%;">
							<div class="widget box">
							<div class="widget-header">
								<h4><i class="icon-reorder"></i>Analysis By Home Counties</h4>
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
											<tr class="btn-info">
											<th>#</th>
											<th>County Name</th>
											<th>Number</th>
											</tr>
										</thead>
										<tbody id="CountyBody">
											
										</tbody>
										
									</table>
									
								</div>
							
						</div>
							</div>
						</div>
						
						
					</div>
				</div> <!-- /.row -->
				<!-- /Blue Chart -->

					<div class="row" style="margin-top:2%;">
					<!--=== Calendar ===-->
					

					<!--=== Feeds (with Tabs) ===-->
					<div class="col-md-12">
						<div class="widget">
							<div class="widget-header">
								<h4><i class="icon-reorder"></i> Feeds</h4>
								<div class="toolbar no-padding">
									<div class="btn-group">
										<span class="btn btn-xs widget-collapse"><i class="icon-angle-down"></i></span>
										<span class="btn btn-xs widget-refresh"><i class="icon-refresh"></i></span>
									</div>
								</div>
							</div>
							<div class="widget-content">
								<div class="tabbable tabbable-custom">
									<ul class="nav nav-tabs">
										<li class="active"><a href="#tab_feed_1" data-toggle="tab">System</a></li>
										<li><a href="#tab_feed_2" data-toggle="tab">Activities</a></li>
									</ul>
									<div class="tab-content">
										<div class="tab-pane active" id="tab_feed_1">
											<div class="scroller" data-height="290px" data-always-visible="1" data-rail-visible="0">
												<ul class="feeds clearfix">
													<li>
														<div class="col1">
															<div class="content">
																<div class="content-col1">
																	<div class="label label-success">
																		<i class="icon-bell"></i>
																	</div>
																</div>
																<div class="content-col2">
																	<div class="desc">You have 2 puzzles to solve.</div>
																</div>
															</div>
														</div> <!-- /.col1 -->
														<div class="col2">
															<div class="date">
																Just now
															</div>
														</div> <!-- /.col2 -->
													</li>
													<li>
														<div class="col1">
															<div class="content">
																<div class="content-col1">
																	<div class="label label-success"><i class="icon-plus"></i></div>
																</div>
																<div class="content-col2">
																	<div class="desc">New user registered.</div>
																</div>
															</div>
														</div> <!-- /.col1 -->
														<div class="col2">
															<div class="date">20 mins ago</div>
														</div> <!-- /.col2 -->
													</li>
													<li class="hoverable">
														<a href="javascript:void(0);">
															<div class="col1">
																<div class="content">
																	<div class="content-col1">
																		<div class="label label-info"><i class="icon-bullhorn"></i></div>
																	</div>
																	<div class="content-col2">
																		<div class="desc">New items are in queue.</div>
																	</div>
																</div>
															</div> <!-- /.col1 -->
															<div class="col2">
																<div class="date">25 mins ago</div>
															</div> <!-- /.col2 -->
														</a>
													</li>
													<li>
														<div class="col1">
															<div class="content">
																<div class="content-col1">
																	<div class="label label-danger"><i class="icon-warning-sign"></i></div>
																</div>
																<div class="content-col2">
																	<div class="desc">High CPU load on cluster #2. <span class="label label-danger label-mini">Fix it <i class="icon-share-alt"></i></span></div>
																</div>
															</div>
														</div> <!-- /.col1 -->
														<div class="col2">
															<div class="date">30 mins ago</div>
														</div> <!-- /.col2 -->
													</li>
													<li>
														<div class="col1">
															<div class="content">
																<div class="content-col1">
																	<div class="label label-warning"><i class="icon-bolt"></i></div>
																</div>
																<div class="content-col2">
																	<div class="desc">Disk space to 85% full.</div>
																</div>
															</div>
														</div> <!-- /.col1 -->
														<div class="col2">
															<div class="date">45 mins ago</div>
														</div> <!-- /.col2 -->
													</li>
													<li>
														<div class="col1">
															<div class="content">
																<div class="content-col1">
																	<div class="label label-success"><i class="icon-plus"></i></div>
																</div>
																<div class="content-col2">
																	<div class="desc">New user registered.</div>
																</div>
															</div>
														</div> <!-- /.col1 -->
														<div class="col2">
															<div class="date">1 hour ago</div>
														</div> <!-- /.col2 -->
													</li>
													<li>
														<div class="col1">
															<div class="content">
																<div class="content-col1">
																	<div class="label label-default"><i class="icon-time"></i></div>
																</div>
																<div class="content-col2">
																	<div class="desc">Time successfully synced.</div>
																</div>
															</div>
														</div> <!-- /.col1 -->
														<div class="col2">
															<div class="date">1.5 hours ago</div>
														</div> <!-- /.col2 -->
													</li>
													<li>
														<div class="col1">
															<div class="content">
																<div class="content-col1">
																	<div class="label label-info"><i class="icon-bullhorn"></i></div>
																</div>
																<div class="content-col2">
																	<div class="desc">Download finished.</div>
																</div>
															</div>
														</div> <!-- /.col1 -->
														<div class="col2">
															<div class="date">1.8 hours ago</div>
														</div> <!-- /.col2 -->
													</li>
													<li>
														<div class="col1">
															<div class="content">
																<div class="content-col1">
																	<div class="label label-success"><i class="icon-plus"></i></div>
																</div>
																<div class="content-col2">
																	<div class="desc">New order received.</div>
																</div>
															</div>
														</div> <!-- /.col1 -->
														<div class="col2">
															<div class="date">2 hours ago</div>
														</div> <!-- /.col2 -->
													</li>
													<li>
														<div class="col1">
															<div class="content">
																<div class="content-col1">
																	<div class="label label-info"><i class="icon-bullhorn"></i></div>
																</div>
																<div class="content-col2">
																	<div class="desc">Download finished.</div>
																</div>
															</div>
														</div> <!-- /.col1 -->
														<div class="col2">
															<div class="date">3 hours ago</div>
														</div> <!-- /.col2 -->
													</li>
													<li>
														<div class="col1">
															<div class="content">
																<div class="content-col1">
																	<div class="label label-success"><i class="icon-plus"></i></div>
																</div>
																<div class="content-col2">
																	<div class="desc">New order received.</div>
																</div>
															</div>
														</div> <!-- /.col1 -->
														<div class="col2">
															<div class="date">5 hours ago</div>
														</div> <!-- /.col2 -->
													</li>
													<li>
														<div class="col1">
															<div class="content">
																<div class="content-col1">
																	<div class="label label-info"><i class="icon-bullhorn"></i></div>
																</div>
																<div class="content-col2">
																	<div class="desc">Download finished.</div>
																</div>
															</div>
														</div> <!-- /.col1 -->
														<div class="col2">
															<div class="date">5.5 hours ago</div>
														</div> <!-- /.col2 -->
													</li>
													<li>
														<div class="col1">
															<div class="content">
																<div class="content-col1">
																	<div class="label label-success"><i class="icon-plus"></i></div>
																</div>
																<div class="content-col2">
																	<div class="desc">New order received.</div>
																</div>
															</div>
														</div> <!-- /.col1 -->
														<div class="col2">
															<div class="date">7 hours ago</div>
														</div> <!-- /.col2 -->
													</li>
													<li>
														<div class="col1">
															<div class="content">
																<div class="content-col1">
																	<div class="label label-info"><i class="icon-bullhorn"></i></div>
																</div>
																<div class="content-col2">
																	<div class="desc">Download finished.</div>
																</div>
															</div>
														</div> <!-- /.col1 -->
														<div class="col2">
															<div class="date">16 hours ago</div>
														</div> <!-- /.col2 -->
													</li>
													<li>
														<div class="col1">
															<div class="content">
																<div class="content-col1">
																	<div class="label label-success"><i class="icon-plus"></i></div>
																</div>
																<div class="content-col2">
																	<div class="desc">New order received.</div>
																</div>
															</div>
														</div> <!-- /.col1 -->
														<div class="col2">
															<div class="date">20 hours ago</div>
														</div> <!-- /.col2 -->
													</li>
												</ul> <!-- /.feeds -->
											</div> <!-- /.scroller -->
										</div> <!-- /#tab_feed_1 -->

										<div class="tab-pane" id="tab_feed_2">
											<div class="scroller" data-height="290px" data-always-visible="1" data-rail-visible="0">
												<ul class="feeds clearfix">
													<li>
														<div class="col1">
															<div class="content">
																<div class="content-col1">
																	<div class="label label-success"><i class="icon-plus"></i></div>
																</div>
																<div class="content-col2">
																	<div class="desc">New user registered.</div>
																</div>
															</div>
														</div> <!-- /.col1 -->
														<div class="col2">
															<div class="date">1 min ago</div>
														</div> <!-- /.col2 -->
													</li>
													<li>
														<div class="col1">
															<div class="content">
																<div class="content-col1">
																	<div class="label label-success"><i class="icon-plus"></i></div>
																</div>
																<div class="content-col2">
																	<div class="desc">New user registered.</div>
																</div>
															</div>
														</div> <!-- /.col1 -->
														<div class="col2">
															<div class="date">5 mins ago</div>
														</div> <!-- /.col2 -->
													</li>
													<li>
														<div class="col1">
															<div class="content">
																<div class="content-col1">
																	<div class="label label-info"><i class="icon-plus"></i></div>
																</div>
																<div class="content-col2">
																	<div class="desc">New order received.</div>
																</div>
															</div>
														</div> <!-- /.col1 -->
														<div class="col2">
															<div class="date">10 mins ago</div>
														</div> <!-- /.col2 -->
													</li>
													<li>
														<div class="col1">
															<div class="content">
																<div class="content-col1">
																	<div class="label label-success"><i class="icon-plus"></i></div>
																</div>
																<div class="content-col2">
																	<div class="desc">New user registered.</div>
																</div>
															</div>
														</div> <!-- /.col1 -->
														<div class="col2">
															<div class="date">20 mins ago</div>
														</div> <!-- /.col2 -->
													</li>
													<li>
														<div class="col1">
															<div class="content">
																<div class="content-col1">
																	<div class="label label-info"><i class="icon-plus"></i></div>
																</div>
																<div class="content-col2">
																	<div class="desc">New order received.</div>
																</div>
															</div>
														</div> <!-- /.col1 -->
														<div class="col2">
															<div class="date">30 mins ago</div>
														</div> <!-- /.col2 -->
													</li>
													<li>
														<div class="col1">
															<div class="content">
																<div class="content-col1">
																	<div class="label label-success"><i class="icon-plus"></i></div>
																</div>
																<div class="content-col2">
																	<div class="desc">New user registered.</div>
																</div>
															</div>
														</div> <!-- /.col1 -->
														<div class="col2">
															<div class="date">40 mins ago</div>
														</div> <!-- /.col2 -->
													</li>
													<li>
														<div class="col1">
															<div class="content">
																<div class="content-col1">
																	<div class="label label-info"><i class="icon-plus"></i></div>
																</div>
																<div class="content-col2">
																	<div class="desc">New order received.</div>
																</div>
															</div>
														</div> <!-- /.col1 -->
														<div class="col2">
															<div class="date">50 mins ago</div>
														</div> <!-- /.col2 -->
													</li>
													<li>
														<div class="col1">
															<div class="content">
																<div class="content-col1">
																	<div class="label label-success"><i class="icon-plus"></i></div>
																</div>
																<div class="content-col2">
																	<div class="desc">New user registered.</div>
																</div>
															</div>
														</div> <!-- /.col1 -->
														<div class="col2">
															<div class="date">1 hour ago</div>
														</div> <!-- /.col2 -->
													</li>
													<li>
														<div class="col1">
															<div class="content">
																<div class="content-col1">
																	<div class="label label-info"><i class="icon-plus"></i></div>
																</div>
																<div class="content-col2">
																	<div class="desc">New order received.</div>
																</div>
															</div>
														</div> <!-- /.col1 -->
														<div class="col2">
															<div class="date">1.5 hours ago</div>
														</div> <!-- /.col2 -->
													</li>
												</ul> <!-- /.feeds -->
											</div> <!-- /.scroller -->
										</div> <!-- /#tab_feed_1 -->
									</div> <!-- /.tab-content -->
								</div> <!-- /.tabbable tabbable-custom-->
							</div> <!-- /.widget-content -->
						</div> <!-- /.widget .box -->
					</div> <!-- /.col-md-6 -->
					<!-- /Feeds (with Tabs) -->
				</div> <!-- /.row -->

@endsection
@push('scripts')
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
<script type="text/javascript">

	var url="<?=url('/System/Dashboard/MainData')?>";
	  $.get(url,function(data){
	  	$("#TotalJobAdvert").html(data.Adverts);
	  	$("#TotalInternalUsers").html(data.UserCount);
	  	$("#TotalApplicants").html(data.ApplicantCount);
	  	$("#TotalJobApplications").html(data.JobApplicantions);


	  })






   drawGenderGraph();
	 function drawGenderGraph()
	 {
	 	var id= $("#JobDescription").val();
	 	  var url="<?=url('/System/JobAdvert/GetGenderStats')?>/"+id;
	 	   $.get(url,function(data){
	 	   	data=JSON.parse(data);

	 	   		Highcharts.chart('MaleStat', {
    chart: {
        plotBackgroundColor: null,
        plotBorderWidth: 1,
        plotShadow: false,
        type: 'pie'
    },
    title: {
        text: 'Post Application By Gender'
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
	  $("body").on("change","#JobDescription",function(e){
	  	e.preventDefault();
	  	 drawGenderGraph();
	  	 drawEthinicityGraph();
	  	 drawCountyTable();
	  	 drawQualification();

	  });
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
	 	var id= $("#JobDescription").val();
	 	  var url="<?=url('/System/JobAdvert/GetTribeStats')?>/"+id;
	 	   $.get(url,function(data){
	 	   	data=JSON.parse(data);
           
            Highcharts.chart('EthinicityStat', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Application By Tribes Analysis'
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
        pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}%</b> of total<br/>'
    },

    series: [
        {
            name: "Tribe",
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
	
</script>
<script type="text/javascript">
	
	drawQualification();
	  function drawQualification()
	  {
	  	 Highcharts.chart('Qualification', {
    chart: {
        type: 'bar'
    },
    title: {
        text: 'Application By Education Level'
    },
    subtitle: {
        text: 'Source: <?=config("app.name")?>'
    },
    xAxis: {
        categories: ['Degree', 'Diploma', 'Certificate', 'KCSE', 'KCPE'],
        title: {
            text: null
        }
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Population (millions)',
            align: 'high'
        },
        labels: {
            overflow: 'justify'
        }
    },
    tooltip: {
        valueSuffix: ' millions'
    },
    plotOptions: {
        bar: {
            dataLabels: {
                enabled: true
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
        name: 'Year 1800',
        data: [107, 31, 635, 203, 2]
    },]
});

	  }

</script>


@endpush