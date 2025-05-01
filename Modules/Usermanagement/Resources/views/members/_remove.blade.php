<div class="col-md-12">

	<form  action="{{$url}}" method="post">
		  <?=csrf_field()?>
		  <div class="col-md-12 form-group">
		  	<label>Member Name</label>
		  	<input type="text" name="name" class="form-control" value="{{$model->member_name}}" readonly>
		  	
		  </div>
		  <div class="col-md-12 form-group">
		  	<label>Give Reason</label>
		   <textarea name="reason" class="form-control" required></textarea>
		  	
		  </div>
		  <div class="col-md-12 form-group">
		  	<button class="btn btn-danger">Complete</button>
		  </div>
		
	</form>
	
</div>