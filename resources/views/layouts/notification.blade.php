@if(count($errors)>0)
	<div class="alert alert-danger">
	<button type="button" class="close" data-dismiss="alert">&times;</button>
	
	<p><strong>OOPs</strong> there are some problems with inputs.
	<ul>
	@foreach($errors->all() as $error)
	      <li>{{$error}}</li>
	      
	@endforeach
	
	</ul>
	</div>
@endif

x
@if(Session::has('success_msg'))

<div class="alert alert-warning alert-dismissible" role="alert">
  <span type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></span>
  <strong>Warning!</strong> Still on beta stage.
</div>




@endif
@if(Session::has('danger_msg'))
<div class="alert alert-danger">
<button type="button" class="close" data-dismiss="alert">&times;</button>
{{ Session::get('danger_msg')}}
</div>
@endif
@if(Session::has('info_msg'))
<div class="alert alert-info">
<button type="button" class="close" data-dismiss="alert">&times;</button>
{{ Session::get('info_msg')}}
</div>
@endif