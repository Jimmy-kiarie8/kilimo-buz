<div class="row">
	<div class="table-responsive">
		<table class="table table-bordered">
			<tr>
				<td>Member Number</td>
				<td>{{$model->member_number}}</td>
			</tr>
			<tr>
				<td>Member Name</td>
				<td>{{$model->member_name}}</td>
			</tr>
			<tr>
				<td>National ID</td>
				<td>{{$model->id_number}}</td>
			</tr>
			<tr>
				<td>Gender</td>
				<td>{{$model->id_number}}</td>
			</tr>

			<tr>
				<td>Telephone</td>
				<td>{{$model->member_telephone}}</td>
			</tr>
			<tr>
				<td>Email Address</td>
				<td>{{$model->member_email}}</td>
			</tr>

			<tr>
				<td>Node</td>
				<td>{{($model->node)?$model->node->node_name:"Not Set"}}</td>
			</tr>

			<tr>
				<td>Value Chain</td>
				<td>{{($model->valuechain)?$model->valuechain->value_name:"Not Set"}}</td>
			</tr>
			
		</table>
		
	</div>
	
</div>