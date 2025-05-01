@extends('front.main')
<?php 
use App\Helpers\Helper; 
?>
@section('content')
<style type="text/css">
    
    .section-container {
    padding: 15px 0;
}
</style>
<!-- BEGIN search-results -->




        <div id="search-results" class="section-container bg-silver">

            <div id="product" class="section-container pt-20px">

<div class="container">

<ul class="breadcrumb">
<li class="breadcrumb-item"><a href="#">Home</a></li>
<li class="breadcrumb-item"><a href="#">Products</a></li>
<li class="breadcrumb-item active"><a href="#">{{$model->product_name}}</a></li>

</ul>


<div class="product">

<div class="product-detail">

<div class="product-image">

<div class="product-thumbnail">
<ul class="product-thumbnail-list">






</ul>
</div>


<div class="product-main-image" data-id="main-image">


  <img  width="250"  height="400"  src="{{asset('MemberProducts/'.$model->product_image)}}" alt="image" />
</div>

</div>


<div class="product-info">

<div class="product-info-header">
<h1 class="product-title"><span class="badge bg-success" style="background-color:green">{{$model->variety}}</span>  {{$model->value_chain_name}} - #{{$model->id}} </h1>
<ul class="product-category">
<li><a href="#">{{$model->value_chain_name}}</a></li>
<li>/</li>
<li><a href="#">{{$model->variety}}</a></li>
<li>/</li>

</ul>
</div>


<div class="product-warranty">
<div class="pull-right"><b>Availability:  {{($model->quantity_available>0)?'In stock':'Out Of Stock'}}</b></div>
<div style="color:green"> Locally Manufactured</div>
 {!!$model->product_description!!}
</div>
<div class="pull-center"><b> <center>Detailed Information</center></b></div>


<div>
    County Name:<span class="badge bg-warning">{{$model->county_name}}</span>
</div>

<div>
    Sub County Name:<span class="badge bg-warning">{{$model->county_name}}</span>
</div>

<div>
    Physical Location:<span class="badge bg-warning">{{$model->town}}, {{$model->street}} </span>
</div>

<div>
    Other Location Details:<span class="badge bg-warning">({{$model->latitude}}, {{$model->longitude}} )</span>
</div>
<br><p>




<div>
    Quantities Available:<span class="badge bg-warning">{{$model->quantity_available}} <span class="badge bg-warning">{{$model->uom}}</span></span>
</div>
<div>
    Unit Price:<span class="badge bg-warning">KES {{$model->unit_price}}</span>
</div>

<div>
    VCO Name:<span class="badge bg-warning">{{$model->vconame}}</span>
</div>

<div>
    Seller Name:<span class="badge bg-warning">{{$model->sellername}}</span>
</div>
<div>
    Seller Number:<span class="badge bg-warning">{{$model->member->member_number}}</span>
</div>
<div>
    Mobile:<span class="badge bg-warning">{{$model->sellermobilenumber}}</span>
</div>


<div>
    Last Updated At:<span class="badge bg-warning">{{$model->updated_at}}</span>
</div>


<hr>

<br>





<div class="product-social">
<ul>
<li><a href="javascript:;" class="facebook" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-title="Facebook" data-bs-placement="top"><i class="fab fa-facebook-f"></i></a></li>
<li><a href="javascript:;" class="twitter" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-title="Twitter" data-bs-placement="top"><i class="fab fa-twitter"></i></a></li>
<li><a href="javascript:;" class="google-plus" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-title="Google Plus" data-bs-placement="top"><i class="fab fa-google-plus-g"></i></a></li>
<li><a href="javascript:;" class="whatsapp" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-title="Whatsapp" data-bs-placement="top"><i class="fab fa-whatsapp"></i></a></li>
<li><a href="javascript:;" class="tumblr" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-title="Tumblr" data-bs-placement="top"><i class="fab fa-tumblr"></i></a></li>
</ul>
</div>


<div class="product-purchase-container">

<a href="#" class="btn btn-xs  btn-dark btn-theme btn-lg w-200px">Place Order</a>
</div>

</div>

</div>

  <div class="col-md-12">
     <div class="product-tab" style="margin-top:-2%;">





  </div>
    
  </div>



</div>


<h4 class="mb-15px mt-30px">You Might Also Like</h4>
<div class="row gx-2">

      <?php foreach($featured as $value):?>

<div class="col-lg-2 col-md-4 col-sm-6">

<div class="item item-thumbnail">
<a href="{{url('/ProductsDetails/'.$value->product_code)}}" class="item-image">
<img src="{{ asset('uploads/'.$value->filename)}}" alt="" />

</a>
<div class="item-info">
<h4 class="item-title">
<a href="#">{{$value->value_name}}<br /></a>
</h4>
<p class="item-desc">{{$value->product_name}}</p>
<div class="item-price">Ksh {{$value->product_price}} /Unit</div>

</div>
</div>

</div>
 <?php endforeach;?>
</div>

</div>

</div>
               
            
            <!-- END container -->
        </div>
        <!-- END search-results -->
@endsection