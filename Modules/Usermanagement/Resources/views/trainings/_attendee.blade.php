<div class="col-md-12">
	<form action="{{$url}}" method="post">
		 <?=csrf_field()?>
		 <div class="row">
		 	<div class="col-md-6 form-group">
		 		<label>Fullnames</label>
		 		<input type="text" name="fullnames" class="form-control" required>

		 	</div>

		 	<div class="col-md-6 form-group">
		 		<label>Telephone</label>
		 		<input type="text" name="telephone" class="form-control" required>

		 	</div>

		 	<div class="col-md-6 form-group">
		 		<label>Email Address (Optional)</label>
		 		<input type="text" name="email_address" class="form-control" >

		 	</div>
		 	<div class="col-md-6 form-group">
		 		<label>Gender</label>
		 		<select name="gender" class="form-control" required>

		 			<option>Male</option>
		 			<option>Female</option>
		 			
		 		</select>

		 	</div>

		 	<div class="col-md-6 form-group">
		 		<label>Id/Birth Cert Number</label>
		 		<input type="text" name="id_number" required class="form-control" >

		 	</div>
		 	<div class="col-md-6 form-group">
		 		<label>Age Group</label>
		 		<select name="age_bracket" class="form-control" required>

		 			<option>Below 36 Years</option>
		 			<option>36-60 Years</option>
		 			<option>Above 60 Years</option>
		 			
		 		</select>

		 	</div>

		 	<div class="col-md-6 form-group">
		 		<label>Station/Location</label>
		 		<input type="text" name="station_location" required class="form-control" >

		 	</div>


		 	
		 </div>
		 <div class="row">
		 	<div class="col-md-12 form-group">

		 			<button class="btn btn-success">Create</button>


		 		</div>
		 	
		 </div>
		 
		

	</form>
	
</div>