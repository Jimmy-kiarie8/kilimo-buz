<div class="col-md-12">
	<form action="{{$url}}" method="post">
		 <?=csrf_field()?>

		 <div class="row">
		 	<div class="form-group col-md-12">
		 		<label>Product Name</label>
		 		<input type="text" name="product_name" class="form-control" value="{{$product->product_name}}" readonly>
		 		
		 	</div>

		 	<div class="form-group col-md-12">
		 		<label>Key</label>
		 		<select name="key" class="form-control" required>

		 			<option>UoM</option>
		 			<option>Color</option>
		 			<option>Size</option>
		 			
		 		</select>
		 		
		 	</div>


		 	<div class="form-group col-md-12">
		 		<label>Value</label>
		 		<input type="text" name="value" class="form-control" value="{{old('value')}}"  required>
		 		
		 	</div>


		 	<div class="col-md-12">
		 		<button class="btn btn-success">Create</button>
		 	</div>
		 	
		 </div>
		

	</form>

</div>