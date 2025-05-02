@extends('buz.layouts.layout')

@section('content')
    <!-- Mobile Search - Only visible on small screens -->
    <div class="md:hidden bg-white shadow-sm mb-4 px-4 py-3">
        <div class="relative">
            <input type="text" placeholder="Search farm produce, brands and categories..."
                class="w-full py-2 pl-4 pr-10 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-green-500">
            <button class="absolute right-3 top-2.5 text-gray-500">
                <i class="fas fa-search"></i>
            </button>
        </div>
    </div>

    <!-- Hero Section -->
    <section class="hero-gradient text-white py-12 mb-10">
        <div class="container mx-auto px-4">
            <div class="flex flex-col md:flex-row items-center">
                <div class="md:w-1/2 mb-8 md:mb-0">
                    <h2 class="text-4xl font-bold mb-4">KILIMO BUZ `SOKO MKONONI`</h2>
                    <p class="text-lg mb-6 text-green-100">KILIMO BUZ is an online shop for value chain actors to market
                        their farm produce free of charge. It enables buyers to access fresh produce at a mouse click unlike
                        traditional methods.

                        For Value Chain Actors to market their produce, they must be registered under a VCO and given a
                        unique identifier.</p>
                    <div class="flex flex-col sm:flex-row space-y-3 sm:space-y-0 sm:space-x-4">
                        <a href="/shop"
                            class="bg-white text-green-600 font-medium px-6 py-3 rounded-lg text-center hover:bg-gray-100 transition-colors">
                            Shop Now
                        </a>
                        <a href="#"
                            class="border border-white text-white font-medium px-6 py-3 rounded-lg text-center hover:bg-white hover:text-green-600 transition-colors">
                            Become a Seller
                        </a>
                    </div>
                    <br>

                    <div class="flex flex-col sm:flex-row space-y-3 sm:space-y-0 sm:space-x-4">
                        <a href="#"
                            class="bg-black text-white rounded-lg flex items-center justify-center px-4 py-2 hover:bg-gray-900 transition-colors">
                            <i class="fab fa-apple text-2xl mr-2"></i>
                            <div>
                                <div class="text-xs">Download on the</div>
                                <div class="font-medium">App Store</div>
                            </div>
                        </a>
                        <a href="https://play.google.com/store/apps/details?id=com.kilimobuz_2024&pcampaignid=web_share"
                            class="bg-black text-white rounded-lg flex items-center justify-center px-4 py-2 hover:bg-gray-900 transition-colors" target="_blank">
                            <i class="fab fa-google-play text-2xl mr-2"></i>
                            <div>
                                <div class="text-xs">Get it on</div>
                                <div class="font-medium">Google Play</div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="md:w-1/2">
                    <!-- Hero Image Slider -->
                    <div class="hero-slider swiper">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide">
                                <img src="https://images.pexels.com/photos/3307282/pexels-photo-3307282.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1"
                                    alt="Farmer with produce" class="rounded-lg shadow-lg">
                            </div>
                            <div class="swiper-slide">
                                <img src="https://images.pexels.com/photos/422218/pexels-photo-422218.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1"
                                    alt="People shopping online" class="rounded-lg shadow-lg">
                            </div>
                            <div class="swiper-slide">
                                <img src="https://images.pexels.com/photos/1656663/pexels-photo-1656663.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1"
                                    alt="Fresh produce" class="rounded-lg shadow-lg">
                            </div>
                        </div>
                        {{-- <div class="swiper-pagination hero-slider-pagination"></div> --}}
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Popular Categories Section -->
    <section class="container mx-auto px-4 mb-12 slider-container">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Value Chains</h2>
            <a href="#" class="text-green-600 hover:underline">View All</a>
        </div>

        <!-- Swiper Container -->
        <div class="swiper-container">
            <div class="swiper-wrapper">
                <!-- Category 1 -->
                @foreach ($chains as $item)
                    <div class="swiper-slide">
                        <div class="category-card bg-white rounded-lg shadow p-4 text-center transition-all duration-300">
                            <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-3">
                                <i class="fas fa-tractor text-green-600 text-xl"></i>
                            </div>
                            <h3 class="font-medium text-gray-800">{{ $item->value_name }}</h3>
                            <p class="text-xs text-gray-500 mt-1">{{ $item->quantity_available }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
            <!-- Add Pagination -->
            <!-- <div class="swiper-pagination"></div> -->
        </div>
    </section>

    <!-- Featured Farm Produce -->
    <section class="container mx-auto px-4 mb-12">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Featured Farm Produce</h2>
            <a href="#" class="text-green-600 hover:underline">View All</a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            <!-- Produce 1 -->
            @foreach ($featured as $item)
            <a href="/product-detail/{{ $item->id }}">
                <div class="bg-white rounded-lg shadow overflow-hidden group">
                    <div class="relative">
                        <img src="{{ asset('MemberProducts/' . $item->product_image) }}" alt="Produce image"
                            class="w-full h-48 object-cover">
                        <div class="absolute top-2 right-2">
                            <button class="bg-white rounded-full p-2 shadow-md hover:bg-gray-100 transition-colors">
                                <i class="far fa-heart text-gray-600"></i>
                            </button>
                        </div>
                    </div>
                    <div class="p-4">
                            <h3 class="font-medium text-gray-800 mb-1 group-hover:text-green-600 transition-colors">
                                {{ $item->variety }}</h3>
                                <small class="text-gray-500">
                                    {{ $item->value_name }}</small>
                        <p class="text-green-600 font-bold text-lg mb-2">KSh {{ $item->unit_price }} per {{ $item->uom }}
                        </p>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center text-sm text-gray-500">
                                <i class="fas fa-map-marker-alt mr-1"></i>
                                <span>{{ $item->county_name }}</span>
                            </div>
                            {{-- <div class="text-xs text-gray-400">Posted 2 days ago</div> --}}
                        </div>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
    </section>

    <!-- Special Offer Banner -->
    <section class="container mx-auto px-4 mb-12">
        <div class="relative rounded-xl overflow-hidden">
            <img src="https://placehold.co/1200x300" alt="Special offer" class="w-full h-64 object-cover">
            <div class="absolute inset-0 bg-gradient-to-r from-green-900/80 to-grey-900/50 flex items-center">
                <div class="px-8 max-w-lg">
                    <span
                        class="bg-yellow-500 text-yellow-900 text-xs font-bold px-3 py-1 rounded-full mb-3 inline-block">LIMITED
                        TIME</span>
                    <h3 class="text-3xl font-bold text-white mb-2">Flash Sale! Up to 70% Off</h3>
                    <p class="text-green-100 mb-4">Don't miss out on our biggest sale of the season. Fresh farm produce at
                        unbeatable prices.</p>
                    <a href="#"
                        class="bg-white text-green-600 px-6 py-2 rounded-lg font-medium inline-block hover:bg-green-50 transition-colors">
                        Shop Now
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Latest Farm Produce -->
    <section class="container mx-auto px-4 mb-12">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Latest Farm Produce</h2>
            <a href="#" class="text-green-600 hover:underline">View All</a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            <!-- Produce 1 -->
            @foreach ($latest as $item)
            <a href="/product-detail/{{ $item->id }}">
            <div class="bg-white rounded-lg shadow overflow-hidden group">
                <div class="relative">
                    <img src="{{ asset('MemberProducts/' . $item->product_image) }}" alt="Produce image" class="w-full h-48 object-cover">
                    <div class="absolute top-2 right-2">
                        <button class="bg-white rounded-full p-2 shadow-md hover:bg-gray-100 transition-colors">
                            <i class="far fa-heart text-gray-600"></i>
                        </button>
                    </div>
                </div>
                <div class="p-4">
                    <h3 class="font-medium text-gray-800 mb-1 group-hover:text-green-600 transition-colors">{{ $item->variety }}</h3>
                    <small class="text-gray-500">
                        {{ $item->value_name }}</small>
                    <p class="text-green-600 font-bold text-lg mb-2">KSh {{ $item->unit_price }} per {{ $item->uom }}</p>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center text-sm text-gray-500">
                            <i class="fas fa-map-marker-alt mr-1"></i>
                            <span>{{ $item->county_name }}</span>
                        </div>
                        {{-- <div class="text-xs text-gray-400">Posted 2 hours ago</div> --}}
                    </div>
                </div>
            </div>

        </a>
        @endforeach
    </section>



    <!-- Counties Section -->
    <section class="container mx-auto px-4 mb-12 slider-container">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Counties</h2>
            <a href="#" class="text-green-600 hover:underline">View All</a>
        </div>

        <!-- Swiper Container -->
        <div class="swiper-container">
            <div class="swiper-wrapper">
                <!-- Category 1 -->
                @foreach ($counties as $item)
                    <div class="swiper-slide">
                        <div class="category-card bg-white rounded-lg shadow p-4 text-center transition-all duration-300">
                            <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-3">
                                <i class="fas fa-map text-green-600 text-xl"></i>
                            </div>
                            <h3 class="font-medium text-gray-800">{{ $item->county_name }}</h3>
                            {{-- <p class="text-xs text-gray-500 mt-1">{{ $item->quantity_available }}</p> --}}
                        </div>
                    </div>
                @endforeach
            </div>
            <!-- Add Pagination -->
            <!-- <div class="swiper-pagination"></div> -->
        </div>
    </section>


    <!-- Why Choose Us -->
    <section class="bg-gray-100 py-12 mb-12">
        <div class="container mx-auto px-4">
            <h2 class="text-2xl font-bold text-gray-800 text-center mb-10">Why Choose KILIMO BUZ?</h2>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="bg-white rounded-lg p-6 shadow-md text-center">
                    <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-shield-alt text-green-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Safe & Secure</h3>
                    <p class="text-gray-600">All transactions are protected with our secure payment system and buyer
                        protection policy.</p>
                </div>

                <!-- Feature 2 -->
                <div class="bg-white rounded-lg p-6 shadow-md text-center">
                    <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-tag text-green-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Best Prices</h3>
                    <p class="text-gray-600">Find the best deals directly from sellers without middlemen or extra fees.</p>
                </div>

                <!-- Feature 3 -->
                <div class="bg-white rounded-lg p-6 shadow-md text-center">
                    <div class="w-16 h-16 bg-grey-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-users text-grey-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Trusted Community</h3>
                    <p class="text-gray-600">Join millions of Kenyans buying and selling with verified profiles and
                        ratings.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- App Download Section -->
    <section class="container mx-auto px-4 mb-16">
        <div class="bg-green-600 rounded-xl overflow-hidden">
            <div class="flex flex-col md:flex-row items-center">
                <div class="md:w-1/2 p-8 md:p-12">
                    <h2 class="text-3xl font-bold text-white mb-4">Download Our Mobile App</h2>
                    <p class="text-green-100 mb-6">Get the best shopping experience on the go. Browse thousands of farm
                        produce, chat with sellers, and manage your listings from anywhere.</p>
                    <div class="flex flex-col sm:flex-row space-y-3 sm:space-y-0 sm:space-x-4">
                        <a href="#"
                            class="bg-black text-white rounded-lg flex items-center justify-center px-4 py-2 hover:bg-gray-900 transition-colors">
                            <i class="fab fa-apple text-2xl mr-2"></i>
                            <div>
                                <div class="text-xs">Download on the</div>
                                <div class="font-medium">App Store</div>
                            </div>
                        </a>
                        <a href="https://play.google.com/store/apps/details?id=com.kilimobuz_2024&pcampaignid=web_share"
                            class="bg-black text-white rounded-lg flex items-center justify-center px-4 py-2 hover:bg-gray-900 transition-colors" target="_blank">
                            <i class="fab fa-google-play text-2xl mr-2"></i>
                            <div>
                                <div class="text-xs">Get it on</div>
                                <div class="font-medium">Google Play</div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="md:w-1/2">
                    <img src="https://images.pexels.com/photos/8939506/pexels-photo-8939506.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1"
                        alt="Mobile app mockup" class="w-full">
                </div>
            </div>
        </div>
    </section>

    <!-- Newsletter -->
    <section class="container mx-auto px-4 mb-16">
        <div class="bg-gray-100 rounded-xl p-8 md:p-12">
            <div class="max-w-2xl mx-auto text-center">
                <h2 class="text-2xl font-bold text-gray-800 mb-3">Subscribe for alerts</h2>
                <p class="text-gray-600 mb-6">Get the latest deals, farm produce updates and marketplace news directly to
                    your inbox.</p>
                <div class="flex flex-col space-y-3">
                    <input type="email" placeholder="Your email address"
                        class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-green-500">

                    <select class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-green-500">
                        <option value="">Select a value chain</option>
                        @foreach ($chains as $item)
                        <option value="{{ $item->value_name }}">{{ $item->value_name }}</option>
                        @endforeach
                    </select>

                    <button
                        class="w-full bg-green-600 text-white font-medium px-6 py-3 rounded-lg hover:bg-green-700 transition-colors">
                        Subscribe
                    </button>
                </div>
            </div>
        </div>
    </section>


    <!-- Popular Brands -->
    {{-- <section class="container mx-auto px-4 mb-16">
        <h2 class="text-2xl font-bold text-gray-800 text-center mb-8">Partners</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
            <div
                class="bg-white rounded-lg p-4 flex items-center justify-center border border-gray-200 hover:shadow-md transition-shadow">
                <img src="https://placehold.co/120x60" alt="Brand logo" class="h-12">
            </div>
            <div
                class="bg-white rounded-lg p-4 flex items-center justify-center border border-gray-200 hover:shadow-md transition-shadow">
                <img src="https://placehold.co/120x60" alt="Brand logo" class="h-12">
            </div>
            <div
                class="bg-white rounded-lg p-4 flex items-center justify-center border border-gray-200 hover:shadow-md transition-shadow">
                <img src="https://placehold.co/120x60" alt="Brand logo" class="h-12">
            </div>
            <div
                class="bg-white rounded-lg p-4 flex items-center justify-center border border-gray-200 hover:shadow-md transition-shadow">
                <img src="https://placehold.co/120x60" alt="Brand logo" class="h-12">
            </div>
        </div>
    </section> --}}
@endsection
