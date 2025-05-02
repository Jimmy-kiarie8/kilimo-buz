<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::any('ussd', '\App\Http\Controllers\UssdController@session');
Route::any('/V1/userlogin', '\App\Http\Controllers\V2\UserController@login');
Route::any('/V1/userMobilelogin', '\App\Http\Controllers\V2\UserController@Mobilelogin');
Route::any('/V1/LinkSellerByIDToVCO', '\App\Http\Controllers\V2\UserController@LinkSellerByIDToVCO');
Route::any('/V1/GetUom', '\App\Http\Controllers\V2\CountiesController@GetUom');
Route::any('/V1/GetSellerVCOList', '\App\Http\Controllers\V2\UserController@GetSellerVCOList');
Route::any('/V1/PostProduct', '\App\Http\Controllers\V2\UserController@PostProduct');
Route::any('/V1/GetMyProducts', '\App\Http\Controllers\V2\UserController@getMyProduct');
Route::any('/V1/DeleteMyProduct', '\App\Http\Controllers\V2\UserController@DeleteMyProduct');
Route::any('/V1/UpdateProduct', '\App\Http\Controllers\V2\UserController@UpdateProduct');
Route::any('/V1/getUserProfile', '\App\Http\Controllers\V2\UserController@GetMyProfile');
Route::any('/V1/UpdateUserProfile', '\App\Http\Controllers\V2\UserController@UpdateProfile');
Route::any('/V1/UpdateUserAvatar', '\App\Http\Controllers\V2\UserController@ProfileAvatar');
Route::any('/V1/UserRegister', '\App\Http\Controllers\V2\UserController@UserRegister');
Route::any('/V1/userOTPVerification', '\App\Http\Controllers\V2\UserController@userOTPVerification');
Route::any('/V1/GetCounties', '\App\Http\Controllers\V2\CountiesController@Index');
Route::any('/V1/GetNodes', '\App\Http\Controllers\V2\CountiesController@GetNodes');
Route::any('/V1/GetValueChains', '\App\Http\Controllers\V2\CountiesController@GetValueChains');
Route::any('/V1/GetProductNames', '\App\Http\Controllers\V2\CountiesController@GetProductNames');
Route::any('/V1/GetProductNamesByValueChainId', '\App\Http\Controllers\V2\CountiesController@GetProductNamesByValueChainId');
Route::any('/V1/GetCountyValueChainByCid', '\App\Http\Controllers\V2\CountiesController@GetCountyValueChainByCid');
Route::any('/V1/GetFeaturedItems', '\App\Http\Controllers\V2\CountiesController@GetFeaturedItems');
Route::any('/V1/GetProductByID', '\App\Http\Controllers\V2\CountiesController@GetProductByID');
Route::any('/V1/GetProductSellersByCounty', '\App\Http\Controllers\V2\CountiesController@GetProductSellersByCounty');
Route::any('/V1/GetValueChainCounties', '\App\Http\Controllers\V2\CountiesController@GetValueChainCounties');
Route::any('V1/GetAllTranspoters', '\App\Http\Controllers\V2\TransporterController@getList');

Route::any('V1/CreateOrder', '\App\Http\Controllers\V2\OrderController@CreateOrder');
Route::any('/V1/GetOrderDetails/{id}', '\App\Http\Controllers\V2\OrderController@GetOrderDetails');
Route::any('V1/MyOrders', '\App\Http\Controllers\V2\OrderController@MyOrders');
Route::any('/V1/ProductFeedback', '\App\Http\Controllers\V2\OrderController@CustomerFeedback');
Route::any('/V1/GetSellerOrders', '\App\Http\Controllers\V2\OrderController@GetSellerOrders');
Route::any('/V1/GetProducstByCountyID', '\App\Http\Controllers\V2\CountiesController@GetProducstByCountyID');
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::any('/V1/filterProducts', '\App\Http\Controllers\V2\BuzApiController@filterProducts');
Route::any('/V1/test', '\App\Http\Controllers\V2\BuzApiController@testApi');

Route::any('/V1/searchProducts/{search}', '\App\Http\Controllers\V2\BuzApiController@searchProducts');
Route::any('/V1/getCountyByValueChains/{ids}', '\App\Http\Controllers\V2\BuzApiController@getCountyByValueChains');