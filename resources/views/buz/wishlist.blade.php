@extends('buz.layouts.layout')

@section('content')
    <!-- Wishlist Page Content -->
    <div class="container mx-auto px-4 py-8">
        <!-- Breadcrumbs -->
        <div class="mb-6">
            <nav class="flex text-sm">
                <a href="/" class="text-gray-500 hover:text-green-600">Home</a>
                <span class="mx-2 text-gray-500">/</span>
                <a href="/wishlist" class="text-green-500 hover:text-green-600">Wishlist</a>
            </nav>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">My Wishlist</h1>
                    <p class="text-gray-500" id="wishlist-count-display">Items saved for later</p>
                </div>
                <button id="clear-wishlist" class="mt-4 md:mt-0 px-4 py-2 text-sm text-red-600 border border-red-600 rounded-lg hover:bg-red-50">
                    Clear All Items
                </button>
            </div>

            <div id="wishlist-empty" class="hidden py-20 text-center">
                <div class="w-16 h-16 mx-auto mb-4 text-gray-300">
                    <i class="far fa-heart text-5xl"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-700 mb-2">Your wishlist is empty</h3>
                <p class="text-gray-500 mb-6">Browse our shop and add items to your wishlist</p>
                <a href="/shop" class="inline-block px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                    Shop Now
                </a>
            </div>

            <div id="wishlist-items" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Items will be loaded dynamically with JavaScript -->
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            loadWishlistItems();

            // Add event listener to clear wishlist button
            document.getElementById('clear-wishlist').addEventListener('click', function() {
                if (confirm('Are you sure you want to clear all items from your wishlist?')) {
                    localStorage.removeItem('wishlist');
                    loadWishlistItems();
                }
            });
        });

        function loadWishlistItems() {
            const wishlist = JSON.parse(localStorage.getItem('wishlist') || '[]');
            const wishlistItems = document.getElementById('wishlist-items');
            const wishlistEmpty = document.getElementById('wishlist-empty');
            const wishlistCountDisplay = document.getElementById('wishlist-count-display');

            // Update count display
            wishlistCountDisplay.textContent = wishlist.length === 1
                ? '1 item saved for later'
                : `${wishlist.length} items saved for later`;

            // Show empty state or items
            if (wishlist.length === 0) {
                wishlistEmpty.classList.remove('hidden');
                wishlistItems.classList.add('hidden');
                return;
            } else {
                wishlistEmpty.classList.add('hidden');
                wishlistItems.classList.remove('hidden');
            }

            // Clear existing items
            wishlistItems.innerHTML = '';

            // Sort by most recently added
            wishlist.sort((a, b) => new Date(b.addedAt) - new Date(a.addedAt));

            // Add each item to the grid
            wishlist.forEach(item => {
                const div = document.createElement('div');
                div.className = 'bg-white border border-gray-200 rounded-lg overflow-hidden shadow-sm hover:shadow-md transition-shadow';
                div.innerHTML = `
                    <div class="relative">
                        <img src="${item.image}" alt="${item.name}"
                            class="w-full h-48 object-cover">
                        <button class="remove-item absolute top-2 right-2 bg-white rounded-full p-2 shadow-md hover:bg-gray-100 transition-colors"
                            data-id="${item.id}">
                            <i class="fas fa-trash-alt text-red-500"></i>
                        </button>
                    </div>
                    <div class="p-4">
                        <h3 class="font-medium text-gray-800 mb-1">${item.name}</h3>
                        <p class="text-green-600 font-bold text-lg mb-3">KSh ${item.price}</p>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center text-sm text-gray-500">
                                <i class="fas fa-map-marker-alt mr-1"></i>
                                <span>${item.location}</span>
                            </div>
                            <a href="/product-detail/${item.id}"
                                class="bg-green-600 text-white text-sm px-3 py-1 rounded hover:bg-green-700 transition-colors">
                                View Product
                            </a>
                        </div>
                        <div class="text-xs text-gray-500 mt-3">
                            Added on ${new Date(item.addedAt).toLocaleDateString()}
                        </div>
                    </div>
                `;

                // Add event listener to remove button
                div.querySelector('.remove-item').addEventListener('click', function() {
                    removeFromWishlist(item.id);
                });

                wishlistItems.appendChild(div);
            });
        }

        function removeFromWishlist(id) {
            let wishlist = JSON.parse(localStorage.getItem('wishlist') || '[]');
            wishlist = wishlist.filter(item => item.id !== id);
            localStorage.setItem('wishlist', JSON.stringify(wishlist));

            // Show toast
            showToast('Item removed from wishlist');

            // Reload items
            loadWishlistItems();
        }

        function showToast(message) {
            // Create toast element if it doesn't exist
            let toast = document.getElementById('toast-notification');

            if (!toast) {
                toast = document.createElement('div');
                toast.id = 'toast-notification';
                toast.className = 'fixed bottom-4 right-4 bg-green-600 text-white px-4 py-2 rounded-lg shadow-lg transform transition-transform duration-300 ease-in-out translate-y-20 opacity-0';
                document.body.appendChild(toast);
            }

            // Set message and show toast
            toast.textContent = message;
            toast.classList.remove('translate-y-20', 'opacity-0');

            // Hide toast after 3 seconds
            setTimeout(() => {
                toast.classList.add('translate-y-20', 'opacity-0');
            }, 3000);
        }
    </script>
@endsection
