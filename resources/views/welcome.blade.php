@extends('front.main')

@section('crumb')
    <!-- BEGIN #page-header -->
    <div id="page-header" class="section-container page-header-container bg-black">
        <!-- BEGIN page-header-cover -->
        <div class="page-header-cover">
            <img src="{{ asset('kilimo_buz_img.png') }}" alt="logo" />
        </div>
        <!-- END page-header-cover -->
        <!-- BEGIN container -->
        <div class="container">
            <h3 class="page-header">KILIMO <b>BUZ</b> : " SOKO MKONONI "</h3>
        </div>
        <!-- END container -->
    </div>
    <!-- BEGIN #page-header -->
@endsection

@section('content')
    <!-- BEGIN search-results -->


    <div id="search-results" class="section-container bg-silver" style="margin-top: -2.5%;">


        <div id="trending-items" class="section-container">

            <div class="container">

                <h4 class="section-title clearfix">
                    <span class="flex-1">
                        Featured Items
                        <small style="color: green">Browse and get your favourite items</small>
                    </span>
                    <div class="btn-group">
                        <a href="#" class="btn"><i class="fa fa-angle-left fs-16px"></i></a>
                        <a href="#" class="btn"><i class="fa fa-angle-right fs-16px"></i></a>
                    </div>
                </h4>


                <div class="row gx-2">

                    <?php foreach($featured as $value):?>

                    <div class="col-lg-2 col-md-4 col-sm-6" style="box-shadow: 10px 10px 5px 5px green;">

                        <div class="item item-thumbnail">
                            <a href="{{ url('/ProductsDetails/' . $value->product_code) }}" class="item-image">
                                <img src="{{ asset('MemberProducts/' . $value->product_image) }}" alt="" />
                                <div class="discount"> </div>
                            </a>
                            <div class="item-info">
                                <h4 class="item-title">
                                    <a href="#">{{ $value->value_name }}<br /></a>
                                </h4>
                                <p class="item-desc">{{ $value->variety }}</p>
                                <div class="item-price">KES {{ $value->unit_price }}</div>

                                <h4 class="item-title">
                                    <a href="#">{{ $value->county_name }}<br /></a>
                                </h4>



                            </div>
                        </div>

                    </div>
                    <?php endforeach;?>

                </div>

            </div>

        </div>

        <!-- BEGIN container -->
        <div class="container">

            <!-- BEGIN search-container -->
            <div class="search-container">
                <!-- BEGIN search-content -->
                <div class="search-content">
                    <!-- BEGIN search-toolbar -->

                    <!-- END search-toolbar -->
                    <!-- BEGIN search-item-container -->
                    <div id="loadmytable">


                        <div class="search-item-container">
                            <!-- BEGIN item-row -->
                            <div class="item-row">
                                <!-- BEGIN item -->
                                <?php foreach($chains as $product):?>


                                <div class="item item-thumbnail"
                                    style="margin-bottom:1%;box-shadow: rgba(50, 50, 93, 0.25) 0px 50px 100px -20px, rgba(0, 0, 0, 0.3) 0px 30px 60px -30px, rgba(10, 37, 64, 0.35) 0px -2px 6px 0px inset;">
                                    <a href="{{ url('/ProductsDetails/' . $product->product_code) }}" class="item-image">
                                        <img src="{{ asset('MemberProducts/' . $product->product_image) }}" alt=""
                                            height="380" width="320" />

                                    </a>
                                    <div class="item-info">
                                        <h4 class="item-title">
                                            <a
                                                href="{{ url('/ProductsDetails/' . $product->product_code) }}">{{ $product->value_name }}<br /></a>
                                        </h4>
                                        <p class="item-desc">{{ $product->variety }}</p>
                                        <div class="item-price">Ksh {{ $product->unit_price }} / {{ $product->uom }}</div>

                                        <h4 class="item-title">
                                            <a title="Explore County Market Produce"
                                                href="{{ url('/Products/SearchByCounty?county_code=' . $product->county_id . '&value_chain_name=0') }}">{{ $product->county_name }}<br /></a>
                                        </h4>

                                    </div>
                                </div>
                                <?php endforeach;?>

                            </div>

                        </div>
                        <!-- END search-item-container -->
                        <!-- BEGIN pagination -->
                        <div class="text-center">
                            <ul class="pagination m-t-0">
                                {{ $chains->links() }}



                            </ul>
                        </div>
                    </div>
                    <!-- END pagination -->
                </div>
                <!-- END search-content -->
                <!-- BEGIN search-sidebar -->
                <div class="search-sidebar"
                    style="margin-bottom:1%;box-shadow: rgba(50, 50, 93, 0.25) 0px 50px 100px -20px, rgba(0, 0, 0, 0.3) 0px 30px 60px -30px, rgba(10, 37, 64, 0.35) 0px -2px 6px 0px inset;">
                    <h4 class="title">Filter By Counties</h4>
                    <form name="filter_form" action="{{ url('/Products/SearchByCounty') }}" method="GET">
                        <div class="form-group">
                            <label class="control-label">County</label>
                            <select name="county_code" class="form-control input-sm" id="County" required>
                                <option value=""> ---All Counties-----</option>
                                <?php foreach($counties as $county):?>
                                <option value="{{ $county->id }}">{{ $county->county_name }}</option>
                                <?php endforeach;?>
                            </select>

                        </div>

                        <div class="form-group">
                            <label class="control-label">Value Chain Name</label>
                            <select name="value_chain_name" class="form-control input-sm" id="ValueChainID" required>
                                <option value=""> </option>

                            </select>

                        </div>

                        <div class="m-b-30">
                            <button type="submit" style="width: 100%;background: green !important"
                                class="btn btn-sm btn-success"><i class="fa fa-search"></i> Filter</button>
                        </div>
                    </form>
                </div>



                <div class="search-sidebar"
                    style="margin-top: 1.5%;margin-bottom:1%;box-shadow: rgba(50, 50, 93, 0.25) 0px 50px 100px -20px, rgba(0, 0, 0, 0.3) 0px 30px 60px -30px, rgba(10, 37, 64, 0.35) 0px -2px 6px 0px inset;">



                    <h4 class="title m-b-0">Filter By Value Chains</h4>
                    <input type="text" class="form-control" name="search" style="width:100%;margin-top: 1%;"
                        placeholder="Search">
                    <ul class="search-category-list">

                        <?php foreach($categories as $chain):?>
                        <li><span>
                                <input type="checkbox" name="" class="group" data-groupid="<?= $chain->id ?>">

                                {{ $chain->value_name }} <span class="pull-right"></span></span></li>
                        <?php endforeach;?>
                    </ul>
                </div>
                <!-- END search-sidebar -->
            </div>
            <!-- END search-container -->
        </div>
        <!-- END container -->
    </div>
    <!-- END search-results -->
@endsection


@push('scripts')
    <script type="text/javascript">
        $("#County").on("change", function(e) {
            e.preventDefault();
            var County = $("#County").val();
            if (County.length > 0) {
                var url = "<?= url('/VCOs/getCountyPostedValuechainName') ?>";
                $.get(url, {
                    'County': County
                }, function(data) {
                    $("#ValueChainID").html(data);
                });
            }



        });
    </script>
    <script>
        var list = [];


        $(".group").on("change", function(e) {
            e.preventDefault();
            var id = $(this).attr('data-groupid');

            var groupids = new Array();
            if (this.checked) {
                var test = jQuery.inArray(id, list);
                if (test == -1) {
                    list.push(id);
                }

                console.log(list);

                updateTable(list);

            } else {



                list.splice($.inArray(id, list), 1);
                updateTable(list);




                //alert ("bye");
            }

        });





        function updateTable(list) {

            var url = "<?= url('/VCOs/getCheckProductName') ?>";

            var array_size = list.length;
            if (array_size > 0) {


                $.get(url, {
                    'groupids': list
                }, function(data) {
                    if (data == 0) {
                        $("#loadmytable").html("");


                    } else {
                        $("#loadmytable").html("");
                        $("#loadmytable").html(data);
                    }


                    //console.log(data);
                })

            } else {
                $("#loadmytable").html("");
            }

        }
    </script>
@endpush
