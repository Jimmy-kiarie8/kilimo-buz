<div class="row">

	<form  action="{{$url}}" method="post">
		  <?=csrf_field()?>
		  <div class="col-md-12 form-group">
		  	<label>Seller</label>
		  	<input type="text" name="seller" value="{{$organization->org_name}}" class="form-control" readonly>
		  	
		  </div>

		  <div class="col-md-6 form-group">
		  	<label>Buyer Name</label>
		  	<input type="text" name="buyer_name" value="{{(Auth::User())?Auth::User()->name:null}}" class="form-control" required>
		  	
		  </div>
		  <div class="col-md-6 form-group">
		  	<label>Buyer Telephone</label>
		  	<input type="text" name="telephone" value="{{(Auth::User())?Auth::User()->phone:null}}" class="form-control" required>
		  	
		  </div>

		   <div class="col-md-4 form-group">
		  	<label>Product Name</label>
		  	
		  	<input type="text" name="product" value="{{$model->product_name}}" class="form-control" required>

		  	
		  </div>
		  <div class="col-md-6 form-group">
		  	<label>Quantity</label>
		  	<input type="text" name="qty"  class="form-control" required>
		  	
		  </div>
		  <div class="col-md-2 form-group">
		  	<label>Units</label>

		  	<input type="text" name="product" value="{{$model->product_uom}}" class="form-control" readonly>
		  	
		  	
		  </div>


		   <div class="col-md-6 form-group">
		  	<button class="btn btn-success">Submit Order</button>
		  	
		  </div>
		  


	</form>
	
</div>