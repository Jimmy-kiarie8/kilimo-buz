@extends('buz.layouts.layout')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <!-- Product Details Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Product Images -->
            <div class="">
                <div class="relative">
                    <img src="{{ asset('MemberProducts/' . $product->product_image) }}" alt="Product Image"
                        class="w-full h-150 object-cover rounded-lg">
                    <div class="absolute top-2 right-2">
                        <button class="bg-white rounded-full p-3 shadow-md hover:bg-gray-100 transition-colors">
                            <i class="far fa-heart text-gray-600"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Product Info -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h1 class="text-3xl font-bold text-gray-800 mb-4">{{ $product->variety }}</h1>
                {{-- <div class="flex items-center mb-6">
                <div class="flex text-yellow-400 mr-2">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star-half-alt"></i>
                </div>
                <span class="text-gray-500">(42 reviews)</span>
            </div> --}}

                <div class="space-y-4 mb-8">
                    <div class="flex items-center">
                        <i class="fas fa-list text-green-500 mr-2"></i>
                        <span class="text-gray-700">{{ $product->value_chain_name }}</span>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-map-marker-alt text-green-500 mr-2"></i>
                        <span class="text-gray-700">{{ $product->county_name }}</span>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-box text-green-500 mr-2"></i>
                        <span class="text-gray-700">Available: {{ $product->quantity_available }} {{ $product->uom }}</span>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-tag text-green-500 mr-2"></i>
                        <span class="text-gray-700">Product Code: {{ $product->product_code }}</span>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-truck text-green-500 mr-2"></i>
                        <span class="text-gray-700">Town: {{ $product->town }} {{ $product->uom }}</span>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-map text-green-500 mr-2"></i>
                        <span class="text-gray-700">Street: {{ $product->street }} {{ $product->uom }}</span>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-map text-green-500 mr-2"></i>
                        <span class="text-gray-700">VCO: {{ $product->vconame }} {{ $product->uom }}</span>
                    </div>
                    <hr style="border-color: #9999992c;">
                    <div class="flex items-center">
                        <i class="fas fa-user text-green-500 mr-2"></i>
                        <span class="text-gray-700">Seller: {{ $product->sellername }}</span>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-phone text-green-500 mr-2"></i>
                        <span class="text-gray-700">Seller Phone: <a
                                href="tel:{{ $product->sellermobilenumber }}">{{ $product->sellermobilenumber }}</a></span>
                    </div>
                </div>

                <div class="bg-gray-50 p-4 rounded-lg mb-8">
                    <p class="text-gray-600">Unit Price:</p>
                    <p class="text-3xl font-bold text-green-600">KSh {{ $product->unit_price }}</p>

                </div>

                <div class="flex space-x-4">
                    <button
                        class="flex-1 bg-white border border-green-600 text-green-600 py-3 px-6 rounded-lg hover:bg-green-50 transition-colors"
                        onclick="window.location.href='tel:{{ $product->sellermobilenumber }}'">
                        <i class="fas fa-phone-alt mr-2"></i>
                        Contact Seller
                    </button>
                    <button
                        class="flex-1 bg-white border border-green-600 text-green-600 py-3 px-6 rounded-lg hover:bg-green-50 transition-colors">
                        <i class="fas fa-mobile-alt mr-2"></i>
                        Open On App
                    </button>

                    <button
                        class="flex-1 bg-white border border-green-600 text-green-600 py-3 px-6 rounded-lg hover:bg-green-50 transition-colors"
                        onclick="window.open('https://maps.google.com/?q={{ $product->latitude }},{{ $product->longitude }}', '_blank')">
                        <i class="fas fa-map-marker-alt mr-2"></i>
                        View in map
                    </button>
                </div>

                <br>


                <div class="flex space-x-4">
                    <button class="flex-1 bg-blue-600 text-white py-3 px-6 rounded-lg hover:bg-blue-700 transition-colors"
                        onclick="window.open('https://www.facebook.com/sharer/sharer.php?u='+encodeURIComponent(window.location.href), '_blank')">
                        <i class="fab fa-facebook-f mr-2"></i>
                        Share
                    </button>
                    <button class="flex-1 bg-blue-400 text-white py-3 px-6 rounded-lg hover:bg-grey-500 transition-colors"
                        onclick="window.open('https://x.com/intent/tweet?url='+encodeURIComponent(window.location.href), '_blank')">
                        <i class="fab fa-x mr-2"></i>
                    </button>
                    <button class="flex-1 bg-green-600 text-white py-3 px-6 rounded-lg hover:bg-green-700 transition-colors"
                        onclick="window.open('https://wa.me/?text='+encodeURIComponent(window.location.href), '_blank')">
                        <i class="fab fa-whatsapp mr-2"></i>
                        WhatsApp
                    </button>
                    <button class="flex-1 bg-red-600 text-white py-3 px-6 rounded-lg hover:bg-red-500 transition-colors"
                        onclick="window.open('https://www.instagram.com/sharer/sharer.php?u='+encodeURIComponent(window.location.href), '_blank')">
                        <i class="fab fa-instagram mr-2"></i>
                        Instagram
                    </button>
                </div>
            </div>
        </div>

        <!-- Product Description Section -->
        <div class="mt-12 bg-white rounded-lg shadow-lg p-6">
            <h2 class="text-2xl font-bold text-gray-800 mb-4">Product Description</h2>
            <p class="text-gray-600 leading-relaxed">
                {{ $product->description ?? 'No description available for this product.' }}
            </p>
        </div>

        <!-- Related Products Section -->
        <div class="mt-12">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Related Products</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($relatedProducts as $related)
                    <a href="/product-detail/{{ $related->id }}">
                        <div class="bg-white rounded-lg shadow overflow-hidden group">
                            <div class="relative">
                                <img src="{{ asset('MemberProducts/' . $related->product_image) }}" alt="Related Product"
                                    class="w-full h-48 object-cover">
                                <div class="absolute top-2 right-2">
                                    <button class="bg-white rounded-full p-2 shadow-md hover:bg-gray-100 transition-colors">
                                        <i class="far fa-heart text-gray-600"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="p-4">
                                <h3 class="font-medium text-gray-800 mb-1">{{ $related->variety }}</h3>
                                <p class="text-green-600 font-bold text-lg mb-2">KSh {{ $related->unit_price }}</p>
                                <div class="flex items-center text-sm text-gray-500">
                                    <i class="fas fa-map-marker-alt mr-1"></i>
                                    <span>{{ $related->county_name }}</span>
                                </div>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>


        <!-- Location on Map Section -->
        @if ($product->latitude && $product->longitude)
            <div class="mt-12 bg-white rounded-lg shadow-lg p-6">
                <h2 class="text-2xl font-bold text-gray-800 mb-4">Location on Map</h2>


                <iframe width="100%" height="400" frameborder="0" style="border:0"
                    src="https://www.google.com/maps/embed/v1/place?key={{ env('GOOGLE_MAPS_API_KEY') }}&q={{ $product->latitude }},{{ $product->longitude }}"
                    allowfullscreen>
                </iframe>

            </div>
        @else
            <div class="mt-12 bg-white rounded-lg shadow-lg p-6">
                <h2 class="text-2xl font-bold text-gray-800 mb-4">Location on Map</h2>
                <p class="text-gray-600">No location available for this product.</p>
            </div>
        @endif
    </div>
@endsection
