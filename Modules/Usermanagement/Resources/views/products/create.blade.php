@extends("layouts.appmain")



@section('content')

 <section class="section">
          <div class="section-body">
            <div class="row">
              <div class="col-12 col-md-12 col-lg-12">
                <div class="card">
                  <div class="card-header">
                    <h4>Add New Product Details</h4>
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
                      <input type="text" name="member_number" readonly value="{{$model->member_email}}" class="form-control" id="MemberNumber">
                    </div>


                    <div class="form-group col-md-4">
                      <label>Value Chain</label>
                      

                      {{ Form::select('value_chain_id',([null=>'--Select Value Chain--'] + $values), $model->value_chain_id, ['class'=>'form-control','required'=>'required','id'=>'ChainName','style'=>'width:100%']) }}


                    </div>
                 </div>

                  <div class="row">
                        <div class="form-group col-md-4">
                      <label>Product Name</label>
                        {{ Form::select('product_name',([null=>'--Select Product Name--'] + array()), $model->product_name, ['class'=>'form-control','required'=>'required','id'=>'ProductName','style'=>'width:100%']) }}


                    </div>

                   
                     


                    <div class="form-group col-md-4">
                      <label>Unit of Measure</label>
                       <input type="text" name="uom" required value="{{$model->uom}}" class="form-control" id="uom">


                         
                    </div>
                    <div class="form-group col-md-4">
                      <label>Color</label>

                       <input type="text" name="product_color" required value="{{$model->product_color}}" class="form-control" id="uom">

                         
                    </div>
                    <div class="form-group col-md-4">
                      <label>Size</label>

                          {{ Form::select('product_size',([null=>'--Select size--'] + array("Large"=>"Large","Small"=>"Small","Medium"=>"Medium","N/A"=>"N/A")), $model->product_size, ['class'=>'form-control','required'=>false,'id'=>'Sizee','style'=>'width:100%']) }}
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
                    <button class="btn btn-primary mr-1" type="submit">Submit</button>
                   
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
                 $("#ProductName").html(data);
               });
           }

     });

       $("#ProductName").on("change",function(e){
       e.preventDefault();
         var id=$(this).val();
         var key="Uom";
           if(id.length>0)
           {
             var url="<?=url('/System/Product/getUoM')?>/"+id;
               $.get(url,{'key':key},function(data){
                 $("#UOM").html(data);
               });
           }

     });


        $("#ProductName").on("change",function(e){
       e.preventDefault();
         var id=$(this).val();
         var key="Color";
           if(id.length>0)
           {
             var url="<?=url('/System/Product/getUoM')?>/"+id;
               $.get(url,{'key':key},function(data){
                 $("#Color").html(data);
               });
           }

     });



         $("#ProductName").on("change",function(e){
       e.preventDefault();
         var id=$(this).val();
         var key="Size";
           
           if(id.length>0)
           {
             var url="<?=url('/System/Product/getUoM')?>/"+id;
               $.get(url,{'key':key},function(data){
                 $("#Size").html(data);
               });
           }

     });




     







  
  </script>
@endpush