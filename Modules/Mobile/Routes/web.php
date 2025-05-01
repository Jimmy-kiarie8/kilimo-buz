<?php

Route::prefix('mobile')->middleware(['cors'])->group(function() {
    Route::get('/', 'MobileController@index');

    Route::any('/V1/userlogin','V2\UserController@login');
    Route::any('/V1/userMobilelogin','V2\UserController@Mobilelogin');
    Route::any('/V1/UserRegister','V2\UserController@UserRegister');
    Route::any('/V1/userOTPVerification','V2\UserController@userOTPVerification');
    Route::any('/V1/GetCounties','V2\CountiesController@Index');
    Route::any('/V1/GetNodes','V2\CountiesController@GetNodes');
    Route::any('/V1/GetValueChains','V2\CountiesController@GetValueChains');
    Route::any('/V1/GetProductNames','V2\CountiesController@GetProductNames');
    Route::any('/V1/GetProductNamesByValueChainId','V2\CountiesController@GetProductNamesByValueChainId');
    Route::any('/V1/GetCountyValueChainByCid','V2\CountiesController@GetCountyValueChainByCid');
    Route::any('/V1/GetFeaturedItems','V2\CountiesController@GetFeaturedItems');
    Route::any('/V1/GetProductByID','V2\CountiesController@GetProductByID');
    Route::any('/V1/GetProductSellersByCounty','V2\CountiesController@GetProductSellersByCounty');
    Route::any('/V1/GetValueChainCounties','V2\CountiesController@GetValueChainCounties');
    Route::any('V1/GetAllTranspoters','V2\TransporterController@getList');

    Route::any('V1/CreateOrder','V2\OrderController@CreateOrder');
    Route::any('V1/MyOrders','V2\OrderController@MyOrders');
    Route::any('/V1/ProductFeedback','V2\OrderController@CustomerFeedback');


});
