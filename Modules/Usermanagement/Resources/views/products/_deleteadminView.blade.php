<div class="col-md-12">
	<form action="{{$url}}" method="post">
		 <?=csrf_field()?>

		 <div class="row">
		 

		 	<div class="form-group col-md-12">
		 		<label>Product Name</label>
		 		<input type="text" name="variety" class="form-control" value="{{$model->variety}}"  disabled="">
		 		
		 		
		 	</div>
		 	<div class="form-group col-md-12">
		 		<label>VCO Name</label>
		 		<input type="text" name="vconame" class="form-control" value="{{$model->vconame}}"  disabled="">
		 		
		 		
		 	</div>

		 	<div class="form-group col-md-12">
		 		<label>Seller Name</label>
		 		<input type="text" name="sellername" class="form-control" value="{{$model->sellername}}"  disabled="">
		 		
		 		
		 	</div>


		 	<div class="form-group col-md-12">
		 		<div class="alert alert-warning">
		 			<h6>Products With Associated Orders Cannot Be Deleted.Product Quantity Should be Set To 0</h6>
		 			
		 		</div>
		 		
		 	</div>
		 	<div class="col-md-12">
		 		<input type="checkbox" name="confirm" required> Confirm To Delete
		 	</div>


		 	<div class="col-md-12">
		 		<button class="btn btn-sm btn-danger">Delete</button>
		 	</div>
		 	
		 </div>
		

	</form>

</div>