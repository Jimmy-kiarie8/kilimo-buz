<div class="row">
	<form action="{{$url}}" method="post">
		 <?=csrf_field()?>
		 <div class="col-md-12 form-group">
		 	<label>County  Name</label>
		 	<select name="county_id" class="form-control" required>
		 		 <option value="">----Select County---</option>
		 		  <?php foreach($models as $mod):?>
                    <option <?php if($model->county_id==$mod->id):?>selected <?php endif;?> value="{{$mod->id}}">{{$mod->county_name}}</option>
		 		  <?php endforeach;?>
		  </select>
		 	
		 </div>

		 <div class="col-md-12 form-group">
		 	<label>Sub County  Name</label>
		 	<input type="text" name="sub_county_name" class="form-control" value="{{$model->sub_county_name}}"  required>
		 	
		 </div>

		  <div class="col-md-12 form-group">
		   <button class="btn btn-success"><?=($model->exists) ?"Update":"Create"?></button>
		 	
		 </div>
		

	</form>
	

</div>