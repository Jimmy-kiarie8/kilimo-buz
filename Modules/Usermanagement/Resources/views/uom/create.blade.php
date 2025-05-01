<div class="row">
	<form action="{{$url}}" method="post">
		 <?=csrf_field()?>
		 <div class="col-md-12 form-group">
		 	<label>Unit Name</label>
		 	<input type="text" name="unit_name" class="form-control" value="{{$model->unit_name}}"  required>
		 	
		 </div>
		 <div class="col-md-12 form-group">
		 	<label>Unit Abbreviation</label>
		 	<input type="text" name="unit_abbreviation" class="form-control" value="{{$model->unit_abbreviation}}"  required>
		 	
		 </div>

		  <div class="col-md-12 form-group">
		   <button class="btn btn-success"><?=($model->exists) ?"Update":"Create"?></button>
		 	
		 </div>
		

	</form>
	

</div>