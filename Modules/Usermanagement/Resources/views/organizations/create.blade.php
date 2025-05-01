@extends("layouts.app")


@section('content')


<!--=== Blue Chart ===-->
<p>
  <a href="<?=url('/System/Entities/Create')?>" class="btn btn-sm btn-info"><span class="fa fa-plus"><span>Add New</a>

    <a href="<?=url('/System/Entities/Index')?>" class="btn btn-sm btn-success"><span class="fa fa-bars"><span>List of VCOs</a>


      <a href="<?=url('/System/Entities/Import')?>" class="btn btn-sm btn-danger"><span class="fa fa-upload"><span>Import VCOs</a>

      




      </p>

      <div class="row">
        <div class="col-md-12">
          <div class="widget box">
            <div class="widget-header">
              <h4><i class="icon-reorder"></i>Registered New Organization </h4>
              <div class="toolbar no-padding">
                <div class="btn-group">
                  <span class="btn btn-xs widget-collapse"><i class="icon-angle-down"></i></span>
                </div>
              </div>
            </div>
            <div class="widget-content"> 
             <form role="form" action="{{$url}}" method="post">
              <?=csrf_field()?>
              <div class="row">




               <div class="form-group col-md-6">
                <label>Organization Name</label>
                <input type="text" class="form-control" id="Name" placeholder="Name" value="{{(isset($model->org_name))?$model->org_name:old('org_name')
              }}"  name="org_name" required>
            </div>

            <div class="form-group col-md-6">
              <label>Email Address</label>
              <input type="email" class="form-control" name="org_email" id="email" placeholder="Email Address" value="{{(isset($model->org_email))?$model->org_email:old('org_email')}}"  required>
            </div>



          </div>
          <div class="row">


           <div class="form-group col-md-6">
            <label>Telephone</label>

            <input type="text"
            id="Phone" class="form-control" name="org_tephone" placeholder="Phone" value="{{old('org_tephone')}}" required >


          </div>

          <div class="form-group col-md-6">
            <label>Organization Type</label>
            <span class="input-icon icon-right">
             {{ Form::select('node_id',([null=>'--Select Node Type--'] + $nodes), $model->node_id, ['class'=>'form-control','required'=>'required','id'=>'LibrarSy','style'=>'width:100%']) }}


           </span>
         </div>



       </div>


       <div class="row">
        <div class="form-group col-md-6">
          <label>County</label>

          {{ Form::select('county_id',([null=>'--Select County--'] + $county), $model->county_id, ['class'=>'form-control','required'=>'required','id'=>'County','style'=>'width:100%']) }}


        </div>

        <div class="form-group col-md-6">
          <label>Sub County</label>

          {{ Form::select('sub_county_id',([null=>'--Select County--'] + $sub_counties), $model->sub_county_id, ['class'=>'form-control','required'=>'required','id'=>'SubCounty','style'=>'width:100%']) }}
          

        </div>
      </div>
      <div class="row">
        <div class="form-group col-md-6">
          <label>Ward</label>

          <input type="text"
          class="form-control" name="ward_name" placeholder="Ward" value="{{old('ward_name')}}" required >


        </div>

        <div class="form-group col-md-6">
          <label>Value Chain</label>

          {{ Form::select('value_chain_id',([null=>'--Select Value--'] + array()), $model->value_chain_id, ['class'=>'form-control','required'=>'required','id'=>'ValueChain','style'=>'width:100%']) }}


        </div>
      </div>


      <div class="row">
        <div class="form-group col-md-6">
          <button class="btn btn-info"><?=($model->exists)?"Update":"Create"?></button>
        </div>
      </div>




    </form>


  </div>
</div>
</div>
</div>







@stop
@push('scripts')
<script>
 $("#County").on("change",function(e){
  e.preventDefault();
  var id=$(this).val();
  if(id.length>0)
  {
   var url="<?=url('/System/Entities/GetSubCounties')?>/"+id;
   $.get(url,function(data){
    $("#SubCounty").html(data);
  });
 }

});


 $("#County").on("change",function(e){
  e.preventDefault();
  var id=$(this).val();
  if(id.length>0)
  {
   var url="<?=url('/System/Entities/GetValueChains')?>/"+id;
   $.get(url,function(data){
    $("#ValueChain").html(data);
  });
 }

});


</script>

@endpush