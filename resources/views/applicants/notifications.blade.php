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
@if(Session::has('success_msg'))
<div class="alert alert-success alert-dismissible" role="alert">
  <span type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></span>
 {{ Session::get('success_msg')}}
</div>




@endif
@if(Session::has('danger_msg'))



<div class="alert alert-danger alert-dismissible" role="alert">
  <span type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></span>
 {{ Session::get('danger_msg')}}
</div>

@endif
@if(Session::has('info_msg'))

<div class="alert alert-info alert-dismissible" role="alert">
  <span type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></span>
  {{ Session::get('info_msg')}}

</div>

@endif