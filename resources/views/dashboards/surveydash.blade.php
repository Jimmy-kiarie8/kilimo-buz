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
								<div class="title">Total Responses</div>
								<div class="value">173</div>
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
								<div class="title">Male Responses</div>
								<div class="value" >0</div>
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
								<div class="title">Female Responses</div>
								<div class="value" >173</div>
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
								<div class="title">Number Of BMU</div>
								<div class="value" >14</div>
								<a class="more" href="{{url('/System/ValueChain/CountyIndex')}}">View More <i class="pull-right icon-angle-right"></i></a>
							</div>
						</div> <!-- /.smallstat -->
					</div> <!-- /.col-md-3 -->
				</div> <!-- /.row -->

	

</div>




				<div class="row">

               <div class="col-md-12" style="margin-top:1%;"  class="form-group">
                  <label>Select Indicator Description To Analyse</label>
                  <select name="question" class="form-control" id="Question">
                     <option value="Sourceoffish">Source Of Fish</option>
                     <option value="Equipmentforhandlingfish">Equipment for Handling Fish</option>
                     <option value="Averagevolumeshandledperday">Average volumes handled per day</option>
                     <option value="Statewhichfishissold"> State which fish is sold </option>

                     <option value="Sourcetypeoffuelused">Source Type Of fuel used </option>
                     <option value="experiencestockloss">Experience Stock Loss</option>

                      <option value="Typelosses">Experience Loss Type Description</option>

                      <option value="MarketTransportEquipment">Market Transport Equipment</option>

                      <option value="Businesshours">Business Operation Hours</option>


                      <option value="IsLateBusiness">Source of Lighting Fo Evening Business</option>
                     
                  </select>

               </div>
	


					<div class="col-md-6" style="margin-top:1%;">
							<div class="widget box">
							<div class="widget-header">
								<h4><i class="icon-reorder"></i>General Indicator Performance</h4>
								<div class="toolbar no-padding">
									<div class="btn-group">
										<span class="btn btn-xs widget-collapse"><i class="icon-angle-down"></i></span>
									</div>
								</div>
							</div>
							<div class="widget-content">
								
								<div id="Qualification" style="height: 350px;">
							
						</div>
							</div>
						</div>
						
						
					</div>
					<div class="col-md-6 " style="margin-top:1%;">
							<div class="widget box">
							<div class="widget-header">
								<h4><i class="icon-reorder"></i>Resuits By Sub Counties</h4>
								<div class="toolbar no-padding">
									<div class="btn-group">
										<span class="btn btn-xs widget-collapse"><i class="icon-angle-down"></i></span>
									</div>
								</div>
							</div>
							<div class="widget-content">
								
								<div id="MeberNo" style="height: 350px;">
						</div>
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
<link href="{{ asset('/map.css') }}" rel="stylesheet" />
<script src="{{ asset('/map.js')}}" type="text/javascript"></script>
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

   drawQualification();

    drawMembership();

	 function drawMembership()
	 {
	  	 
      var question=$("#Question").val();

	 	 var url="<?=url('/System/Dashboard/GetSubCountyB')?>";
	 	   $.get(url,{'Param':question},function(data){
	 	   
           
           Highcharts.chart('MeberNo', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Number of Responses'
    },
    subtitle: {
        text: 'Source: Mombasa County BMU Survey'
    },
    xAxis: {
        categories: [
            'Likoni',
            'Jomvu',
            'Kisauni',
            'Nyali',
            'Mvita',
            
        ],
        crosshair: true
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Number'
        }
    },
    tooltip: {
        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
            '<td style="padding:0"><b>{point.y}</b></td></tr>',
        footerFormat: '</table>',
        shared: true,
        useHTML: true
    },
    plotOptions: {
        column: {
            pointPadding: 0.2,
            borderWidth: 0
        }
    },
    series: data
});


	 	   })
	 }

      $("#Question").on("change",function(e){
         e.preventDefault();
          drawQualification();
          drawMembership();

      });
	
	  function drawQualification()
	  {
	  	
       
      var question=$("#Question").val();


	  	  var url="<?=url('/System/Dashboard/GetSurvey')?>";

	  	   $.get(url,{'Param':question},function(data){

	  	   	  Highcharts.chart('Qualification', {
    chart: {
        plotBackgroundColor: null,
        plotBorderWidth: 1,
        plotShadow: false,
        type: 'pie'
    },
    title: {
        text: 'Grouped Count Stats'
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

	  	   });
	  	 

	  }

</script>






@endpush