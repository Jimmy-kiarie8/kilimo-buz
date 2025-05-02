@extends('buz.layouts.layout')

@section('content')
    <!-- Mobile Search - Only visible on small screens -->
    <div class="md:hidden bg-white shadow-sm mb-4 px-4 py-3">
        <div class="relative">
            <input type="text" placeholder="Search products, brands and categories..."
                class="w-full py-2 pl-4 pr-10 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-green-500">
            <button class="absolute right-3 top-2.5 text-gray-500">
                <i class="fas fa-search"></i>
            </button>
        </div>
    </div>

    <!-- Shop Page Content -->
    <div class="container mx-auto px-4 py-8">
        <!-- Breadcrumbs -->
        <div class="mb-6">
            <nav class="flex text-sm">
                <a href="/" class="text-gray-500 hover:text-green-600">Home</a>
                <span class="mx-2 text-gray-500">/</span>
                <a href="/shop" class="text-green-500 hover:text-green-600">Shop</a>
            </nav>
        </div>

        <!-- Mobile Filter Toggle -->
        <div class="md:hidden mb-4">
            <button id="mobile-filter-toggle"
                class="w-full bg-white border border-gray-300 text-gray-700 font-medium px-4 py-2 rounded-lg flex items-center justify-center">
                <i class="fas fa-filter mr-2"></i> Filter Products
            </button>
        </div>

        <div class="flex flex-col md:flex-row gap-6">
            <!-- Sidebar Filter -->
            <div id="filter-sidebar" class="hidden md:block w-full md:w-64 bg-white rounded-lg shadow p-4 md:sticky md:top-4 md:h-screen md:overflow-y-auto">
                <!-- Filter Header -->
                <div class="flex justify-between items-center mb-4">
                    <h3 class="font-semibold text-gray-800">Filters</h3>
                    <a id="reset-filters" class="text-sm text-green-600 hover:underline" href="/shop">Reset All</a>
                </div>

                <!-- Value Chains -->
                <div class="border-b pb-4 mb-4">
                    <h3 class="text-lg font-semibold mb-2">Value Chains</h3>
                    <div id="value-chains-container" class="space-y-2">
                        <div class="flex items-center">
                            <div class="animate-pulse bg-gray-200 h-5 w-5 mr-2 rounded"></div>
                            <div class="animate-pulse bg-gray-200 h-5 w-32 rounded"></div>
                        </div>
                        <div class="flex items-center">
                            <div class="animate-pulse bg-gray-200 h-5 w-5 mr-2 rounded"></div>
                            <div class="animate-pulse bg-gray-200 h-5 w-28 rounded"></div>
                        </div>
                        <div class="flex items-center">
                            <div class="animate-pulse bg-gray-200 h-5 w-5 mr-2 rounded"></div>
                            <div class="animate-pulse bg-gray-200 h-5 w-24 rounded"></div>
                        </div>
                    </div>
                    <div id="value-chains-show-more" class="hidden mt-2">
                        <button class="text-green-600 text-sm font-medium hover:text-green-700 focus:outline-none">
                            Show More
                        </button>
                    </div>
                </div>

                <!-- Price Range -->
                {{-- <div class="border-b border-gray-200 pb-4 mb-4">
                    <h4 class="font-medium text-gray-700 mb-3">Price Range</h4>
                    <div class="mb-4">
                        <input type="range" min="0" max="200000" value="100000" id="price-slider"
                            class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer price-range">
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-600">KSh 0</span>
                        <span class="text-sm text-gray-600">KSh 200,000</span>
                    </div>
                    <div class="flex items-center mt-3 space-x-2">
                        <input type="text" id="min-price" placeholder="Min" value="0"
                            class="w-full px-2 py-1 border border-gray-300 rounded-md text-sm">
                        <span class="text-gray-500">-</span>
                        <input type="text" id="max-price" placeholder="Max" value="200000"
                            class="w-full px-2 py-1 border border-gray-300 rounded-md text-sm">
                        <button id="price-go" class="bg-gray-200 text-gray-700 px-2 py-1 rounded text-sm">Go</button>
                    </div>
                </div> --}}

                <!-- Condition -->
                {{-- <div class="border-b border-gray-200 pb-4 mb-4">
                    <h4 class="font-medium text-gray-700 mb-3">Condition</h4>
                    <div class="space-y-2">
                        <div class="flex items-center">
                            <input type="checkbox" id="cond-new" class="mr-2">
                            <label for="cond-new" class="cursor-pointer text-gray-600 hover:text-green-600">
                                New
                            </label>
                        </div>
                        <div class="flex items-center">
                            <input type="checkbox" id="cond-used" class="mr-2">
                            <label for="cond-used" class="cursor-pointer text-gray-600 hover:text-green-600">
                                Used - Like New
                            </label>
                        </div>
                        <div class="flex items-center">
                            <input type="checkbox" id="cond-fair" class="mr-2">
                            <label for="cond-fair" class="cursor-pointer text-gray-600 hover:text-green-600">
                                Used - Fair
                            </label>
                        </div>
                    </div>
                </div> --}}

                <!-- Counties -->
                <div class="border-b pb-4 mb-4">
                    <h3 class="text-lg font-semibold mb-2">Counties</h3>
                    <div id="counties-container" class="space-y-2">
                        <div class="flex items-center">
                            <div class="animate-pulse bg-gray-200 h-5 w-5 mr-2 rounded"></div>
                            <div class="animate-pulse bg-gray-200 h-5 w-32 rounded"></div>
                        </div>
                        <div class="flex items-center">
                            <div class="animate-pulse bg-gray-200 h-5 w-5 mr-2 rounded"></div>
                            <div class="animate-pulse bg-gray-200 h-5 w-28 rounded"></div>
                        </div>
                        <div class="flex items-center">
                            <div class="animate-pulse bg-gray-200 h-5 w-5 mr-2 rounded"></div>
                            <div class="animate-pulse bg-gray-200 h-5 w-24 rounded"></div>
                        </div>
                    </div>
                    <div id="counties-show-more" class="hidden mt-2">
                        <button class="text-green-600 text-sm font-medium hover:text-green-700 focus:outline-none">
                            Show More
                        </button>
                    </div>
                </div>

                <!-- Apply Filters Button -->
                <div>
                    <button id="apply-filters"
                        class="w-full bg-green-600 text-white font-medium py-2 rounded-lg hover:bg-green-700 transition-colors">
                        Apply Filters
                    </button>
                </div>
            </div>

            <!-- Product Listing -->
            <div class="flex-1">
                <!-- Top Bar -->
                <div class="bg-white rounded-lg shadow p-4 mb-6">
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center">
                        <div class="mb-4 md:mb-0">
                            <h2 class="text-xl font-bold text-gray-800">Shop</h2>
                            <p class="text-sm text-gray-500" id="products-count">Showing 1-12 of {{ count($products) }} products</p>
                        </div>

                        {{-- Indicate if search is active --}}


                        <div class="flex flex-col sm:flex-row w-full md:w-auto space-y-3 sm:space-y-0 sm:space-x-4">
                            <div class="w-full sm:w-48">
                                <select id="sort-by"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-white focus:outline-none focus:ring-2 focus:ring-green-500">
                                    <option value="featured">Sort by: Featured</option>
                                    <option value="price_asc">Price: Low to High</option>
                                    <option value="price_desc">Price: High to Low</option>
                                    <option value="newest">Newest First</option>
                                    <option value="oldest">Oldest First</option>
                                    <option value="popular">Most Popular</option>
                                </select>
                            </div>
                            {{-- <div class="w-full sm:w-32">
                                <select id="per-page"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-white focus:outline-none focus:ring-2 focus:ring-green-500">
                                    <option value="12">12 per page</option>
                                    <option value="24">24 per page</option>
                                    <option value="36">36 per page</option>
                                    <option value="48">48 per page</option>
                                </select>
                            </div> --}}
                        </div>
                    </div>
                </div>

                {{-- Indicate if search is active --}}
                @if (request()->has('search'))
                <div class="bg-grey-900 text-center py-4 lg:px-4">
                    <div class="p-2 bg-green-700 items-center text-green-100 leading-none lg:rounded-full flex lg:inline-flex" role="alert">
                        <span class="flex rounded-full bg-green-500 uppercase px-2 py-1 text-xs font-bold mr-3">Search</span>
                        <span class="font-semibold mr-2 text-left flex-auto">Search results for: {{ request()->get('search') }}</span>
                        <button class="text-sm text-green-100 hover:text-green-300" id="clear-search" onclick="removeSearchParameterFromUrl()">Clear Search</button>
                    </div>
                </div>
                @endif

                <!-- Products Grid -->
                <div id="products-grid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($products as $product)
                    <!-- Product Card -->
                    <a href="{{ route('product-detail', $product->id) }}">
                    <div class="bg-white rounded-lg shadow overflow-hidden group product-card">
                        <div class="relative">
                            <img src="{{ asset('MemberProducts/' . $product->product_image) }}" alt="Product image" class="w-full h-48 object-cover">
                            <div class="absolute top-2 right-2">
                                <button class="bg-white rounded-full p-2 shadow-md hover:bg-gray-100 transition-colors">
                                    <i class="far fa-heart text-gray-600"></i>
                                </button>
                            </div>
                            @if ($product->created_at > now()->subDays(30))
                            <div class="absolute top-0 left-0 bg-green-500 text-white text-xs font-medium px-2 py-1">
                                NEW
                            </div>
                            @endif
                        </div>
                        <div class="p-4">
                            <h3 class="font-medium text-gray-800 mb-1 group-hover:text-green-600 transition-colors">{{ $product->variety }}</h3>
                            <p class="text-green-600 font-bold text-lg mb-2">KSh {{ $product->unit_price }}</p>
                            <div class="flex items-center mb-2">
                                <div class="flex text-yellow-400">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star-half-alt"></i>
                                </div>
                                <span class="text-xs text-gray-500 ml-1">(42)</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center text-sm text-gray-500">
                                    <i class="fas fa-map-marker-alt mr-1"></i>
                                    <span>{{ $product->county_name }}</span>
                                </div>
                                <button
                                    class="bg-green-600 text-white text-sm px-3 py-1 rounded hover:bg-green-700 transition-colors">
                                    View Details
                                </button>
                            </div>
                        </div>
                    </div>
                    </a>
                    @endforeach
                </div>

                <div class="mt-6" id="pagination-container">
                    {{ $products->links() }}
                </div>
            </div>
        </div>
    </div>

    <script>
        console.log('Direct script loaded!');

        // Helper functions
        function addValueChain(container, valueChain) {
            const div = document.createElement('div');
            div.className = 'flex items-center';
            div.innerHTML = `
                <input type="checkbox" id="valuechain-${valueChain.ValueChainId}" class="mr-2" value="${valueChain.ValueChainId}">
                <label for="valuechain-${valueChain.ValueChainId}" class="cursor-pointer text-gray-600 hover:text-green-600">
                    ${valueChain.ValueChainName}
                </label>
            `;
            container.appendChild(div);
        }
        function removeSearchParameterFromUrl() {
            const urlParams = new URLSearchParams(window.location.search);
            urlParams.delete('search');
            window.history.pushState({}, '', window.location.pathname + '?' + urlParams.toString());

            // Clear the search alert HTML
            const searchAlert = document.querySelector('.bg-grey-900.text-center');
            if (searchAlert) {
                searchAlert.remove();
            }

            // get all the products
            filterProducts();
        }

        function addCounty(container, county) {
            // Check if county has valid data
            if (!county || !county.CountyId || !county.CountyName) {
                console.error('Invalid county data:', county);
                return;
            }

            // Make sure CountyName is a string
            const countyName = String(county.CountyName || '').trim();
            if (!countyName) {
                console.error('County has empty name:', county);
                return;
            }

            const div = document.createElement('div');
            div.className = 'flex items-center';
            div.innerHTML = `
                <input type="checkbox" id="county-${county.CountyId}" class="mr-2" value="${county.CountyId}">
                <label for="county-${county.CountyId}" class="cursor-pointer text-gray-600 hover:text-green-600">
                    ${countyName}
                </label>
            `;
            container.appendChild(div);
        }

        // Wait for DOM to be fully loaded before doing anything
        document.addEventListener('DOMContentLoaded', function() {
            console.log('DOM fully loaded');

            // Now test the API and load data
            testApiAndLoadData();
        });

        function testApiAndLoadData() {
            // Test API connectivity with a simple endpoint
            fetch('/api/V1/GetValueChains', {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
                .then(response => {
                    console.log('Test API Response Status:', response.status);
                    return response.json();
                })
                .then(data => {
                    console.log('Test API Response:', data);
                    if (data.success) {
                        console.log('API connection is working!');
                        // If test is successful, continue with main API calls
                        loadDataAfterTest();
                    } else {
                        console.error('API test not successful:', data);
                        document.getElementById('value-chains-container').innerHTML = '<div class="text-red-500">Error connecting to API</div>';
                        document.getElementById('counties-container').innerHTML = '<div class="text-red-500">Error connecting to API</div>';
                    }
                })
                .catch(error => {
                    console.error('Test API Error:', error);
                    document.getElementById('value-chains-container').innerHTML = '<div class="text-red-500">Error connecting to API</div>';
                    document.getElementById('counties-container').innerHTML = '<div class="text-red-500">Error connecting to API</div>';
                });
        }

        function loadDataAfterTest() {
            console.log('Loading data after successful API test');

            // DIRECT VALUE CHAIN POPULATION - bypass the loadValueChains function
            console.log('Starting direct value chain population');

            fetch('/api/V1/GetValueChains', {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
                .then(response => response.json())
                .then(data => {
                    console.log('Direct population - value chains data:', data);

                    if (data.success && data.valuechains_list && Array.isArray(data.valuechains_list)) {
                        const container = document.getElementById('value-chains-container');
                        const showMoreBtn = document.getElementById('value-chains-show-more');

                        if (!container) {
                            console.error('Cannot find value-chains-container');
                            return;
                        }

                        // Clear the container
                        container.innerHTML = '';

                        // Add "All" option
                        const allDiv = document.createElement('div');
                        allDiv.className = 'flex items-center';
                        allDiv.innerHTML = `
                            <input type="checkbox" id="valuechain-all" class="mr-2" checked>
                            <label for="valuechain-all" class="cursor-pointer text-gray-600 hover:text-green-600">
                                All Value Chains
                            </label>
                        `;
                        container.appendChild(allDiv);

                        // Store all value chains
                        const allValueChains = data.valuechains_list;

                        // Show only first 10 initially
                        const initialValueChains = allValueChains.slice(0, 10);
                        const remainingValueChains = allValueChains.slice(10);

                        // Add the initial value chains
                        initialValueChains.forEach(valueChain => {
                            addValueChain(container, valueChain);
                        });

                        // If there are more than 10 value chains, show the "Show More" button
                        if (remainingValueChains.length > 0 && showMoreBtn) {
                            showMoreBtn.classList.remove('hidden');
                            const button = showMoreBtn.querySelector('button');
                            if (button) {
                                button.textContent = `Show More (${remainingValueChains.length})`;
                                button.addEventListener('click', function() {
                                    // Add the remaining value chains
                                    remainingValueChains.forEach(valueChain => {
                                        addValueChain(container, valueChain);
                                    });

                                    // Hide the "Show More" button
                                    showMoreBtn.classList.add('hidden');
                                });
                            }
                        }

                        console.log('Value chains populated directly:', data.valuechains_list.length);
                    } else {
                        console.error('Failed to populate value chains directly:', data);
                        createFallbackValueChains();
                    }
                })
                .catch(error => {
                    console.error('Error in direct value chain population:', error);
                    createFallbackValueChains();
                });

            // DIRECT COUNTIES POPULATION - bypass the loadCounties function
            console.log('Starting direct counties population');

            fetch('/api/V1/GetCounties', {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
                .then(response => response.json())
                .then(data => {
                    console.log('Direct population - counties data:', data);

                    if (data.success && data.counties_list && Array.isArray(data.counties_list)) {
                        const container = document.getElementById('counties-container');
                        const showMoreBtn = document.getElementById('counties-show-more');

                        if (!container) {
                            console.error('Cannot find counties-container');
                            return;
                        }

                        // Clear the container
                        container.innerHTML = '';

                        // Add "All" option
                        const allDiv = document.createElement('div');
                        allDiv.className = 'flex items-center';
                        allDiv.innerHTML = `
                            <input type="checkbox" id="county-all" class="mr-2" checked>
                            <label for="county-all" class="cursor-pointer text-gray-600 hover:text-green-600">
                                All Counties
                            </label>
                        `;
                        container.appendChild(allDiv);

                        // Store all counties
                        const allCounties = data.counties_list.filter(county =>
                            county && county.CountyId && county.CountyName && county.CountyName.trim() !== '');

                        if (allCounties.length === 0) {
                            // No valid counties found
                            const noCountiesDiv = document.createElement('div');
                            noCountiesDiv.className = 'text-sm text-gray-500 mt-2';
                            noCountiesDiv.textContent = 'No counties available';
                            container.appendChild(noCountiesDiv);

                            if (showMoreBtn) {
                                showMoreBtn.classList.add('hidden');
                            }
                            return;
                        }

                        // Show only first 10 initially
                        const initialCounties = allCounties.slice(0, 10);
                        const remainingCounties = allCounties.slice(10);

                        // Add the initial counties
                        initialCounties.forEach(county => {
                            addCounty(container, county);
                        });

                        // If there are more than 10 counties, show the "Show More" button
                        if (remainingCounties.length > 0 && showMoreBtn) {
                            showMoreBtn.classList.remove('hidden');
                            const button = showMoreBtn.querySelector('button');
                            if (button) {
                                button.textContent = `Show More (${remainingCounties.length})`;
                                button.addEventListener('click', function() {
                                    // Add the remaining counties
                                    remainingCounties.forEach(county => {
                                        addCounty(container, county);
                                    });

                                    // Hide the "Show More" button
                                    showMoreBtn.classList.add('hidden');
                                });
                            }
                        } else if (showMoreBtn) {
                            showMoreBtn.classList.add('hidden');
                        }

                        console.log('Counties populated directly:', allCounties.length);
                    } else {
                        console.error('Failed to populate counties directly:', data);
                        createFallbackCounties();
                    }
                })
                .catch(error => {
                    console.error('Error in direct counties population:', error);
                    createFallbackCounties();
                });

            // Initialize event listeners and filters
            initializeFilterElements();
        }

        function initializeFilterElements() {
            console.log('Initializing filter elements');

            // Add event listeners to the value chain checkboxes
            const valueChainContainer = document.getElementById('value-chains-container');
            if (valueChainContainer) {
                valueChainContainer.addEventListener('change', function(e) {
                    if (e.target.type === 'checkbox') {
                        if (e.target.id === 'valuechain-all') {
                            // If "All" is checked, uncheck all other value chains
                            if (e.target.checked) {
                                const valueChainCheckboxes = document.querySelectorAll('#value-chains-container input[type="checkbox"]:not(#valuechain-all)');
                                valueChainCheckboxes.forEach(checkbox => {
                                    checkbox.checked = false;
                                });

                                // Reload all counties
                                loadAllCounties();
                            } else {
                                // If "All" is unchecked, make sure at least one value chain is selected
                                const valueChainCheckboxes = document.querySelectorAll('#value-chains-container input[type="checkbox"]:not(#valuechain-all):checked');
                                if (valueChainCheckboxes.length === 0) {
                                    // If no other value chains are checked, keep "All" checked
                                    e.target.checked = true;

                                    // Reload all counties
                                    loadAllCounties();
                                }
                            }
                        } else {
                            // If any other value chain is checked, uncheck "All"
                            const valueChainAll = document.getElementById('valuechain-all');
                            if (valueChainAll && e.target.checked) {
                                valueChainAll.checked = false;
                            }

                            // If no specific value chains are checked, check "All"
                            const valueChainCheckboxes = document.querySelectorAll('#value-chains-container input[type="checkbox"]:not(#valuechain-all):checked');
                            if (valueChainCheckboxes.length === 0) {
                                if (valueChainAll) {
                                    valueChainAll.checked = true;

                                    // Reload all counties
                                    loadAllCounties();
                                }
                            } else {
                                // Get selected value chains and update counties
                                const selectedValueChains = [];
                                valueChainCheckboxes.forEach(checkbox => {
                                    selectedValueChains.push(checkbox.value);
                                });

                                // Fetch counties by value chains
                                if (selectedValueChains.length > 0) {
                                    fetchCountiesByValueChains(selectedValueChains);
                                }
                            }
                        }

                        // Filter products
                        filterProducts();
                    }
                });
            }

            // Add event listeners to the county checkboxes
            const countiesContainer = document.getElementById('counties-container');
            if (countiesContainer) {
                countiesContainer.addEventListener('change', function(e) {
                    if (e.target.type === 'checkbox') {
                        if (e.target.id === 'county-all') {
                            // If "All" is checked, uncheck all other counties
                            if (e.target.checked) {
                                const countyCheckboxes = document.querySelectorAll('#counties-container input[type="checkbox"]:not(#county-all)');
                                countyCheckboxes.forEach(checkbox => {
                                    checkbox.checked = false;
                                });
                            } else {
                                // If "All" is unchecked, make sure at least one county is selected
                                const countyCheckboxes = document.querySelectorAll('#counties-container input[type="checkbox"]:not(#county-all):checked');
                                if (countyCheckboxes.length === 0) {
                                    // If no other counties are checked, keep "All" checked
                                    e.target.checked = true;
                                }
                            }
                        } else {
                            // If any other county is checked, uncheck "All"
                            const countyAll = document.getElementById('county-all');
                            if (countyAll && e.target.checked) {
                                countyAll.checked = false;
                            }

                            // If no specific counties are checked, check "All"
                            const countyCheckboxes = document.querySelectorAll('#counties-container input[type="checkbox"]:not(#county-all):checked');
                            if (countyCheckboxes.length === 0) {
                                if (countyAll) {
                                    countyAll.checked = true;
                                }
                            }
                        }

                        // Filter products
                        filterProducts();
                    }
                });
            }

            // Add event listener to the sort select
            const sortSelect = document.getElementById('sort-by');
            if (sortSelect) {
                sortSelect.addEventListener('change', function() {
                    filterProducts();
                });
            }

            // Set up price range inputs
            const minPriceInput = document.getElementById('min-price');
            const maxPriceInput = document.getElementById('max-price');

            // Add event listeners for price inputs
            if (minPriceInput) {
                minPriceInput.addEventListener('input', function() {
                    // Ensure min price doesn't exceed max price if max price is set
                    if (maxPriceInput && maxPriceInput.value && parseInt(this.value) > parseInt(maxPriceInput.value)) {
                        this.value = maxPriceInput.value;
                    }
                });

                minPriceInput.addEventListener('change', function() {
                    filterProducts();
                });
            }

            if (maxPriceInput) {
                maxPriceInput.addEventListener('input', function() {
                    // Ensure max price isn't less than min price if min price is set
                    if (minPriceInput && minPriceInput.value && parseInt(this.value) < parseInt(minPriceInput.value)) {
                        this.value = minPriceInput.value;
                    }
                });

                maxPriceInput.addEventListener('change', function() {
                    filterProducts();
                });
            }

            // Add event listener to the search input
            const searchInput = document.getElementById('search-input');
            let searchTimeout;

            if (searchInput) {
                searchInput.addEventListener('input', function() {
                    // Clear previous timeout
                    clearTimeout(searchTimeout);

                    // Set new timeout to filter products after typing stops
                    searchTimeout = setTimeout(function() {
                        filterProducts();
                    }, 500); // Wait 500ms after user stops typing
                });

                // Add event listener for the search form to prevent default submission
                const searchForm = document.getElementById('search-form');
                if (searchForm) {
                    searchForm.addEventListener('submit', function(e) {
                        e.preventDefault();
                        filterProducts();
                    });
                }
            }

            // Add event listener to toggle mobile filter sidebar
            const toggleFilterBtn = document.getElementById('toggle-filter-btn');
            const filterSidebar = document.getElementById('filter-sidebar');
            const closeFilterBtn = document.getElementById('close-filter-btn');

            if (toggleFilterBtn && filterSidebar) {
                toggleFilterBtn.addEventListener('click', function() {
                    filterSidebar.classList.toggle('translate-x-0');
                    filterSidebar.classList.toggle('-translate-x-full');
                });
            }

            if (closeFilterBtn && filterSidebar) {
                closeFilterBtn.addEventListener('click', function() {
                    filterSidebar.classList.remove('translate-x-0');
                    filterSidebar.classList.add('-translate-x-full');
                });
            }

            // Load initial products
            filterProducts();
        }

        // Function to load all counties
        function loadAllCounties() {
            console.log('Loading all counties');

            const container = document.getElementById('counties-container');
            const showMoreBtn = document.getElementById('counties-show-more');

            if (!container) {
                console.error('Cannot find counties-container');
                return;
            }

            // Show loading indicators
            container.innerHTML = `
                <div class="flex items-center">
                    <div class="animate-pulse bg-gray-200 h-5 w-5 mr-2 rounded"></div>
                    <div class="animate-pulse bg-gray-200 h-5 w-32 rounded"></div>
                </div>
                <div class="flex items-center">
                    <div class="animate-pulse bg-gray-200 h-5 w-5 mr-2 rounded"></div>
                    <div class="animate-pulse bg-gray-200 h-5 w-28 rounded"></div>
                </div>
            `;

            // Fetch all counties
            fetch('/api/V1/GetCounties', {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                console.log('All counties data:', data);

                if (data.success && data.counties_list && Array.isArray(data.counties_list)) {
                    // Clear the container
                    container.innerHTML = '';

                    // Add "All" option
                    const allDiv = document.createElement('div');
                    allDiv.className = 'flex items-center';
                    allDiv.innerHTML = `
                        <input type="checkbox" id="county-all" class="mr-2" checked>
                        <label for="county-all" class="cursor-pointer text-gray-600 hover:text-green-600">
                            All Counties
                        </label>
                    `;
                    container.appendChild(allDiv);

                    // Store all counties
                    const allCounties = data.counties_list;

                    // Show only first 10 initially
                    const initialCounties = allCounties.slice(0, 10);
                    const remainingCounties = allCounties.slice(10);

                    // Add the initial counties
                    initialCounties.forEach(county => {
                        addCounty(container, county);
                    });

                    // If there are more than 10 counties, show the "Show More" button
                    if (remainingCounties.length > 0 && showMoreBtn) {
                        showMoreBtn.classList.remove('hidden');
                        const button = showMoreBtn.querySelector('button');
                        if (button) {
                            button.textContent = `Show More (${remainingCounties.length})`;
                            button.addEventListener('click', function() {
                                // Add the remaining counties
                                remainingCounties.forEach(county => {
                                    addCounty(container, county);
                                });

                                // Hide the "Show More" button
                                showMoreBtn.classList.add('hidden');
                            });
                        }
                    } else if (showMoreBtn) {
                        showMoreBtn.classList.add('hidden');
                    }

                    console.log('All counties loaded:', data.counties_list.length);
                } else {
                    console.error('Failed to load all counties:', data);
                    createFallbackCounties();
                }
            })
            .catch(error => {
                console.error('Error loading all counties:', error);
                createFallbackCounties();
            });
        }

        // Function to fetch counties by value chains
        function fetchCountiesByValueChains(valueChainIds) {
            console.log('Fetching counties by value chains:', valueChainIds);

            const container = document.getElementById('counties-container');
            const showMoreBtn = document.getElementById('counties-show-more');

            if (!container) {
                console.error('Cannot find counties-container');
                return;
            }

            // Show loading indicators
            container.innerHTML = `
                <div class="flex items-center">
                    <div class="animate-pulse bg-gray-200 h-5 w-5 mr-2 rounded"></div>
                    <div class="animate-pulse bg-gray-200 h-5 w-32 rounded"></div>
                </div>
                <div class="flex items-center">
                    <div class="animate-pulse bg-gray-200 h-5 w-5 mr-2 rounded"></div>
                    <div class="animate-pulse bg-gray-200 h-5 w-28 rounded"></div>
                </div>
            `;

            // Create the API URL
            const idsParam = valueChainIds.join(',');
            const url = `/api/V1/getCountyByValueChains/${idsParam}`;

            console.log('Fetching counties URL:', url);

            // Fetch counties by value chains
            fetch(url, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                },
                method: 'GET'
            })
            .then(response => response.json())
            .then(data => {
                console.log('Counties by value chains data:', data);

                // Clear the container
                container.innerHTML = '';

                // Add "All" option
                const allDiv = document.createElement('div');
                allDiv.className = 'flex items-center';
                allDiv.innerHTML = `
                    <input type="checkbox" id="county-all" class="mr-2" checked>
                    <label for="county-all" class="cursor-pointer text-gray-600 hover:text-green-600">
                        All Counties
                    </label>
                `;
                container.appendChild(allDiv);

                // Check if we got an error response
                if (data.success === false) {
                    const errorDiv = document.createElement('div');
                    errorDiv.className = 'text-sm text-gray-500 mt-2';
                    errorDiv.textContent = data.message || 'No counties found for the selected value chains';
                    container.appendChild(errorDiv);

                    if (showMoreBtn) {
                        showMoreBtn.classList.add('hidden');
                    }
                    return;
                }

                // Check if the response is an array and has items
                if (Array.isArray(data) && data.length > 0) {
                    // Store all counties
                    const allCounties = data;

                    // Show only first 10 initially
                    const initialCounties = allCounties.slice(0, 10);
                    const remainingCounties = allCounties.slice(10);

                    // Add the initial counties
                    initialCounties.forEach(county => {
                        if (county && county.CountyId && county.CountyName) {
                            addCounty(container, county);
                        }
                    });

                    // If there are more than 10 counties, show the "Show More" button
                    if (remainingCounties.length > 0 && showMoreBtn) {
                        showMoreBtn.classList.remove('hidden');
                        const button = showMoreBtn.querySelector('button');
                        if (button) {
                            button.textContent = `Show More (${remainingCounties.length})`;
                            button.addEventListener('click', function() {
                                // Add the remaining counties
                                remainingCounties.forEach(county => {
                                    if (county && county.CountyId && county.CountyName) {
                                        addCounty(container, county);
                                    }
                                });

                                // Hide the "Show More" button
                                showMoreBtn.classList.add('hidden');
                            });
                        }
                    } else if (showMoreBtn) {
                        showMoreBtn.classList.add('hidden');
                    }

                    console.log('Counties by value chains loaded:', allCounties.length);
                } else {
                    // No counties found or empty array
                    const noCountiesDiv = document.createElement('div');
                    noCountiesDiv.className = 'text-sm text-gray-500 mt-2';
                    noCountiesDiv.textContent = 'No counties found for the selected value chains';
                    container.appendChild(noCountiesDiv);

                    if (showMoreBtn) {
                        showMoreBtn.classList.add('hidden');
                    }
                }
            })
            .catch(error => {
                console.error('Error loading counties by value chains:', error);

                // Clear the container
                container.innerHTML = '';

                // Add "All" option
                const allDiv = document.createElement('div');
                allDiv.className = 'flex items-center';
                allDiv.innerHTML = `
                    <input type="checkbox" id="county-all" class="mr-2" checked>
                    <label for="county-all" class="cursor-pointer text-gray-600 hover:text-green-600">
                        All Counties
                    </label>
                `;
                container.appendChild(allDiv);

                // Show error message
                const errorDiv = document.createElement('div');
                errorDiv.className = 'text-sm text-red-500 mt-2';
                errorDiv.textContent = 'Error loading counties. Please try again.';
                container.appendChild(errorDiv);

                if (showMoreBtn) {
                    showMoreBtn.classList.add('hidden');
                }
            });
        }

        // Fallback functions when API fails
        function createFallbackValueChains() {
            console.log('Creating fallback value chains');

            const container = document.getElementById('value-chains-container');
            if (!container) return;

            // Clear the container
            container.innerHTML = '';

            // Add "All" option
            const allDiv = document.createElement('div');
            allDiv.className = 'flex items-center';
            allDiv.innerHTML = `
                <input type="checkbox" id="valuechain-all" class="mr-2" checked>
                <label for="valuechain-all" class="cursor-pointer text-gray-600 hover:text-green-600">
                    All Value Chains
                </label>
            `;
            container.appendChild(allDiv);

            // Add some example value chains
            const fallbackValueChains = [
                { ValueChainId: 1, ValueChainName: 'Maize' },
                { ValueChainId: 2, ValueChainName: 'Rice' },
                { ValueChainId: 3, ValueChainName: 'Wheat' },
                { ValueChainId: 4, ValueChainName: 'Dairy' },
                { ValueChainId: 5, ValueChainName: 'Poultry' }
            ];

            fallbackValueChains.forEach(valueChain => {
                const div = document.createElement('div');
                div.className = 'flex items-center';
                div.innerHTML = `
                    <input type="checkbox" id="valuechain-${valueChain.ValueChainId}" class="mr-2" value="${valueChain.ValueChainId}">
                    <label for="valuechain-${valueChain.ValueChainId}" class="cursor-pointer text-gray-600 hover:text-green-600">
                        ${valueChain.ValueChainName}
                    </label>
                `;
                container.appendChild(div);
            });
        }

        function createFallbackCounties() {
            console.log('Creating fallback counties');

            const container = document.getElementById('counties-container');
            if (!container) return;

            // Clear the container
            container.innerHTML = '';

            // Add "All" option
            const allDiv = document.createElement('div');
            allDiv.className = 'flex items-center';
            allDiv.innerHTML = `
                <input type="checkbox" id="county-all" class="mr-2" checked>
                <label for="county-all" class="cursor-pointer text-gray-600 hover:text-green-600">
                    All Counties
                </label>
            `;
            container.appendChild(allDiv);

            // Add some example counties
            const fallbackCounties = [
                { CountyId: 1, CountyName: 'Nairobi' },
                { CountyId: 2, CountyName: 'Mombasa' },
                { CountyId: 3, CountyName: 'Kisumu' },
                { CountyId: 4, CountyName: 'Nakuru' },
                { CountyId: 5, CountyName: 'Eldoret' }
            ];

            fallbackCounties.forEach(county => {
                const div = document.createElement('div');
                div.className = 'flex items-center';
                div.innerHTML = `
                    <input type="checkbox" id="county-${county.CountyId}" class="mr-2" value="${county.CountyId}">
                    <label for="county-${county.CountyId}" class="cursor-pointer text-gray-600 hover:text-green-600">
                        ${county.CountyName}
                    </label>
                `;
                container.appendChild(div);
            });
        }

        function applyFilters() {
            const productsGrid = document.getElementById('products-grid');
            const filters = collectFilters();

            // Show loading state
            if (productsGrid) {
                productsGrid.innerHTML = '<div class="col-span-3 py-20 text-center"><div class="animate-spin inline-block w-8 h-8 border-4 border-current border-t-transparent text-green-600 rounded-full" role="status"><span class="sr-only">Loading...</span></div><p class="mt-2 text-gray-500">Loading products...</p></div>';
            }
            // Construct the query parameters
            const params = new URLSearchParams();

            if (filters.valuechain.length > 0) {
                params.append('valuechain', filters.valuechain.join(','));
            }

            if (filters.county.length > 0) {
                params.append('county', filters.county.join(','));
            }

            alert(1)



            params.append('minprice', filters.minprice);
            params.append('maxprice', filters.maxprice);
            params.append('sort', filters.sort);
            params.append('perPage', filters.perPage);
            params.append('page', filters.page);

            const url = "{{ url('/api/V1/filterProducts') }}" + '?' + params.toString();

            // Make API request
            fetch(url, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        updateProductsGrid(data.products, data.pagination);
                    } else {
                        if (productsGrid) {
                            productsGrid.innerHTML = '<div class="col-span-3 py-10 text-center"><p class="text-red-500">Error loading products. Please try again.</p></div>';
                        }
                    }
                })
                .catch(error => {
                    console.error('Error applying filters:', error);
                    if (productsGrid) {
                        productsGrid.innerHTML = '<div class="col-span-3 py-10 text-center"><p class="text-red-500">Error loading products. Please try again.</p></div>';
                    }
                });
        }

        function collectFilters() {
            // Get all the current filter values from the DOM
            const valueChainCheckboxes = document.querySelectorAll('#value-chains-container input[type="checkbox"]:not(#valuechain-all):checked');
            const countyCheckboxes = document.querySelectorAll('#counties-container input[type="checkbox"]:not(#county-all):checked');
            const minPriceInput = document.getElementById('min-price');
            const maxPriceInput = document.getElementById('max-price');
            const sortBySelect = document.getElementById('sort-by');
            const perPageSelect = document.getElementById('per-page');

            // Collect valuechain IDs
            const valuechains = [];
            valueChainCheckboxes.forEach(checkbox => {
                valuechains.push(checkbox.value);
            });

            // Collect county IDs
            const counties = [];
            countyCheckboxes.forEach(checkbox => {
                counties.push(checkbox.value);
            });

            // Return the collected filters
            return {
                valuechain: valuechains,
                county: counties,
                minprice: parseInt(minPriceInput?.value || 0),
                maxprice: parseInt(maxPriceInput?.value || 200000),
                sort: sortBySelect?.value || 'featured',
                perPage: parseInt(perPageSelect?.value || 12),
                page: 1
            };
        }

        // Function to update products grid with new data
        function updateProductsGrid(products, pagination) {
            const productsGrid = document.getElementById('products-grid');
            const productsCount = document.getElementById('products-count');

            if (!productsGrid) return;

            if (products.length === 0) {
                productsGrid.innerHTML = '<div class="col-span-3 py-10 text-center"><p class="text-gray-500">No products found matching your filters.</p></div>';
                if (productsCount) {
                    productsCount.textContent = 'Showing 0 products';
                }
                return;
            }

            productsGrid.innerHTML = '';

            products.forEach(product => {
                const productCard = document.createElement('div');
                productCard.className = 'bg-white rounded-lg shadow overflow-hidden group product-card';

                const imageUrl = product.product_image ?
                    `/MemberProducts/${product.product_image}` :
                    '/placeholder.png';

                productCard.innerHTML = `
                    <a href="/product-detail/${product.id}">
                        <div class="relative">
                            <img src="${imageUrl}" alt="${product.variety}" class="w-full h-48 object-cover">
                            <div class="absolute top-2 right-2">
                                <button class="bg-white rounded-full p-2 shadow-md hover:bg-gray-100 transition-colors">
                                    <i class="far fa-heart text-gray-600"></i>
                                </button>
                            </div>
                            ${new Date(product.created_at) > new Date(Date.now() - 30 * 24 * 60 * 60 * 1000) ? `
                            <div class="absolute top-0 left-0 bg-green-700 text-white text-xs font-medium px-2 py-1">
                                NEW
                            </div>
                            ` : ''}
                        </div>
                        <div class="p-4">
                            <h3 class="font-medium text-gray-800 mb-1 group-hover:text-green-600 transition-colors">${product.variety}</h3>
                            <small class="text-gray-500 text-sm">${product.value_chain_name}</small>
                            <p class="text-green-600 font-bold text-lg mb-2">KSh ${product.unit_price}</p>

                            <div class="flex items-center justify-between">
                                <div class="flex items-center text-sm text-gray-500">
                                    <i class="fas fa-map-marker-alt mr-1"></i>
                                    <span>${product.county_name}</span>
                                </div>
                                <button class="bg-green-600 text-white text-sm px-3 py-1 rounded hover:bg-green-700 transition-colors">
                                    View Details
                                </button>
                            </div>
                        </div>
                    </a>
                `;

                productsGrid.appendChild(productCard);
            });

            if (productsCount) {
                productsCount.textContent = `Showing ${products.length} of ${pagination.total} product${pagination.total !== 1 ? 's' : ''}`;
            }

            // Update pagination if necessary
            if (pagination && document.getElementById('pagination-container')) {
                updatePagination(pagination);
            }
        }

        // Function to update pagination
        function updatePagination(pagination) {
            const paginationContainer = document.getElementById('pagination-container');
            if (!paginationContainer) return;

            // Simple pagination implementation
            let paginationHtml = '<div class="flex justify-center mt-6 space-x-1">';

            // Previous button
            paginationHtml += `
                <button
                    class="px-4 py-2 ${pagination.current_page === 1 ? 'bg-gray-100 text-gray-400' : 'bg-white text-green-600 hover:bg-green-50'} rounded-md"
                    ${pagination.current_page === 1 ? 'disabled' : `onclick="goToPage(${pagination.current_page - 1})"`}
                >
                    <i class="fas fa-chevron-left"></i>
                </button>
            `;

            // Page buttons
            for (let i = 1; i <= pagination.last_page; i++) {
                if (
                    i === 1 ||
                    i === pagination.last_page ||
                    (i >= pagination.current_page - 1 && i <= pagination.current_page + 1)
                ) {
                    paginationHtml += `
                        <button
                            class="px-4 py-2 ${i === pagination.current_page ? 'bg-green-600 text-white' : 'bg-white text-green-600 hover:bg-green-50'} rounded-md"
                            onclick="goToPage(${i})"
                        >
                            ${i}
                        </button>
                    `;
                } else if (
                    i === pagination.current_page - 2 ||
                    i === pagination.current_page + 2
                ) {
                    paginationHtml += `
                        <button class="px-4 py-2 bg-white text-green-600 rounded-md">
                            ...
                        </button>
                    `;
                }
            }

            // Next button
            paginationHtml += `
                <button
                    class="px-4 py-2 ${pagination.current_page === pagination.last_page ? 'bg-gray-100 text-gray-400' : 'bg-white text-green-600 hover:bg-green-50'} rounded-md"
                    ${pagination.current_page === pagination.last_page ? 'disabled' : `onclick="goToPage(${pagination.current_page + 1})"`}
                >
                    <i class="fas fa-chevron-right"></i>
                </button>
            `;

            paginationHtml += '</div>';

            paginationContainer.innerHTML = paginationHtml;
        }

        // Function to navigate to a specific page
        window.goToPage = function(page) {
            // Get current filters
            const filters = collectFilters();
            // Add page to the filters
            filters.page = page;

            // Apply the filters with the updated page
            const productsGrid = document.getElementById('products-grid');

            // Show loading state
            if (productsGrid) {
                productsGrid.innerHTML = '<div class="col-span-3 py-20 text-center"><div class="animate-spin inline-block w-8 h-8 border-4 border-current border-t-transparent text-green-600 rounded-full" role="status"><span class="sr-only">Loading...</span></div><p class="mt-2 text-gray-500">Loading products...</p></div>';
            }

            // Construct the query parameters
            const params = new URLSearchParams();

            if (filters.valuechain.length > 0) {
                params.append('valuechain', filters.valuechain.join(','));
            }

            if (filters.county.length > 0) {
                params.append('county', filters.county.join(','));
            }

            params.append('minprice', filters.minprice);
            params.append('maxprice', filters.maxprice);
            params.append('sort', filters.sort);
            params.append('perPage', filters.perPage);
            params.append('page', page);

            // Make API request
            fetch(`/api/V1/filterProducts?${params.toString()}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        updateProductsGrid(data.products, data.pagination);

                        // Scroll to top of products
                        window.scrollTo({
                            top: document.getElementById('products-grid').offsetTop - 100,
                            behavior: 'smooth'
                        });
                    } else {
                        if (productsGrid) {
                            productsGrid.innerHTML = '<div class="col-span-3 py-10 text-center"><p class="text-red-500">Error loading products. Please try again.</p></div>';
                        }
                    }
                })
                .catch(error => {
                    console.error('Error in page navigation:', error);
                    if (productsGrid) {
                        productsGrid.innerHTML = '<div class="col-span-3 py-10 text-center"><p class="text-red-500">Error loading products. Please try again.</p></div>';
                    }
                });
        };

        // Filter products function
        function filterProducts() {
            console.log('Filtering products...');

            // Get current page
            const currentPage = document.querySelector('.active-page')?.getAttribute('data-page') || 1;

            // Get sort option
            const sortSelect = document.getElementById('sort-by');
            const sortOption = sortSelect ? sortSelect.value : 'featured';

            // Get search term
            const searchTerm = document.getElementById('search-input')?.value || '';

            // Get selected value chains
            const selectedValueChains = [];
            const valueChainCheckboxes = document.querySelectorAll('#value-chains-container input[type="checkbox"]:not(#valuechain-all):checked');
            valueChainCheckboxes.forEach(checkbox => {
                selectedValueChains.push(checkbox.value);
            });

            // Get selected counties
            const selectedCounties = [];
            const countyCheckboxes = document.querySelectorAll('#counties-container input[type="checkbox"]:not(#county-all):checked');
            countyCheckboxes.forEach(checkbox => {
                selectedCounties.push(checkbox.value);
            });

            // Get min and max prices
            const minPrice = document.getElementById('min-price')?.value || '';
            const maxPrice = document.getElementById('max-price')?.value || '';

            // Show loading spinner
            const productsGrid = document.getElementById('products-grid');
            if (productsGrid) {
                productsGrid.innerHTML = `
                    <div class="col-span-3 py-20 text-center">
                        <div class="animate-spin inline-block w-8 h-8 border-4 border-current border-t-transparent text-green-600 rounded-full" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                        <p class="mt-2 text-gray-500">Loading products...</p>
                    </div>
                `;
            }

            // Build the URL with query parameters
            const urlParams = new URLSearchParams(window.location.search);
            const search = urlParams.get('search') || '';
            let url = '/api/V1/filterProducts?page=' + currentPage;
            if (search) {
                url += '&search=' + encodeURIComponent(search);
            }
            url += '&sort=' + encodeURIComponent(sortOption);

            if (searchTerm) {
                url += '&search=' + encodeURIComponent(searchTerm);
            }

            if (selectedValueChains.length > 0) {
                url += '&valuechain=' + encodeURIComponent(selectedValueChains.join(','));
            }

            if (selectedCounties.length > 0) {
                url += '&county=' + encodeURIComponent(selectedCounties.join(','));
            }

            if (minPrice) {
                url += '&minprice=' + encodeURIComponent(minPrice);
            }

            if (maxPrice) {
                url += '&maxprice=' + encodeURIComponent(maxPrice);
            }

            console.log('Filter URL:', url);

            // Make the API request
            fetch(url, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
                .then(response => response.json())
                .then(data => {
                    console.log('Filter response:', data);

                    if (data.success) {
                        updateProductsGrid(data.products, data.pagination);
                    } else {
                        if (productsGrid) {
                            productsGrid.innerHTML = `
                                <div class="col-span-3 py-10 text-center">
                                    <p class="text-red-500">Error loading products. Please try again.</p>
                                </div>
                            `;
                        }
                    }

                    // // remove search parameter from url
                    // const urlParams = new URLSearchParams(window.location.search);
                    // urlParams.delete('search');
                    // window.history.pushState({}, '', window.location.pathname + '?' + urlParams.toString());
                })
                .catch(error => {
                    console.error('Error filtering products:', error);
                    if (productsGrid) {
                        productsGrid.innerHTML = `
                            <div class="col-span-3 py-10 text-center">
                                <p class="text-red-500">Error loading products. Please try again.</p>
                            </div>
                        `;
                    }
                });
        }

        // Function to clear all filters
        function resetFilters() {
            console.log('Clearing filters...');

            // Reset search input
            const searchInput = document.getElementById('search-input');
            if (searchInput) {
                searchInput.value = '';
            }

            // Reset value chain checkboxes
            const valueChainAll = document.getElementById('valuechain-all');
            if (valueChainAll) {
                valueChainAll.checked = true;
            }
            const valueChainCheckboxes = document.querySelectorAll('#value-chains-container input[type="checkbox"]:not(#valuechain-all)');
            valueChainCheckboxes.forEach(checkbox => {
                checkbox.checked = false;
            });

            // Reset county checkboxes
            const countyAll = document.getElementById('county-all');
            if (countyAll) {
                countyAll.checked = true;
            }
            const countyCheckboxes = document.querySelectorAll('#counties-container input[type="checkbox"]:not(#county-all)');
            countyCheckboxes.forEach(checkbox => {
                checkbox.checked = false;
            });

            // Reset price inputs
            const minPrice = document.getElementById('min-price');
            if (minPrice) {
                minPrice.value = '0';
            }
            const maxPrice = document.getElementById('max-price');
            if (maxPrice) {
                maxPrice.value = '200000';
            }

            // Reset sort select
            const sortSelect = document.getElementById('sort-by');
            if (sortSelect) {
                sortSelect.value = 'featured';
            }

            // Reset to initial products
            window.location.reload();
        }
    </script>
@endsection
