<?php


Route::resource('user', 'App\Http\Controllers\Backend\UserController', ['except' => ['show']]);
Route::put('profile', ['as' => 'profile.update', 'uses' => 'App\Http\Controllers\Backend\ProfileController@update']);
Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'App\Http\Controllers\Backend\ProfileController@password']);


/* Category */

Route::get('category', [\App\Http\Controllers\Backend\CategoryController::class, 'index'])->name('category');
Route::post('getCategory-datatable',
    [\App\Http\Controllers\Backend\CategoryController::class, 'getCategory'])->name('getCategory-datatable');
Route::get('category-create', [\App\Http\Controllers\Backend\CategoryController::class, 'create'])->name('category-create');
Route::post('category-store', [\App\Http\Controllers\Backend\CategoryController::class, 'store'])->name('category-store');
Route::get('category-show/{id}', [\App\Http\Controllers\Backend\CategoryController::class, 'show'])->name('category-show');
Route::get('category-edit/{id}', [\App\Http\Controllers\Backend\CategoryController::class, 'edit'])->name('category-edit');
Route::post('category-update/{id}', [\App\Http\Controllers\Backend\CategoryController::class, 'update'])->name('category-update');
Route::get('category-delete/{id}',
    [\App\Http\Controllers\Backend\CategoryController::class, 'destroy'])->name('category-delete');
    Route::post('category-status-update', [\App\Http\Controllers\Backend\CategoryController::class, 'updateStatus'])->name('category-status-update');


/* Sub-Category */
Route::get('sub-category', [\App\Http\Controllers\Backend\SubCategoryController::class, 'index'])->name('sub-category');
Route::post('getSubcategory-datatable',
    [\App\Http\Controllers\Backend\SubCategoryController::class, 'getSubCategory'])->name('getSubCategory-datatable');
Route::get('sub-category-create', [\App\Http\Controllers\Backend\SubCategoryController::class, 'create'])->name('sub-category-create');
Route::post('sub-category-store', [\App\Http\Controllers\Backend\SubCategoryController::class, 'store'])->name('sub-category-store');
Route::get('sub-category-show/{id}', [\App\Http\Controllers\Backend\SubCategoryController::class, 'show'])->name('sub-category-show');
Route::get('sub-category-edit/{id}', [\App\Http\Controllers\Backend\SubCategoryController::class, 'edit'])->name('sub-category-edit');
Route::post('sub-category-update/{id}', [\App\Http\Controllers\Backend\SubCategoryController::class, 'update'])->name('sub-category-update');
Route::get('sub-category-delete/{id}',
    [\App\Http\Controllers\Backend\SubCategoryController::class, 'destroy'])->name('sub-category-delete');
    Route::post('sub-category-status-update', [\App\Http\Controllers\Backend\SubCategoryController::class, 'updateStatus'])->name('sub-category-status-update');
/* Types */
Route::get('type', [\App\Http\Controllers\Backend\TypeController::class, 'index'])->name('type');
Route::post('getType-datatable',
    [\App\Http\Controllers\Backend\TypeController::class, 'getTypes'])->name('getType-datatable');
Route::get('type-create', [\App\Http\Controllers\Backend\TypeController::class, 'create'])->name('type-create');
Route::post('type-store', [\App\Http\Controllers\Backend\TypeController::class, 'store'])->name('type-store');
Route::get('type-show/{id}', [\App\Http\Controllers\Backend\TypeController::class, 'show'])->name('type-show');
Route::get('type-edit/{id}', [\App\Http\Controllers\Backend\TypeController::class, 'edit'])->name('type-edit');
Route::post('type-update/{id}', [\App\Http\Controllers\Backend\TypeController::class, 'update'])->name('type-update');
Route::get('type-delete/{id}',
    [\App\Http\Controllers\Backend\TypeController::class, 'destroy'])->name('type-delete');
    Route::post('type-status-update', [\App\Http\Controllers\Backend\TypeController::class, 'updateStatus'])->name('type-status-update');
/* Seller */

Route::get('seller', [\App\Http\Controllers\Backend\SellerController::class, 'index'])->name('seller');
Route::post('getSeller-datatable',
        [\App\Http\Controllers\Backend\SellerController::class, 'getSeller'])->name('getSeller-datatable');
Route::get('seller-create', [\App\Http\Controllers\Backend\SellerController::class, 'create'])->name('seller-create');
Route::post('seller-store', [\App\Http\Controllers\Backend\SellerController::class, 'store'])->name('seller-store');
Route::get('seller-show/{id}', [\App\Http\Controllers\Backend\SellerController::class, 'show'])->name('seller-show');
Route::get('seller-edit/{id}',  [\App\Http\Controllers\Backend\SellerController::class, 'edit'])->name('seller-edit');
Route::post('seller-update/{id}', [\App\Http\Controllers\Backend\SellerController::class, 'update'])->name('seller-update');
Route::get('seller-delete/{id}',
        [\App\Http\Controllers\Backend\SellerController::class, 'destroy'])->name('seller-delete');
Route::post('seller-status-update', [App\Http\Controllers\Backend\SellerController::class, 'updateStatus'])->name('seller-status-update');
Route::post('seller-commission-update', [App\Http\Controllers\Backend\SellerController::class, 'updateCommission'])->name('seller-commission-update');


/* Users */

Route::get('user', [\App\Http\Controllers\Backend\UserController::class, 'index'])->name('user');
Route::post('getUsers-datatable',
        [\App\Http\Controllers\Backend\UserController::class, 'getUsers'])->name('getUsers-datatable');
Route::get('user-create', [\App\Http\Controllers\Backend\UserController::class, 'create'])->name('user-create');
Route::post('user-store', [\App\Http\Controllers\Backend\UserController::class, 'store'])->name('user-store');
Route::get('user-show/{id}', [\App\Http\Controllers\Backend\UserController::class, 'show'])->name('user-show');
Route::get('user-edit/{id}', [\App\Http\Controllers\Backend\UserController::class, 'edit'])->name('user-edit');
Route::post('user-update/{id}', [\App\Http\Controllers\Backend\UserController::class, 'update'])->name('user-update');
Route::get('user-delete/{id}',
        [\App\Http\Controllers\Backend\UserController::class, 'destroy'])->name('user-delete');


/* Blog Category */

Route::get('blog-category', [\App\Http\Controllers\Backend\BlogCategoryController::class, 'index'])->name('blog-category');
Route::post('getBlogCategory-datatable',
    [\App\Http\Controllers\Backend\BlogCategoryController::class, 'getBlogCategory'])->name('getBlogCategory-datatable');
Route::get('blog-category-create', [\App\Http\Controllers\Backend\BlogCategoryController::class, 'create'])->name('blog-category-create');
Route::post('blog-category-store', [\App\Http\Controllers\Backend\BlogCategoryController::class, 'store'])->name('blog-category-store');
Route::get('blog-category-show/{id}', [\App\Http\Controllers\Backend\BlogCategoryController::class, 'show'])->name('blog-category-show');
Route::get('blog-category-edit/{id}', [\App\Http\Controllers\Backend\BlogCategoryController::class, 'edit'])->name('blog-category-edit');
Route::post('blog-category-update/{id}', [\App\Http\Controllers\Backend\BlogCategoryController::class, 'update'])->name('blog-category-update');
Route::get('blog-category-delete/{id}',
    [\App\Http\Controllers\Backend\BlogCategoryController::class, 'destroy'])->name('blog-category-delete');

/* Blog */

Route::get('blog', [\App\Http\Controllers\Backend\BlogController::class, 'index'])->name('blog');
Route::post('getBlog-datatable',
    [\App\Http\Controllers\Backend\BlogController::class, 'getBlog'])->name('getBlog-datatable');
Route::get('blog-create', [\App\Http\Controllers\Backend\BlogController::class, 'create'])->name('blog-create');
Route::post('blog-store', [\App\Http\Controllers\Backend\BlogController::class, 'store'])->name('blog-store');
Route::get('blog-show/{id}', [\App\Http\Controllers\Backend\BlogController::class, 'show'])->name('blog-show');
Route::get('blog-edit/{id}', [\App\Http\Controllers\Backend\BlogController::class, 'edit'])->name('blog-edit');
Route::post('blog-update/{id}', [\App\Http\Controllers\Backend\BlogController::class, 'update'])->name('blog-update');
Route::get('blog-delete/{id}',
    [\App\Http\Controllers\Backend\BlogController::class, 'destroy'])->name('blog-delete');

/* Setting */

Route::get('setting', [\App\Http\Controllers\Backend\SettingContoller::class, 'index'])->name('setting');
Route::post('getSetting-datatable',
    [\App\Http\Controllers\Backend\SettingContoller::class, 'getSetting'])->name('getSetting-datatable');
Route::get('setting-edit/{id}', [\App\Http\Controllers\Backend\SettingContoller::class, 'edit'])->name('setting-edit');
Route::post('setting-update/{id}', [\App\Http\Controllers\Backend\SettingContoller::class, 'update'])->name('setting-update');


/* Reports */
Route::get('reports-total-order', [\App\Http\Controllers\Backend\HomeController::class, 'getTotalOrders'])->name('reports-total-order');
Route::get('reports-total-sales', [\App\Http\Controllers\Backend\HomeController::class, 'getTotalSales'])->name('reports-total-sales');


/* Contact Us */
Route::get('contacts', [\App\Http\Controllers\Backend\ContactController::class, 'index'])->name('contacts');
Route::post('getContact-datatable',
    [\App\Http\Controllers\Backend\ContactController::class, 'getContacts'])->name('getContact-datatable');

/* FAQ */
Route::get('faq-question', [\App\Http\Controllers\Backend\FaqController::class, 'index'])->name('faq-question');
Route::get('faq-create', [\App\Http\Controllers\Backend\FaqController::class, 'create'])->name('faq-create');
Route::get('faq-edit/{id}', [\App\Http\Controllers\Backend\FaqController::class, 'edit'])->name('faq-edit');
Route::post('getFaq-datatable', [\App\Http\Controllers\Backend\FaqController::class, 'getFaq'])->name('getFaq-datatable');
Route::post('question-create', [\App\Http\Controllers\Backend\FaqController::class, 'store'])->name('question-create');
Route::post('question-update/{id}', [\App\Http\Controllers\Backend\FaqController::class, 'update'])->name('question-update');
Route::get('question-delete/{id}', [\App\Http\Controllers\Backend\FaqController::class, 'destroy'])->name('question-delete');
Route::post('question-status-update', [\App\Http\Controllers\Backend\FaqController::class, 'updateStatus'])->name('question-status-update');
Route::get('question-show/{id}', [\App\Http\Controllers\Backend\FaqController::class, 'show'])->name('question-show');


/*  Vouchers */
Route::get('voucher', [\App\Http\Controllers\Backend\VouchersController::class, 'index'])->name('voucher');
Route::get('voucher-create', [\App\Http\Controllers\Backend\VouchersController::class, 'create'])->name('voucher-create');
Route::post('voucher-store', [\App\Http\Controllers\Backend\VouchersController::class, 'store'])->name('voucher-store');
Route::post('getVoucher-datatable',
    [\App\Http\Controllers\Backend\VouchersController::class, 'getVoucher'])->name('getVoucher-datatable');
    Route::get('voucher-edit/{id}', [\App\Http\Controllers\Backend\VouchersController::class, 'edit'])->name('voucher-edit');
    Route::get('voucher-show/{id}', [\App\Http\Controllers\Backend\VouchersController::class, 'show'])->name('voucher-show');
    Route::post('voucher-update/{id}', [\App\Http\Controllers\Backend\VouchersController::class, 'update'])->name('voucher-update');
    Route::post('voucher-status-update',[\App\Http\Controllers\Backend\VouchersController::class, 'updateStatus'])->name('voucher-status-update');
