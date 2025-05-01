  
    <div class="search-item-container" >
                            <!-- BEGIN item-row -->
                            <div class="item-row"  > 

   <?php foreach($products as $product):?>
                                <div class="item item-thumbnail" style="margin-bottom:1%;box-shadow: rgba(50, 50, 93, 0.25) 0px 50px 100px -20px, rgba(0, 0, 0, 0.3) 0px 30px 60px -30px, rgba(10, 37, 64, 0.35) 0px -2px 6px 0px inset;">
                                   <a href="{{url('/ProductsDetails/'.$product->product_code)}}" class="item-image">
                                        <img src="{{ asset('MemberProducts/'.$product->product_image)}}" alt="Product Image"   height="380"  width="320"/>
                                        
                                    </a>
                                     <div class="item-info">
                                        <h4 class="item-title">
                                            <a href="{{url('/ProductsDetails/'.$product->product_code)}}">{{$product->value_name}}<br /></a>
                                        </h4>
                                        <p class="item-desc">{{$product->variety}}</p>
                                        <div class="item-price">Ksh {{$product->unit_price}} / {{$product->uom}}</div>
                                       
                                    </div>
                                </div>
 <?php endforeach;?>


</div>
</div>


 <div class="text-center">
                            <ul class="pagination m-t-0">
                                {{ $products->withQueryString()->links() }}


                                
                            </ul>
                        </div>