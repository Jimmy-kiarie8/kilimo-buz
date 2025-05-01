<div class="col-md-12">
	<form action="{{$url}}" method="post">
		 <?=csrf_field()?>

		 <div class="row">
		 	<div class="form-group col-md-12">
		 		<label>Product Name</label>
		 		<input type="text" name="product_name" class="form-control" value="{{$product->product_name}}" readonly>
		 		
		 	</div>

		 	<div class="form-group col-md-12">
		 		<label>Default Unit of Measure</label>
		 		<input type="text" name="product_uom" class="form-control" value="{{$product->product_uom}}"  required>
		 		
		 	</div>

		 	

		 	<div class="form-group col-md-12">
		 		<label>Unit Average Market  Price</label>
		 		<input type="text" name="product_price" class="form-control" value="{{$product->product_price}}"  required>
		 		
		 	</div>


		 	<div class="col-md-12">
		 		<button class="btn btn-success btn-sm">Edit</button>
		 	</div>
		 	
		 </div>
		

	</form>

</div>