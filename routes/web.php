<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//
//Route::get('/', function () {
//    return view('welcome');
//});

Route::get('/storage/{filename}', [App\Http\Controllers\Front\HomeController::class, 'getFile'])->where('filename', '.*');
Route::get('/', [App\Http\Controllers\Front\HomeController::class, 'index'])->name('home');
Route::get('/manage', function () {

    return redirect()->route('login');
});


Auth::routes();

Route::get('search',  [App\Http\Controllers\Front\SearchController::class, 'search'])->name('search');

Route::post('register-seller', 'App\Http\Controllers\Auth\RegisterController@registerSeller')->name('register-seller');
Route::post('register-user', 'App\Http\Controllers\Auth\RegisterController@registerUser')->name('register-user');

Route::get('/logout', '\App\Http\Controllers\Auth\LoginController@logout');
Route::get('hardware/{slug2?}', [\App\Http\Controllers\Front\CategoryController::class, 'index'])->name('hardware');
Route::get('hardware/{slug2?}/{slug3?}', [\App\Http\Controllers\Front\ProductController::class, 'index'])->name('our-products');
Route::get('hardware/{slug2?}/{slug3?}/{slug4?}', [\App\Http\Controllers\Front\ProductController::class, 'index'])->name('our-products');
Route::get('hardware-detail/{slug2?}/{slug3?}/{slug4?}', [\App\Http\Controllers\Front\ProductDetailController::class, 'index'])->name('product-detail');
Route::get('hardware-detail/{slug2?}/{slug3?}/{slug4?}/{slug5?}', [\App\Http\Controllers\Front\ProductDetailController::class, 'index'])->name('product-detail');
Route::post('product-rating', [\App\Http\Controllers\Front\ProductDetailController::class, 'addRating'])->name('product-rating');

Route::get('cart', [App\Http\Controllers\Front\CartController::class, 'cart'])->name('cart');
Route::post('cart-add', [App\Http\Controllers\Front\CartController::class, 'cartAdd'])->name('cart-add');
Route::post('cart-update', [App\Http\Controllers\Front\CartController::class, 'cartUpdate'])->name('cart-update');
Route::delete('cart-remove', [App\Http\Controllers\Front\CartController::class, 'cartRemove'])->name('cart-remove');
//offer apply
Route::post('cart-offer-apply', [App\Http\Controllers\Front\CheckoutController::class, 'cartOfferApply'])->name('cart-offer-apply');
Route::get('cart-offer-cancel', [App\Http\Controllers\Front\CheckoutController::class, 'cartOfferCancel'])->name('cart-offer-cancel');


Route::get('contact-us', [App\Http\Controllers\Front\ContactController::class, 'contact'])->name('contact-us');
Route::post('make-contact', [App\Http\Controllers\Front\ContactController::class, 'makeContact'])->name('make-contact');
Route::get('brands', [App\Http\Controllers\Front\BrandsController::class, 'brands'])->name('brands');
Route::get('brands/{slug2?}', [App\Http\Controllers\Front\BrandsController::class, 'brandsProducts'])->name('brands-products');

Route::get('blogs/{slug2?}/{slug3?}', [App\Http\Controllers\Front\BlogController::class, 'blogs'])->name('blogs');
Route::get('blog-detail/{slug2}', [App\Http\Controllers\Front\BlogController::class, 'blogDetail'])->name('blog-detail');

Route::post('products-filter',  [\App\Http\Controllers\Front\ProductController::class, 'filters'])->name('products-filter');
Route::post('search-filter',  [\App\Http\Controllers\Front\SearchController::class, 'filters'])->name('search-filter');
Route::post('brand-filter',  [\App\Http\Controllers\Front\BrandsController::class, 'filters'])->name('brand-filter');

Route::post('track-order',  [App\Http\Controllers\Front\PlaceOrdersController::class, 'trackOrder'])->name('track-order');


Route::post('getSubCategory',
    [\App\Http\Controllers\Backend\ProductsController::class, 'getSubCategory'])->name('getSubCategory');
Route::post('getTypes',
    [\App\Http\Controllers\Backend\ProductsController::class, 'getTypes'])->name('getTypes');

Route::get('account-not-active', 'App\Http\Controllers\Front\HomeController@accountNotActive')->name('account-not-active');
Route::post('wishlist-add-remove', [App\Http\Controllers\Front\WishlistController::class, 'wishlistAddRemove'])->name('wishlist-add-remove');

Route::get('about-us', [App\Http\Controllers\Front\PagesController::class,'aboutUs'])->name('about-us');
Route::get('track-your-order', [App\Http\Controllers\Front\PagesController::class,'trackYourOrder'])->name('track-your-order');
Route::get('easy-returns', [App\Http\Controllers\Front\PagesController::class,'easyReturns'])->name('easy-returns');
Route::get('about-hardware', [App\Http\Controllers\Front\PagesController::class,'aboutHardware'])->name('about-hardware');
Route::get('sell-with-us', [App\Http\Controllers\Front\PagesController::class,'sellWithUs'])->name('sell-with-us');
Route::get('community', [App\Http\Controllers\Front\PagesController::class,'community'])->name('community');
Route::get('brand-we-love', [App\Http\Controllers\Front\PagesController::class,'brandWeLove'])->name('brand-we-love');
Route::get('gift-cards', [App\Http\Controllers\Front\PagesController::class,'giftCards'])->name('gift-cards');

Route::get('faq', [App\Http\Controllers\Front\FaqController::class,'index'])->name('faq');
Route::post('find-faq', [App\Http\Controllers\Front\FaqController::class,'find'])->name('find-faq');

/* service */
Route::get('service', [App\Http\Controllers\Front\ServiceController::class,'service'])->name('service');
Route::get('service/detail/{slug}', [App\Http\Controllers\Front\ServiceController::class,'serviceDetails'])->name('service.detail');
Route::get('service3', [App\Http\Controllers\Front\ServiceController::class,'service3'])->name('service3');
Route::get('service4', [App\Http\Controllers\Front\ServiceController::class,'service4'])->name('service4');
Route::post('save-service-request', [App\Http\Controllers\Front\ServiceController::class,'addServiceRequest'])->name('save-service-request');
Route::post('services-filter',  [\App\Http\Controllers\Front\ServiceController::class, 'filters'])->name('services-filter');

Route::post('stripe/webhook', [App\Http\Controllers\WebhookStripeController::class, 'handleWebhook']);

/* rental */
Route::group(['prefix'=>'rental'], function(){
    Route::get('/', function(){ //[\App\Http\Controllers\Front\RentalController::class, 'rentalIndex'] 
        return 'Rental Page';
    })->name('rental');
});

/**Paint shop */
Route::group(['prefix'=>'paint-shop'], function(){
    Route::get('/', function(){
        return 'Paint shop Page';
    })->name('paint');
});

Route::group(['middleware' => ['auth','role:User']], function () {


    Route::get('my-account', [\App\Http\Controllers\Front\MyAccountController::class, 'myAccount'])->name('my-account');
    Route::post('user-details-update', [\App\Http\Controllers\Front\MyAccountController::class, 'updateUserDetails'])->name('user-details-update');
    Route::put('my-account/password', [\App\Http\Controllers\Front\MyAccountController::class, 'changePassword'])->name('my-account/password');

    Route::get('wishlist', [App\Http\Controllers\Front\WishlistController::class, 'wishList'])->name('wishlist');
    Route::get('checkout', [App\Http\Controllers\Front\CheckoutController::class, 'checkout'])->name('checkout');
    Route::post('shippingDetail-save',  [App\Http\Controllers\Front\CheckoutController::class, 'shippingDetailSave'])->name('shippingDetail-save');
    Route::get('shipping-address-delete/{id}',
        [\App\Http\Controllers\Front\CheckoutController::class, 'shippingAddressDelete'])->name('shipping-address-delete');
    Route::post('edit-shipping-address-fetch',  [App\Http\Controllers\Front\CheckoutController::class, 'EditShippingAddressFetch'])->name('edit-shipping-address-fetch');

    Route::get('orders', [App\Http\Controllers\Front\OrdersController::class, 'orders'])->name('orders');
    Route::post('getOrder-datatable',
        [\App\Http\Controllers\Front\OrdersController::class, 'getOrder'])->name('getOrder-datatable');
    Route::get('order-detail/{id}', [App\Http\Controllers\Front\OrdersController::class, 'orderDetail'])->name('order-detail');
    Route::get('order-cancel/{id}', [App\Http\Controllers\Front\OrdersController::class, 'orderCancel'])->name('order-cancel');

    Route::post('checkout', [App\Http\Controllers\Front\PlaceOrdersController::class, 'checkout'])->name('checkout');
    Route::get('success', [App\Http\Controllers\Front\PlaceOrdersController::class, 'success'])->name('success');
    Route::get('cancel',  [App\Http\Controllers\Front\PlaceOrdersController::class, 'cancel'])->name('cancel');
});


Route::group(['prefix' => 'manage'], function () {

    Route::group(['middleware' => ['auth', 'checkStatus']], function () {

        Route::group(['middleware' => ['role:Admin|Seller']], function () {
            require_once "AdminSeller.php";
        });

        Route::group(['middleware' => ['role:Admin']], function () {
            require_once "Admin.php";
        });

        Route::group(['middleware' => ['role:Seller']], function () {
            require_once "Seller.php";
        });
    });
});
