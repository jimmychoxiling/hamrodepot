<?php


//Route::get('seller-profile', ['as' => 'seller-profile.edit', 'uses' => 'App\Http\Controllers\Seller\ProfileController@edit']);
Route::put('seller-profile', ['as' => 'seller-profile.update', 'uses' => 'App\Http\Controllers\Seller\ProfileController@update']);
Route::put('seller-profile/password', ['as' => 'seller-profile.password', 'uses' => 'App\Http\Controllers\Seller\ProfileController@password']);
Route::put('seller-profile/hours', ['as' => 'seller-profile.updateHours', 'uses' => 'App\Http\Controllers\Seller\ProfileController@updateHours']);

Route::post('getOrdersSeller-datatable',
    [\App\Http\Controllers\Backend\OrdersController::class, 'getOrdersSeller'])->name('getOrdersSeller-datatable');
Route::post('seller-order-status',
    [\App\Http\Controllers\Backend\OrdersController::class, 'updateSellerOrderStatus'])->name('seller-order-status');
