<?php

use Illuminate\Support\Facades\Route;
use Modules\Usermanagement\Entities\County;
use Modules\Usermanagement\Entities\ValueChain;
use Modules\Usermanagement\Entities\ProductName;
use Modules\Usermanagement\Entities\Product;
use  App\Helpers\Helper;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider witfetchListhin a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {







    $data['counties'] = DB::select("select distinct  county_id as id ,county_name from products  where is_deleted is null and county_id is not null order by  county_name asc");
        /*$data['chains']=ProductName::join('uploads','uploads.id','=','product_names.product_image')
	     ->join('value_chains','value_chains.id','=','product_names.value_chain_id')
	     ->inRandomOrder()->paginate(12)*/;
    $data['chains'] = Product::join('value_chains', 'value_chains.id', '=', 'products.value_chain_id')
        ->select('products.id', 'value_name', 'uom', 'variety', 'quantity_available', 'products.unit_price', 'product_code', 'product_image', 'products.county_name', 'products.county_id')
        ->whereNull('is_deleted')
        ->whereNotNull('product_image')
        ->inRandomOrder()
        ->paginate(12);

        // dd($data);

    $data['featured'] = Product::join('value_chains', 'value_chains.id', '=', 'products.value_chain_id')
        ->select('products.id', 'value_name', 'uom', 'variety', 'quantity_available', 'products.unit_price', 'product_code', 'product_image', 'products.county_name')
        ->whereNull('is_deleted')
        ->whereNotNull('product_image')->inRandomOrder()->take(8)->get();

        $data['latest'] = Product::join('value_chains', 'value_chains.id', '=', 'products.value_chain_id')
        ->select('products.id', 'value_name', 'uom', 'variety', 'quantity_available', 'products.unit_price', 'product_code', 'product_image', 'products.county_name')
        ->whereNull('is_deleted')
        ->whereNotNull('product_image')->inRandomOrder()->take(8)->get();


    $data['categories'] = DB::select("select distinct  value_chain_id as id ,value_name from products
join value_chains on value_chains.id=products.value_chain_id
 where products.is_deleted is null ");



    // return  view('welcome', $data);
    return  view('buz.index', $data);
});

Route::get('/shop', function () {
    $data['counties'] = DB::select("select distinct  county_id as id ,county_name from products  where is_deleted is null and county_id is not null order by  county_name asc");
    $data['categories'] = DB::select("select distinct  value_chain_id as id ,value_name from products
join value_chains on value_chains.id=products.value_chain_id
 where products.is_deleted is null ");

    $data['products'] = Product::join('value_chains', 'value_chains.id', '=', 'products.value_chain_id')
        ->select('products.id', 'value_name', 'uom', 'variety', 'quantity_available', 'products.unit_price', 'product_code', 'product_image', 'products.county_name')
        ->whereNull('is_deleted')
        ->whereNotNull('product_image')->paginate(12);

        // dd($data['products']);


    return view('buz.shop', $data);
});

Route::get('/product-detail/{id}', function ($id) {
    $data['product'] = Product::find($id);
    $relatedProducts = Product::where('value_chain_id', $data['product']->value_chain_id)
        ->where('id', '!=', $id)
        ->inRandomOrder()->take(3)->get();
    $data['relatedProducts'] = $relatedProducts;
    return view('buz.product-detail', $data);
})->name('product-detail');





Route::any('/VCOs/Registered', '\App\Http\Controllers\VCOsController@Index');
Route::any('/ProductsDetails/{code}', '\App\Http\Controllers\ProductController@ProductsDetails');
Route::any('/ProcessCard/Add/{orgId}/{Code}', '\App\Http\Controllers\ProductController@AddToCard');
Route::any('/VCOs/fetchList', '\App\Http\Controllers\VCOsController@fetchList');
Route::any('/County/Statistics', '\App\Http\Controllers\VCOsController@CountyStats');
Route::any('/VCOs/getCheckProductName', '\App\Http\Controllers\VCOsController@getCheckProductName');
Route::any('/CountyStats/fetchList', '\App\Http\Controllers\VCOsController@fetchListCountyStats');
Route::any('/VCOs/getCountyPostedValuechainName', '\App\Http\Controllers\VCOsController@getCountyPostedValuechainName');


Route::any('/MemberProducts/fetchList', '\App\Http\Controllers\ProductController@fetchList');
Route::any('/Product/ContactMember/{id}', '\App\Http\Controllers\ProductController@ViewDetails');
Route::any('/Products/SearchByCounty', '\App\Http\Controllers\ProductController@SearchByCounty');

Auth::routes();

Route::get('/home', '\App\Http\Controllers\HomeController@index')->name('home');
Route::get('logout', 'Auth\LoginController@logout');
Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');

Route::get('/upload', '\App\Http\Controllers\UploadController@getUploadTestPage');
Route::any('/System/file/upload', 'UploadController@uploadFile');
Route::any('/System/file/fetch', 'UploadController@fetchFiles');
