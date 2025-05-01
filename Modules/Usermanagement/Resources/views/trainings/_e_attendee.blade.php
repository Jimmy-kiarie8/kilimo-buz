<div class="col-md-12">
	<form action="{{$url}}" method="post">
		 <?=csrf_field()?>
		 <div class="row">
		 	<div class="col-md-6 form-group">
		 		<label>Fullnames</label>
		 		<input type="text" name="fullnames" class="form-control" required value="{{$model->fullnames}}">

		 	</div>

		 	<div class="col-md-6 form-group">
		 		<label>Telephone</label>
		 		<input type="text" value="{{$model->telephone}}" name="telephone" class="form-control" required>

		 	</div>

		 	<div class="col-md-6 form-group">
		 		<label>Email Address (Optional)</label>
		 		<input type="text" name="email_address" value="{{$model->email_address}}" class="form-control" >

		 	</div>
		 	<div class="col-md-6 form-group">
		 		<label>Gender</label>
		 		<select name="gender" class="form-control" required>
		 			 <option value="">--Select one---</option>

		 			<option  <?php if($model->gender=="Male"):?>selected <?php endif;?>>Male</option>
		 			<option  <?php if($model->gender=="Female"):?>selected <?php endif;?>  >Female</option>
		 			
		 		</select>

		 	</div>

		 	<div class="col-md-6 form-group">
		 		<label>Id/Birth Cert Number</label>
		 		<input type="text" name="id_number" required class="form-control"  value="{{$model->id_number}}">

		 	</div>
		 	<div class="col-md-6 form-group">
		 		<label>Age Group</label>
		 		<select name="age_bracket" class="form-control" required>
                  <option value="">---Select Age Set---</option>
		 			<option <?php if($model->age_bracket=="Below 36 Years"):?>selected <?php endif;?>>Below 36 Years</option>
		 			<option <?php if($model->age_bracket=="36-60 Years"):?>selected <?php endif;?> >36-60 Years</option>
		 			<option  <?php if($model->age_bracket=="Above 60 Years"):?>selected <?php endif;?> >Above 60 Years</option>
		 			
		 		</select>

		 	</div>

		 	<div class="col-md-6 form-group">
		 		<label>Station/Location</label>
		 		<input type="text" name="station_location" required class="form-control" value="{{$model->station_location}}" >

		 	</div>


		 	
		 </div>
		 <div class="row">
		 	<div class="col-md-12 form-group">

		 			<button class="btn btn-success">Update</button>


		 		</div>
		 	
		 </div>
		 
		

	</form>
	
</div>