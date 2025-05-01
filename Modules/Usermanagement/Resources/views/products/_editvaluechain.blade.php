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
		 		<label>Value</label>
		 		 {{ Form::select('value_chain_id',([null=>'--Select Value Chain--'] + $value_chains), $model->value_chain_id, ['class'=>'form-control','required'=>'required','id'=>'ChainName','style'=>'width:100%']) }}
		 		
		 	</div>
		 	<div class="col-md-12">
		 		<input type="checkbox" name="confirm" required> Confirm to Effect Selected Value Chain
		 	</div>


		 	<div class="col-md-12">
		 		<button class="btn btn-sm btn-success">Update Details</button>
		 	</div>
		 	
		 </div>
		

	</form>

</div>