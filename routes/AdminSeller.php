<?php


Route::get('dashboard', [App\Http\Controllers\Backend\HomeController::class, 'index'])->name('dashboard');
Route::get('profile', ['as' => 'profile.edit', 'uses' => 'App\Http\Controllers\Backend\ProfileController@edit']);



/* Brand */
Route::get('brand', [\App\Http\Controllers\Backend\BrandController::class, 'index'])->name('brand');
Route::post('getBrand-datatable',
    [\App\Http\Controllers\Backend\BrandController::class, 'getBrand'])->name('getBrand-datatable');
Route::get('brand-create', [\App\Http\Controllers\Backend\BrandController::class, 'create'])->name('brand-create');
Route::post('brand-store', [\App\Http\Controllers\Backend\BrandController::class, 'store'])->name('brand-store');
Route::get('brand-show/{id}', [\App\Http\Controllers\Backend\BrandController::class, 'show'])->name('brand-show');
Route::get('brand-edit/{id}', [\App\Http\Controllers\Backend\BrandController::class, 'edit'])->name('brand-edit');
Route::post('brand-update/{id}', [\App\Http\Controllers\Backend\BrandController::class, 'update'])->name('brand-update');
Route::get('brand-delete/{id}',
    [\App\Http\Controllers\Backend\BrandController::class, 'destroy'])->name('brand-delete');
Route::post('brand-status-update', [\App\Http\Controllers\Backend\BrandController::class, 'updateStatus'])->name('brand-status-update');

/* Products */

Route::get('products', [\App\Http\Controllers\Backend\ProductsController::class, 'index'])->name('products');
Route::post('getProducts-datatable',
    [\App\Http\Controllers\Backend\ProductsController::class, 'getProducts'])->name('getProducts-datatable');
Route::get('products-create', [\App\Http\Controllers\Backend\ProductsController::class, 'create'])->name('products-create');
Route::post('products-store', [\App\Http\Controllers\Backend\ProductsController::class, 'store'])->name('products-store');
Route::get('products-show/{id}', [\App\Http\Controllers\Backend\ProductsController::class, 'show'])->name('products-show');
Route::get('products-edit/{id}', [\App\Http\Controllers\Backend\ProductsController::class, 'edit'])->name('products-edit');
Route::post('products-update/{id}', [\App\Http\Controllers\Backend\ProductsController::class, 'update'])->name('products-update');
Route::get('products-delete/{id}',
    [\App\Http\Controllers\Backend\ProductsController::class, 'destroy'])->name('products-delete');
Route::post('product-status-update',[\App\Http\Controllers\Backend\ProductsController::class, 'updateStatus'])->name('product-status-update');

Route::get('remove-products-images',
    [\App\Http\Controllers\Backend\ProductsController::class, 'removeProductsImages'])->name('remove-products-images');

/* Orders */

Route::get('order', [\App\Http\Controllers\Backend\OrdersController::class, 'index'])->name('order');
Route::post('getOrders-datatable',
    [\App\Http\Controllers\Backend\OrdersController::class, 'getOrders'])->name('getOrders-datatable');
Route::get('orders-detail/{id}', [App\Http\Controllers\Backend\OrdersController::class, 'orderDetail'])->name('orders-detail');
Route::post('order-status',
    [\App\Http\Controllers\Backend\OrdersController::class, 'updateSellerOrderStatus'])->name('order-status');


/* Reports */

Route::get('reports', [\App\Http\Controllers\Backend\ReportsController::class, 'index'])->name('reports');
Route::post('seller-products', [\App\Http\Controllers\Backend\ReportsController::class, 'getSellerProducts'])->name('seller-products');
Route::post('get-reports', [\App\Http\Controllers\Backend\ReportsController::class, 'getReports'])->name('get-reports');

Route::get('seller-reports-total-order', [\App\Http\Controllers\Backend\HomeController::class, 'getTotalOrders'])->name('seller-reports-total-order');
Route::get('seller-reports-total-sales', [\App\Http\Controllers\Backend\HomeController::class, 'getTotalSales'])->name('seller-reports-total-sales');

/* Service-category */

Route::get('service/category', [\App\Http\Controllers\Backend\ServiceCategoryController::class, 'index'])->name('service.category');
Route::get('services-create', [\App\Http\Controllers\Backend\ServiceCategoryController::class, 'create'])->name('services-create');
Route::post('service/category/store', [\App\Http\Controllers\Backend\ServiceCategoryController::class, 'store'])->name('service.category.store');
Route::post('getServiceCategory-datatable',
    [\App\Http\Controllers\Backend\ServiceCategoryController::class, 'getServiceCategory'])->name('getServiceCategory-datatable');
Route::get('service/category/edit/{id}/{type?}', [\App\Http\Controllers\Backend\ServiceCategoryController::class, 'edit'])->name('service.category.edit');
Route::post('service/category/change-status',[\App\Http\Controllers\Backend\ServiceCategoryController::class, 'changeStatus'])->name('service.category.change-status');

/* Service */

Route::get('services', [\App\Http\Controllers\Backend\ServiceController::class, 'index'])->name('services');
Route::post('getService-datatable',
[\App\Http\Controllers\Backend\ServiceController::class, 'getServices'])->name('getService-datatable');
Route::get('service/create', [\App\Http\Controllers\Backend\ServiceController::class, 'create'])->name('service.create');
Route::post('service/store', [\App\Http\Controllers\Backend\ServiceController::class, 'store'])->name('service.store');
Route::get('service/edit/{id}', [\App\Http\Controllers\Backend\ServiceController::class, 'edit'])->name('service.edit');
Route::post('service/change-status',[\App\Http\Controllers\Backend\ServiceController::class, 'changeStatus'])->name('service.change-status');
Route::get('service-detail/{slug}', [\App\Http\Controllers\Backend\ServiceController::class, 'show'])->name('service.show');

/* Service Request */

Route::get('service-request', [\App\Http\Controllers\Backend\ServiceRequestController::class, 'index'])->name('service-request');
Route::post('getServiceRequest-datatable',
[\App\Http\Controllers\Backend\ServiceRequestController::class, 'getServiceRequest'])->name('getServiceRequest-datatable');
Route::get('service-request/detail/{id}', [\App\Http\Controllers\Backend\ServiceRequestController::class, 'show'])->name('service-request.show');

// seller-order-status
Route::post('seller-order-status',
    [\App\Http\Controllers\Backend\OrdersController::class, 'updateSellerOrderStatus'])->name('seller-order-status');
