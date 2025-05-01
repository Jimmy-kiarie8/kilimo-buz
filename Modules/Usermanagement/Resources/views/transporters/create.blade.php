@extends("layouts.app")


@section('content')


<!--=== Blue Chart ===-->
<p>
  <a href="<?=url('/System/TransportNode/Create')?>" class="btn btn-sm btn-info"><span class="fa fa-plus"><span>Add New Transporter</a>

    <a href="<?=url('/System/TransportNode/Index')?>" class="btn btn-sm btn-success"><span class="fa fa-bars"><span>List of Transporters</a>
         
    </p>



      <div class="row">

        <div class="col-md-12">
          <div class="widget box" >
            <div class="widget-header">
              <h4><i class="icon-reorder"></i>Registered New Transporters </h4>
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
            <label>County Name</label>
            <span class="input-icon icon-right">
             {{ Form::select('county_id',([null=>'--Select County--'] + $counties), $model->county_id, ['class'=>'form-control','required'=>'required','id'=>'LibrarSy','style'=>'width:100%']) }}


           </span>
         </div>




               <div class="form-group col-md-6">
                <label>VCO Name</label>
                 {{ Form::select('vco_number',([null=>'--Select VCO Name--'] + $orgs), $model->vco_number, ['class'=>'form-control','required'=>'required','id'=>'LibrarSy','style'=>'width:100%']) }}
            </div>

           



          </div>
          <div class="row">
             <div class="form-group col-md-6">
              <label>Transporter Name</label>
              <input type="text" class="form-control" name="name" id="email" placeholder="Transporter Name" value="{{(isset($model->name))?$model->name:old('name')}}"  required>
            </div>


           <div class="form-group col-md-6">
            <label>Telephone</label>

            <input type="text"
            id="Phone" class="form-control" name="contact_telephone" placeholder="Phone" value="{{old('contact_telephone')}}" required >


          </div>

          



       </div>


       
        
      <div class="row">
        <div class="form-group col-md-6">
          <label>Items Transported</label>
          <input type="text"
          class="form-control" name="items_transported" placeholder="items transported" value="{{old('items_transported')}}" required >


        </div>

        <div class="form-group col-md-3">
          <label>Origin</label>
          <input type="text"
          class="form-control" name="origin" placeholder="Origin" value="{{old('origin')}}" required >
        </div>


        <div class="form-group col-md-3">
          <label>Destination</label>
          <input type="text"
          class="form-control" name="destination" placeholder="Destination" value="{{old('destination')}}" required >
        </div>


      </div>
      <div class="row">
        

        <div class="form-group col-md-3">
          <label>Capacity</label>
          <input type="text"
          class="form-control" name="capacity" placeholder="Capacity" value="{{old('capacity')}}" required >
        </div>

        <div class="form-group col-md-3">
          <label>Duration To Destination</label>
          <input type="text"
          class="form-control" name="duration_to_destination" placeholder="Estimation  Duration " value="{{old('duration_to_destination')}}" required >
        </div>

        <div class="form-group col-md-2">
          <label>KM Covered</label>
          <input type="text"
          class="form-control" name="km_covered" placeholder="KM Covered" value="{{old('km_covered')}}" required >
        </div>

        <div class="form-group col-md-2">
          <label>Cost Per KM</label>
          <input type="text"
          class="form-control" name="cost_Per_km" placeholder="KM Covered" value="{{old('cost_Per_km')}}" required >
        </div>

         <div class="form-group col-md-2">
          <label>Payment Mode</label>
          <select  name="payment_model" class="form-control" required>
            <option>Any</option>
            <option>M-PESA</option>
            <option>CASH</option>
            <option>BANK</option>

            
          </select>
          
        </div>

        


      </div>
      <div class="row">
        <div class="form-group col-md-12">
          <label>Special Features</label>
          <textarea name="special_features" class="form-control" rows="2"></textarea>
          
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