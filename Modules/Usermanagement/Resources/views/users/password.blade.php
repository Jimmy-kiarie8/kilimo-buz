<div class="row">
	<form action="{{$url}}" method="post">
		 <?=csrf_field()?>
		 
		 <div class="form-group col-md-12">
		 	<label>Name</label>
		 	<input type="text" name="name" class="form-control"  value="{{$user->name}}"  readonly>
		 	
		 </div>
		 <div class="form-group col-md-12">
		 	<label>Email Address</label>
		 	<input type="text" name="name" class="form-control"  value="{{$user->email}}"  readonly>
		 	
		 </div>


		 <div class="form-group col-md-12">
		 	<label>Password</label>
		 	<input type="password" name="password" class="form-control"    required>
		 	
		 </div>
		 <div class="form-group col-md-12">
		 	<label>Confirm Password</label>
		 	<input type="password" name="password_confirmation" class="form-control"  required  >
		 	
		 </div>
		  <div class="form-group col-md-6">
		 	<button class="btn btn-info">Reset</button>
		 	
		 </div>

		


	</form>
	

</div>