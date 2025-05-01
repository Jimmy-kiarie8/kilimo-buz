<div class="row">
	<form action="{{$url}}" method="post">
		 <?=csrf_field()?>
		 <div class="col-md-12 form-group">
		 	<label>Ministry Name</label>
		 	<input type="text" name="ministry_name" class="form-control" value="{{$model->ministry_name}}"  required>
		 	
		 </div>

		  <div class="col-md-12 form-group">
		   <button class="btn btn-primary"><?=($model->exists) ?"Update":"Create"?></button>
		 	
		 </div>
		

	</form>
	

</div>