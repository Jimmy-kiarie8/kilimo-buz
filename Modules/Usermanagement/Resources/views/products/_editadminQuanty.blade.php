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
		 		<label>Units of Measure</label>
		 		 {{ Form::select('uom',([null=>'--Select Units--'] + $units), $model->uom, ['class'=>'form-control','required'=>'required','id'=>'ChainName','style'=>'width:100%']) }}
		 		
		 	</div>
		 	<div class="form-group col-md-12">
		 		<label>Quantity Available</label>
		 		<input type="text" name="quantity_available" class="form-control" value="{{$model->quantity_available}}"  required>
		 		
		 		
		 	</div>

		 	<div class="form-group col-md-12">
		 		<label>Unit Selling Price</label>
		 		<input type="text" name="unit_price" class="form-control" value="{{$model->unit_price}}"  required>
		 		
		 		
		 	</div>


		 	<div class="col-md-12">
		 		<input type="checkbox" name="confirm" required> Confirm to Effect Selected Changes
		 	</div>


		 	<div class="col-md-12">
		 		<button class="btn btn-sm btn-success">Update Details</button>
		 	</div>
		 	
		 </div>
		

	</form>

</div>