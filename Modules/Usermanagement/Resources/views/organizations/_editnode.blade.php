<div class="row">
	<form action="{{$url}}" method="post">
		  <?=csrf_field()?>
		  <div class="col-md-12 form-group">
		  	<label>VCO Name</label>
		  	<input type="text" readonly name="org_name" value="{{$model->org_name}}" class="form-control">
		  	 
		  </div>

		   <div class="col-md-12 form-group">
		  	<label>Current Node</label>
		  	<input type="text" readonly name="valuechain" value="{{($model->node)? $model->node->node_name:null}}" class="form-control">
		  	 
		  </div>

		  <div class="col-md-12 form-group">
		  	<label>New Value Chain</label>
		    <select name="value_chain_id" class="form-control" required>
		    	<option value="">--Select One---</option>
		    	  <?php foreach($nodes as $key):?>
		    	  	<option value="{{$key->id}}">{{$key->node_name}}</option>

		    	   <?php endforeach;?>
		    	
		    </select>
		  	 
		  </div>
		   <div class="col-md-12 form-group">
		   	<button class="btn btn-success">Complete</button>

		   </div>
		

	</form>
	
</div>