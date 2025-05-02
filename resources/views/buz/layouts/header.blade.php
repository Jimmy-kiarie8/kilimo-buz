<header class="bg-white shadow-md sticky top-0 z-50">
    <div class="container mx-auto px-4">
        <div class="flex justify-between items-center py-3">
            <!-- Logo -->
            <a href="/">
            <div class="flex items-center space-x-2">
                {{-- <span class="text-white text-3xl"><i class="fas fa-store"></i></span>
                <h1 class="text-2xl font-bold text-white">KILIMO BUZ</h1> --}}
                <img src="{{ asset('imgs/logo.png') }}" alt="Kilimo Buz Logo" class="logo">
            </div>
            </a>

            <!-- Main Navigation -->
            <div class="hidden md:flex items-center space-x-6">
                <a href="/" class="text-white hover:text-green-600 font-medium">Home</a>
                <a href="/shop" class="text-white hover:text-green-600 font-medium">Shop</a>
                <a href="{{ route('wishlist') }}" class="text-white hover:text-green-600 font-medium relative">
                    <div class="flex items-center">
                        <i class="far fa-heart mr-1"></i> Wishlist
                        <span id="wishlist-count" class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center hidden">0</span>
                    </div>
                </a>
            </div>

            <!-- Search Bar -->
            <div class="hidden md:flex items-center flex-1 max-w-xl mx-6">
                <form id="search-form" action="/shop" method="GET" class="w-full">
                    <div class="w-full relative">
                        <input type="text" id="header-search" name="search" placeholder="Search farm produce, and value chains..."
                            class="w-full py-2 pl-4 pr-10 rounded-lg border border-white focus:outline-none focus:ring-2 focus:ring-green-500" style="color: #fff;">
                        <button type="submit" class="absolute right-3 top-2.5 text-white">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </form>
            </div>

            <!-- User Navigation -->
            <nav class="flex items-center space-x-6">
                <a href="/login" class="bg-green-600 text-white px-4 py-2 rounded-lg font-medium hover:bg-green-700 transition-colors">
                    Login
                </a>
                <button class="md:hidden text-white-700 focus:outline-none">
                    <i class="fas fa-bars text-xl"></i>
                </button>
            </nav>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchForm = document.getElementById('search-form');
        const searchInput = document.getElementById('header-search');

        if(searchForm) {
            searchForm.addEventListener('submit', function(e) {
                e.preventDefault();
                if(searchInput.value.trim()) {
                    window.location.href = '/shop?search=' + encodeURIComponent(searchInput.value.trim());
                }
            });
        }

        // Initialize wishlist count
        updateWishlistCount();
    });

    // Update wishlist count badge
    function updateWishlistCount() {
        const wishlist = JSON.parse(localStorage.getItem('wishlist') || '[]');
        const wishlistCount = document.getElementById('wishlist-count');

        if (wishlistCount) {
            wishlistCount.textContent = wishlist.length;

            if (wishlist.length > 0) {
                wishlistCount.classList.remove('hidden');
            } else {
                wishlistCount.classList.add('hidden');
            }
        }
    }
    </script>
</header>
