<div class="row">
	<form action="{{$url}}" method="post">
		 <?=csrf_field()?>
		 <div class="col-md-12 form-group">
		 	<label>Qualification  Level</label>
		 	<input type="text" name="qualification_name" class="form-control" value="{{$model->qualification_name}}"  required>
		 	
		 </div>

		 <div class="col-md-12 form-group">
		 	<label>Score Weight</label>
		 	<input type="text" name="score_weight" class="form-control" value="{{$model->score_weight}}"  required>
		 	
		 </div>

		  <div class="col-md-12 form-group">
		   <button class="btn btn-primary"><?=($model->exists) ?"Update":"Create"?></button>
		 	
		 </div>
		

	</form>
	

</div>