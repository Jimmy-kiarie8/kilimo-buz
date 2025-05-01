<div class="col-md-12">

	<form  action="{{$url}}" method="post">
		  <?=csrf_field()?>
		  <div class="col-md-12 form-group">
		  	<label>Member Name</label>
		  	<input type="text" name="member_name" class="form-control" value="{{$model->member_name}}" required>
		  	
		  </div>

		   <div class="col-md-12 form-group">
		  	<label>Member Id Number</label>
		  	<input type="text" name="id_number" class="form-control" value="{{$model->id_number}}" required>
		  	
		  </div>


		   <div class="col-md-12 form-group">
		  	<label>Member Telephone</label>
		  	<input type="text" name="member_telephone" class="form-control" value="{{$model->member_telephone}}" required>
		  	
		  </div>
		  
		  <div class="col-md-12 form-group">
		  	<button class="btn btn-sm btn-success">Complete</button>
		  </div>
		
	</form>
	
</div>