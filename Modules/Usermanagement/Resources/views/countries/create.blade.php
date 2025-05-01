<div class="row">
	<form action="{{$url}}" method="post">
		 <?=csrf_field()?>
		 <div class="col-md-12 form-group">
		 	<label>Country Code</label>
		 	<input type="text" name="code" class="form-control" value="{{$model->code}}"  required>
		 	
		 </div>
		 <div class="col-md-12 form-group">
		 	<label>Country Name</label>
		 	<input type="text" name="name" class="form-control" value="{{$model->name}}"  required>
		 	
		 </div>

		  <div class="col-md-12 form-group">
		   <button class="btn btn-primary"><?=($model->exists) ?"Update":"Create"?></button>
		 	
		 </div>
		

	</form>
	

</div>