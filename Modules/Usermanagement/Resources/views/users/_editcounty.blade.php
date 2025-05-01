<div class="row">
	<form action="{{$url}}" method="post">
		 <?=csrf_field()?>
		 
		 <div class="form-group col-md-12">
		 	<label>Name</label>
		 	<input type="text" name="name" class="form-control"  value="{{$user->name}}"  readonly>
		 	
		 </div>
		 <div class="form-group col-md-12">
		 	<label>County Name</label>
		 	<select name="org_id" class="form-control" required>
		 		<option value="">---Select County-----</option>

		 		 <?php foreach($models as $county):?>
		 		 	<option  <?php if($user->org_id==$county->id):?>selected<?php endif;?> value="{{$county->id}}">{{$county->county_name}}</option>
		 		 <?php endforeach;?>
		 		
		 	</select>
		 	
		 </div>


		 
		  <div class="form-group col-md-6">
		 	<button class="btn btn-sm btn-info">Update Details</button>
		 	
		 </div>

		


	</form>
	

</div>