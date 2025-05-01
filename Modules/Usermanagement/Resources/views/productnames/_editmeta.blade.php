<div class="col-md-12">
	<form action="{{$url}}" method="post">
		 <?=csrf_field()?>

		 <div class="row">
		 

		 	<div class="form-group col-md-12">
		 		<label>Key</label>
		 		<select name="key" class="form-control" required>

		 			<option <?php if($model->key=="UoM"):?>selected  <?php endif;?> >UoM</option>
		 			<option  <?php if($model->key=="Color"):?>selected  <?php endif;?>  >Color</option>
		 			<option  <?php if($model->key=="Size"):?>selected  <?php endif;?>  >Size</option>
		 			
		 		</select>
		 		
		 	</div>


		 	<div class="form-group col-md-12">
		 		<label>Value</label>
		 		<input type="text" name="value" class="form-control" value="{{$model->value}}"  required>
		 		
		 	</div>


		 	<div class="col-md-12">
		 		<button class="btn btn-success">Create</button>
		 	</div>
		 	
		 </div>
		

	</form>

</div>