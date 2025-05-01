<div class="col-md-12">
	<form  action="{{$url}}" method="post">

		 <?=csrf_field();?>
		<div class="row">
			
		
		<div class="col-md-6 form-group">
			<label>Buyer Name</label>
			<input type="text" name="buyer_name" class="form-control"  disabled value="{{$model->customer_name}}">
			
		</div>

		<div class="col-md-6 form-group">
			<label>Telephone</label>
			<input type="text" name="buyer_name" class="form-control"  disabled value="{{$model->customer_phone}}">
			
		</div>

		</div>
		<div class="row">
			
		
		<div class="col-md-6 form-group">
			<label>Product Name</label>
			<input type="text" name="buyer_name" class="form-control"  disabled value="{{$model->customer_name}}">
			
		</div>

		<div class="col-md-6 form-group">
			<label>Quantity Ordered</label>
			<input type="text" name="qty" class="form-control"  disabled value="{{$model->qty}}">
			
		</div>

		<div class="col-md-6 form-group">
			<label>Payment Method</label>
			<select name="payment_method" class="form-control" required>
				<option>CASH</option>
				<option>M-PESA</option>
				<option>BANK</option>
				
			</select>
			
		</div>
		<div class="col-md-3 form-group">
			<label>Unit Price </label>
			<input type="text" name="unit_price" class="form-control"  required value="{{$model->unit_price}}">
			
		</div>

		<div class="col-md-3 form-group">
			<label>Amount </label>
			<input type="text" name="amount_paid" class="form-control"  required value="{{$model->amount_paid}}">
			
		</div>

		</div>




		<div class="row">
			
		
		<div class="col-md-6 form-group">
			<button class="btn btn-sm btn-success">Complete</button>
			
		</div>

	</div>





		

	</form>
	
</div>