<?php

namespace App\Http\Controllers\V2;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Usermanagement\Entities\County;
use Modules\Usermanagement\Entities\CountyValueChain;
use Modules\Usermanagement\Entities\Product;

class BuzApiController extends Controller
{
    public function searchProducts(Request $request, $search = null)
    {
        // Allow search to come from route parameter or request input
        $searchTerm = $search ?? $request->input('search');

        if (empty($searchTerm)) {
            return response()->json([]);
        }

        $query = Product::query()
            ->whereNotNull('product_image')
            ->whereNull('is_deleted')
            ->where(function ($q) use ($searchTerm) {
                $q->where('variety', 'like', "%$searchTerm%")
                  ->orWhere('value_chain_name', 'like', "%$searchTerm%")
                  ->orWhere('county_name', 'like', "%$searchTerm%")
                  ->orWhere('product_description', 'like', "%$searchTerm%");
            })
            ->orderBy('id', 'desc')
            ->limit(20);

        $products = $query->get();

        // Format products for response
        $formattedProducts = [];
        foreach ($products as $product) {
            $formattedProducts[] = [
                'id' => $product->id,
                'variety' => $product->variety,
                'product_code' => $product->product_code,
                'product_image' => $product->product_image,
                'unit_price' => $product->unit_price,
                'quantity_available' => $product->quantity_available,
                'uom' => $product->uom,
                'county_name' => $product->county_name,
                'value_chain_name' => $product->value_chain_name,
                'created_at' => $product->created_at,
            ];
        }

        return response()->json($formattedProducts);
    }

    public function getCountyByValueChains($ids)
    {
        if (empty($ids)) {
            return response()->json([]);
        }

        $valueChainIds = explode(',', $ids);

        // Get counties for the selected value chains
        $countyIds = CountyValueChain::whereIn('value_chain_id', $valueChainIds)
            ->distinct()
            ->pluck('county_id');

        $counties = County::whereIn('id', $countyIds)
            ->select('id as CountyId', 'county_name as CountyName')
            ->get();

        if ($counties->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'No counties found for these value chains'
            ]);
        }

        // Format for the frontend
        $result = [];
        foreach ($counties as $county) {
            $result[] = [
                'CountyId' => $county->CountyId,
                'CountyName' => $county->CountyName
            ];
        }

        return response()->json($result);
    }

    public function filterProducts(Request $request)
    {
        $valuechain = $request->valuechain;
        $county = $request->county;
        $minprice = $request->minprice ?? 0;
        $maxprice = $request->maxprice ?? 200000;
        $minquantity = $request->minquantity ?? 0;
        $maxquantity = $request->maxquantity ?? 1000000;
        $sort = $request->sort ?? 'featured';
        $perPage = $request->perPage ?? 12;
        $page = $request->page ?? 1;
        $search = $request->search ?? '';

        $query = Product::query()
            ->whereNotNull('product_image')
            ->whereNull('is_deleted')
            ->where('unit_price', '>=', $minprice)
            ->where('unit_price', '<=', $maxprice)
            ->where('quantity_available', '>=', $minquantity)
            ->where('quantity_available', '<=', $maxquantity);

        // Add search functionality if search term is provided
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('variety', 'like', "%$search%")
                  ->orWhere('value_chain_name', 'like', "%$search%")
                  ->orWhere('county_name', 'like', "%$search%")
                  ->orWhere('product_description', 'like', "%$search%");
            });
        }

        // Filter by value chain if provided
        if (!empty($valuechain)) {
            $valuechainIds = explode(',', $valuechain);
            $query->whereIn('value_chain_id', $valuechainIds);
        }

        // Filter by county if provided
        if (!empty($county)) {
            $countyIds = explode(',', $county);
            $query->whereIn('county_id', $countyIds);
        }

        // Apply sorting
        switch ($sort) {
            case 'price_asc':
                $query->orderBy('unit_price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('unit_price', 'desc');
                break;
            case 'newest':
                $query->orderBy('created_at', 'desc');
                break;
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
            case 'popular':
                // You might want to add a column for popularity or use another metric
                $query->orderBy('id', 'desc');
                break;
            default: // featured or any other value
                $query->orderBy('id', 'desc');
                break;
        }

        // Get products with pagination
        $products = $query->paginate($perPage, ['*'], 'page', $page);

        // Format products for response
        $formattedProducts = [];
        foreach ($products as $product) {
            $formattedProducts[] = [
                'id' => $product->id,
                'variety' => $product->variety,
                'product_code' => $product->product_code,
                'product_image' => $product->product_image,
                'unit_price' => $product->unit_price,
                'quantity_available' => $product->quantity_available,
                'uom' => $product->uom,
                'county_name' => $product->county_name,
                'value_chain_name' => $product->value_chain_name,
                'created_at' => $product->created_at,
            ];
        }

        return response()->json([
            'success' => true,
            'products' => $formattedProducts,
            'pagination' => [
                'total' => $products->total(),
                'per_page' => $products->perPage(),
                'current_page' => $products->currentPage(),
                'last_page' => $products->lastPage(),
            ]
        ]);
    }

    public function testApi(Request $request)
    {
        return response()->json([
            'success' => true,
            'message' => 'API is working correctly',
            'timestamp' => now()
        ]);
    }
}

