<div class="row">
	<form action="{{$url}}" method="post">
		 <?=csrf_field()?>
		 <div class="col-md-12 form-group">
		 	<label>County Name</label>
		 	 <select name="county_id" class="form-control" required>
		 	 	 <option value="">---Select  County---</option>
		 	 	   <?php foreach($counties as $county):?>
		 	 	   	<option <?php if($model->county_id==$county->id):?>selected <?php endif;?> value="{{$county->id}}">{{$county->county_name}}</option>


		 	 	   <?php endforeach;?>
		 	 	
		 	 </select>
		 	
		 </div>
		  <div class="col-md-12 form-group">
		 	<label>Value Chain</label>
		 	  <select name="value_chain_id" class="form-control" required>
		 	 	 <option value="">---Select  Item---</option>
		 	 	   <?php foreach($values as $county):?>
		 	 	   	<option <?php if($model->value_chain_id==$county->id):?>selected <?php endif;?>  value="{{$county->id}}">{{$county->value_name}}</option>


		 	 	   <?php endforeach;?>
		 	 	
		 	 </select>
		 	
		 </div>

		  <div class="col-md-12 form-group">
		   <button class="btn btn-success"><?=($model->exists) ?"Update":"Create"?></button>
		 	
		 </div>
		

	</form>
	

</div>