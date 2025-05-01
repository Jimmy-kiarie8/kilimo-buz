
<header class="bg-white shadow-md sticky top-0 z-50">
    <div class="container mx-auto px-4">
        <div class="flex justify-between items-center py-3">
            <!-- Logo -->
            <a href="/">
            <div class="flex items-center space-x-2">
                <span class="text-white text-3xl"><i class="fas fa-store"></i></span>
                <h1 class="text-2xl font-bold text-white">KILIMO BUZ</h1>
            </div>
            </a>

            <!-- Search Bar -->
            <div class="hidden md:flex items-center flex-1 max-w-xl mx-6">
                <div class="w-full relative">
                    <input type="text" placeholder="Search farm produce, brands and categories..."
                        class="w-full py-2 pl-4 pr-10 rounded-lg border border-white focus:outline-none focus:ring-2 focus:ring-green-500" style="color: #fff;">
                    <button class="absolute right-3 top-2.5 text-white">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>

            <!-- Navigation -->
            <nav class="flex items-center space-x-6">
                <!-- <a href="#" class="hidden md:block text-white hover:text-green-600"><i class="far fa-heart"></i> Favorites</a> -->

                <a href="/login" class="bg-green-600 text-white px-4 py-2 rounded-lg font-medium hover:bg-green-700 transition-colors">
                    Login
                </a>
                {{-- <a href="#" class="bg-white-200 text-white px-4 py-2 rounded-lg font-medium hover:bg-white-300 transition-colors">
                    Sell
                </a> --}}
                <button class="md:hidden text-white-700 focus:outline-none">
                    <i class="fas fa-bars text-xl"></i>
                </button>
            </nav>
        </div>
    </div>
</header>