<div class="row">
	<form action="{{$url}}" method="post">
		 <?=csrf_field()?>
		 <div class="col-md-12 form-group">
		 	<label>Clan Name</label>
		 	<select name="clan_id" class="form-control" required>
		 		 <option value="">----Select Tribe---</option>
		 		  <?php foreach($clans as $mod):?>
                    <option <?php if($model->clan_id==$mod->id):?>selected <?php endif;?> value="{{$mod->id}}">{{$mod->clan_name}}</option>
		 		  <?php endforeach;?>
		  </select>
		 	
		 </div>

		 <div class="col-md-12 form-group">
		 	<label>Sub Clan Name</label>
		 	<input type="text" name="clan_name" class="form-control" value="{{$model->sub_clan_name}}"  required>
		 	
		 </div>

		  <div class="col-md-12 form-group">
		   <button class="btn btn-primary"><?=($model->exists) ?"Update":"Create"?></button>
		 	
		 </div>
		

	</form>
	

</div>