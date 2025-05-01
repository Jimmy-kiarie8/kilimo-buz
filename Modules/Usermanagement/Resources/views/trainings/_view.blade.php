<div class="row">
	<div class="col-md-4">
		<h5 style="font-weight: bold;color:maroon">Passport Photo</h5>
		<img src="{{asset('k.png')}}" width="130" height="160">
		
	</div>

	<div class="col-md-8">
		<div class="table-responsive"  style="overflow-x:auto;">
			<table class="table table-bordered table-striped">
			<tr>
				<th>Training Name</th>
				<td>{{$training->training_name}}</td>
			</tr>
			<tr>
				<th>Training Date</th>
				<td>{{$training->training_date}}</td>
			</tr>
			<tr>
				<th>Name</th>
				<td>{{$model->fullnames}}</td>
			</tr>
			<tr>
				<th>ID Number</th>
				<td>{{$model->id_number}}</td>
			</tr>
			<tr>
				<th>Gender</th>
				<td>{{$model->gender}}</td>
			</tr>
			<tr>
				<th>Telephone</th>
				<td>{{$model->telephone}}</td>
			</tr>
			<tr>
				<th>Email</th>
				<td>{{$model->email_address}}</td>
			</tr>

			<tr>
				<th>Station</th>
				<td>{{$model->station_location}}</td>
			</tr>

			<tr>
				<th>Category</th>
				<td>{{$training->category}}</td>
			</tr>
			
		</table>
			
		</div>
		
		
	</div>
	
</div>