<div class="col-md-12">
	<form action="{{$url}}" method="post">
		 <?=csrf_field()?>

		 <div class="row">

		 	<div class="form-group col-md-12">
		 		<label>Value Chain Name</label>
		 		<select name="value_chain_id"  class="form-control" required>
		 			<option value="">---Select Value chain ----</option>
		 			  <?php  foreach($valuechains as $chain):?>
		 			  	<option   <?php if($product->value_chain_id==$chain->id):?>selected <?php endif;?> value="{{$chain->id}}">{{$chain->value_name}}</option>


		 			   <?php endforeach;?>
		 			
		 		</select>
		 		
		 	</div>

		 	<div class="form-group col-md-12">
		 		<label>Product Name</label>
		 		<input type="text" name="product_name" class="form-control" value="{{$product->product_name}}"  required>
		 		
		 	</div>

		 	

		 	


		 	<div class="col-md-12">
		 		<button class="btn btn-success btn-sm">Edit Details</button>
		 	</div>
		 	
		 </div>
		

	</form>

</div>