<div class="row">
	<div class="col-md-12">
	<div class="table-responsive">
		<table class="table table-bordered">
			<thead>
				<tr class="info">
					<th>#</th>
					<th>Username</th>
					<th>Name</th>
					<th>Email Address</th>
				</tr>
			</thead>
			<tbody>

				 <?php $i=1; foreach($models as $model):?>
				 	<tr>
				 		<td>{{$i}}</td>
				 		<td>{{$model->username}}</td>
				 		<td>{{$model->name}}</td>
				 		<td>{{$model->email}}</td>
				 	</tr>
				 <?php $i++; endforeach;?>
				
			</tbody>
			
		</table>
		
	</div>
	
</div>
</div>