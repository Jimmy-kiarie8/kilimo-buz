<div class="row">
	<form action="{{$url}}" method="post">
		 <?=csrf_field()?>
		 <div class="col-md-12 form-group">
		 	<label>Name</label>
		 	<input type="text" name="value_name" class="form-control" value="{{$model->value_name}}"  required>
		 	
		 </div>
		  <div class="col-md-12 form-group">
		 	<label>Unit of Measure</label>
		 	<select name="uom_id" class="form-control" required>
		 		 <option value="">---Select Unit---</option>
		 		   <?php foreach($units as $unit):?>
                    <option <?php if($model->uom_id==$unit->id):?>selected <?php endif;?> value="{{$unit->id}}">{{$unit->unit_name}}</option>
		 		   <?php endforeach;?>
		 		
		 	</select>
		 	
		 </div>



		  <div class="col-md-12 form-group">
		   <button class="btn btn-success"><?=($model->exists) ?"Update":"Create"?></button>
		 	
		 </div>
		

	</form>
	

</div>