@extends("layouts.appmain")



@section('content')

 <section class="section">
          <div class="section-body">
            <div class="row">
              <div class="col-12 col-md-12 col-lg-12">
                <div class="card">
                  <div class="card-header">
                    <h4>Edit Product Details</h4>
                  </div>
                  <div class="card-body">
                  	<form action="{{$url}}" method="post">
                       <?=csrf_field()?>
                    <div class="row">

                  

                       	<div class="form-group col-md-4">
                      <label>Member  Name</label>
                        {{ Form::select('member_id',([null=>'--Select Member--'] + $members), $model->member_id, ['class'=>'form-control','required'=>'required','id'=>'MemberID','style'=>'width:100%']) }}

                    </div>

                    <div class="form-group col-md-4">
                      <label>Member Number</label>
                      <input type="text" name="member_number" readonly value="{{$model->member->member_number}}" class="form-control" id="MemberNumber">
                    </div>


                    <div class="form-group col-md-4">
                      <label>Value Chain</label>
                      

                      {{ Form::select('value_chain_id',([null=>'--Select Value Chain--'] + $values), $model->value_chain_id, ['class'=>'form-control','required'=>'required','id'=>'ChainName','style'=>'width:100%']) }}


                    </div>
                 </div>

                  <div class="row">
                        <div class="form-group col-md-4">
                      <label>Variety Name</label>
                      <input type="text" name="variety" required="required" value="{{$model->variety}}" class="form-control" >
                    </div>

                   
                     


                    <div class="form-group col-md-4">
                      <label>Unit of Measure</label>

                         {{ Form::select('uom_id',([null=>'--Select Units--'] + $units), $model->uom_id, ['class'=>'form-control','required'=>'required','id'=>'Unit','style'=>'width:100%']) }}
                      

                    



                    </div>
                    <div class="form-group col-md-4">
                      <label>Quantity Available</label>
                       <input type="text" name="quantity_available" required="required" value="{{$model->quantity_available}}" class="form-control" >
                       


                    </div>
                    <div class="form-group col-md-4">
                      <label>Unit Selling Price (Kes)</label>
                       <input type="text" name="unit_price" required="required" value="{{$model->unit_price}}" class="form-control" >
                       


                    </div>
                     
                   
                 </div>

                  
                  		
                    
                  <div class="card-footer text-right">
                    <button class="btn btn-primary mr-1" type="submit">Update</button>
                   
                  </div>
                  		

                  	</form>
                    

                </div>
                
                
               


                
              </div>




            </div>
          </div>
        </section>


               

@endsection
@push('scripts')
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
 <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

   <script>
    $("#MemberID").on("change",function(e){
      e.preventDefault();
         var id=$(this).val();
           if(id.length>0)
           {
             var url="<?=url('/System/MemberAccount/getMemberDetails')?>/"+id;
               $.get(url,function(data){
                 $("#MemberNumber").val(data);
               });
           }
       });

     $("#ChainName").on("change",function(e){
       e.preventDefault();
         var id=$(this).val();
           if(id.length>0)
           {
             var url="<?=url('/System/ValueChain/getUoM')?>/"+id;
               $.get(url,function(data){
                 $("#UnitOfMeasure").val(data);
               });
           }

     })



  
  </script>
@endpush