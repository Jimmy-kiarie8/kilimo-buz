
<div class="row">
	<div class="col-md-12">
		
	
	<div class="table-responsive"  max-height="180" overflow="auto">
		<table class="table table-bordered">
			<thead>
				<tr class="info">
					<th>#</th>
					<th>Group</th>
					<th>Name</th>
				</tr>
			</thead>
			<tbody  style="max-height:180;overflow: auto;">

				 <?php $i=1; foreach($models as $model):?>
				 	<tr>
				 		<td>{{$i}}</td>
				 		<td>{{$model->perm_category}}</td>
				 		<td>{{$model->name}}</td>
				 	</tr>
				 <?php $i++; endforeach;?>
				
			</tbody>
			
		</table>
		
	</div>
	
</div>
</div>