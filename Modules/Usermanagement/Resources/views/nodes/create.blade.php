<div class="row">
	<form action="{{$url}}" method="post">
		 <?=csrf_field()?>
		 <div class="col-md-12 form-group">
		 	<label>Node Name</label>
		 	<input type="text" name="node_name" class="form-control" value="{{$model->node_name}}"  required>
		 	
		 </div>

		  <div class="col-md-12 form-group">
		   <button class="btn btn-success"><?=($model->exists) ?"Update":"Create"?></button>
		 	
		 </div>
		

	</form>
	

</div>