<div class="row">
	<form action="{{$url}}" method="post">
		 <?=csrf_field()?>
		 <div class="col-md-12 form-group">
		 	<label>Religion  Name</label>
		 	<input type="text" name="religion_name" class="form-control" value="{{$model->religion_name}}"  required>
		 	
		 </div>

		  <div class="col-md-12 form-group">
		   <button class="btn btn-primary"><?=($model->exists) ?"Update":"Create"?></button>
		 	
		 </div>
		

	</form>
	

</div>