<?php

use Illuminate\Support\Facades\Auth;
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




Route::get('/', [App\Http\Controllers\Frontend\FrontendController::class, 'index']);
Route::get('shop', [App\Http\Controllers\Frontend\FrontendController::class, 'shop']);
Route::get('/make-art', [App\Http\Controllers\Frontend\FrontendController::class, 'makeArt']);
Route::get('/make-art-buy/{id}', [App\Http\Controllers\Frontend\FrontendController::class, 'makeArtBuy']);
Route::get('category/{slug}', [App\Http\Controllers\Frontend\FrontendController::class, 'viewcategory']);
Route::get('category/{cate_slug}/{prod_slug}', [App\Http\Controllers\Frontend\FrontendController::class, 'viewproduct']);
Route::get('uploader-slip/{id}', [App\Http\Controllers\Frontend\FrontendController::class, 'uploaderSlip']);
Route::post('insert-image-slip/', [App\Http\Controllers\Frontend\FrontendController::class, 'store']);
Route::get('request-return/{id}', [App\Http\Controllers\Frontend\FrontendController::class, 'requestReturn']);
Route::post('insert-request-return', [App\Http\Controllers\Frontend\FrontendController::class, 'storeRequestReturn']);



Auth::routes();

Route::get('load-cart-data', [App\Http\Controllers\Frontend\CartController::class, 'cartcount']);
Route::post('add-to-cart', [App\Http\Controllers\Frontend\CartController::class, 'addProduct']);
Route::post('delete-cart-item', [App\Http\Controllers\Frontend\CartController::class, 'deleteproduct']);
Route::post('update-cart', [App\Http\Controllers\Frontend\CartController::class, 'updatecart']);
Route::post('/price-orders', [App\Http\Controllers\Frontend\UserController::class, 'priceOrdersCalculate']);


Route::middleware(['auth'])->group(function () {
    Route::get('cart', [App\Http\Controllers\Frontend\CartController::class, 'viewCart']);
    Route::get('checkout', [App\Http\Controllers\Frontend\CheckoutController::class, 'index']);
    Route::get('/edit-item-orders/{id}', [App\Http\Controllers\Frontend\CheckoutController::class, 'itemOrders']);
    Route::put('/update-item-orders/{id}', [App\Http\Controllers\Frontend\CheckoutController::class, 'updateItemOrders']);
    Route::get('/destory-item-orders/{id}', [App\Http\Controllers\Frontend\CheckoutController::class, 'destory']);
    Route::post('place-order', [App\Http\Controllers\Frontend\CheckoutController::class, 'placeorder']);

    Route::get('my-orders', [App\Http\Controllers\Frontend\UserController::class, 'index']);
    Route::get('view-order/{id}', [App\Http\Controllers\Frontend\UserController::class, 'view']);
    Route::post('/insert-made-order', [App\Http\Controllers\Frontend\MadeOrderController::class, 'store']);
    Route::get('/edit-made-orders/{id}', [App\Http\Controllers\Frontend\MadeOrderController::class, 'edit']);
    Route::put('/update-made-order/{id}', [App\Http\Controllers\Frontend\MadeOrderController::class, 'update']);
    Route::get('/delete-made-orders/{id}', [App\Http\Controllers\Frontend\MadeOrderController::class, 'updateDestory']);

    Route::get('my-profile', [App\Http\Controllers\Frontend\ProfileController::class, 'index']);
    Route::get('/address', [App\Http\Controllers\Frontend\ProfileController::class, 'create']);
    Route::post('/user-address', [App\Http\Controllers\Frontend\ProfileController::class, 'store']);
    Route::get('/edit-address/{id}', [App\Http\Controllers\Frontend\ProfileController::class, 'edit']);
    Route::put('/update-address/{id}', [App\Http\Controllers\Frontend\ProfileController::class, 'update']);
    Route::get('/change-pass', [App\Http\Controllers\Frontend\ProfileController::class, 'change_pass']);
    Route::put('/update-pass/{id}', [App\Http\Controllers\Frontend\ProfileController::class, 'update_pass']);
});




//Admin dashboard
Route::middleware(['auth', 'isAdmin'])->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Admin\FrontendController::class, 'index']);


    //Admin category CRUD
    Route::get('categories', [App\Http\Controllers\Admin\CategoryController::class, 'index']);
    Route::get('add-category', [App\Http\Controllers\Admin\CategoryController::class, 'add']);
    Route::post('insert-category', [App\Http\Controllers\Admin\CategoryController::class, 'insert']);
    Route::get('edit-cate/{id}', [App\Http\Controllers\Admin\CategoryController::class, 'edit']);
    Route::put('update-category/{id}', [App\Http\Controllers\Admin\CategoryController::class, 'update']);
    Route::get('delete-category/{id}', [App\Http\Controllers\Admin\CategoryController::class, 'destory']);

    //Admin Product CRUD
    Route::get('products', [App\Http\Controllers\Admin\ProductController::class, 'index']);
    Route::get('add-products', [App\Http\Controllers\Admin\ProductController::class, 'add']);
    Route::post('insert-product', [App\Http\Controllers\Admin\ProductController::class, 'insert']);
    Route::get('edit-prod/{id}', [App\Http\Controllers\Admin\ProductController::class, 'edit']);
    Route::put('update-product/{id}', [App\Http\Controllers\Admin\ProductController::class, 'update']);
    Route::get('delete-product/{id}', [App\Http\Controllers\Admin\ProductController::class, 'destory']);

    //Admin Orders view
    Route::get('orders', [App\Http\Controllers\Admin\OrderController::class, 'index']);
    Route::get('admin/view-order/{id}', [App\Http\Controllers\Admin\OrderController::class, 'view']);
    Route::put('update-order/{id}', [App\Http\Controllers\Admin\OrderController::class, 'updateorder']);
    route::get('order-history', [App\Http\Controllers\Admin\OrderController::class, 'orderhistory']);
    route::put('update-tracking_no/{id}', [App\Http\Controllers\Admin\OrderController::class, 'updateTracking_no']);
    route::get('update-cancel_order/{id}', [App\Http\Controllers\Admin\OrderController::class, 'updateCancel_order']);
    route::get('update-cancel_order-open/{id}', [App\Http\Controllers\Admin\OrderController::class, 'updateCancel_order_open']);
    route::put('check-update-slip/{id}', [App\Http\Controllers\Admin\OrderController::class, 'checkUpdateSlip']);
    route::get('/order-slip', [App\Http\Controllers\Admin\OrderController::class, 'orderLisp']);
    route::get('/request-return-admin', [App\Http\Controllers\Admin\OrderController::class, 'requestReturnAdmin']);
    route::get('/admin/request-admin/{id}', [App\Http\Controllers\Admin\OrderController::class, 'OrderRequestAdmin']);

    //Admin Users view
    Route::get('users', [App\Http\Controllers\Admin\DashboardController::class, 'users']);
    Route::get('view-user/{id}', [App\Http\Controllers\Admin\DashboardController::class, 'viewuser']);

    //Admin category CRUD
    Route::get('/bank-account', [App\Http\Controllers\Admin\BankController::class, 'index']);
    Route::get('/add-bank-account', [App\Http\Controllers\Admin\BankController::class, 'create']);
    Route::post('/insert-bank-account', [App\Http\Controllers\Admin\BankController::class, 'store']);
    Route::get('/edit-bank-account/{id}', [App\Http\Controllers\Admin\BankController::class, 'edit']);
    Route::put('/update-bank-account/{id}', [App\Http\Controllers\Admin\BankController::class, 'update']);
    Route::get('/delete-bank-account/{id}', [App\Http\Controllers\Admin\BankController::class, 'destroy']);

    //Admin images  type CRUD
    Route::get('/image-type', [App\Http\Controllers\Admin\ImagesTypeController::class, 'index']);
    Route::get('/add-image-type', [App\Http\Controllers\Admin\ImagesTypeController::class, 'create']);
    Route::post('/insert-image-type', [App\Http\Controllers\Admin\ImagesTypeController::class, 'store']);
    Route::get('/edit-image-type/{id}', [App\Http\Controllers\Admin\ImagesTypeController::class, 'edit']);
    Route::put('/update-image-type/{id}', [App\Http\Controllers\Admin\ImagesTypeController::class, 'update']);
    Route::get('/delete-image-type/{id}', [App\Http\Controllers\Admin\ImagesTypeController::class, 'destroy']);


    //Admin images size CRUD
    Route::get('/image-size', [App\Http\Controllers\Admin\ImagesSizeController::class, 'index']);
    Route::get('/add-image-size', [App\Http\Controllers\Admin\ImagesSizeController::class, 'create']);
    Route::post('/insert-image-size', [App\Http\Controllers\Admin\ImagesSizeController::class, 'store']);
    Route::get('/edit-image-size/{id}', [App\Http\Controllers\Admin\ImagesSizeController::class, 'edit']);
    Route::put('/update-image-size/{id}', [App\Http\Controllers\Admin\ImagesSizeController::class, 'update']);
    Route::get('/delete-image-size/{id}', [App\Http\Controllers\Admin\ImagesSizeController::class, 'destroy']);

    //Admin images size CRUD
    Route::get('/color-type', [App\Http\Controllers\Admin\ColorsTypeController::class, 'index']);
    Route::get('/add-color-type', [App\Http\Controllers\Admin\ColorsTypeController::class, 'create']);
    Route::post('/insert-color-type', [App\Http\Controllers\Admin\ColorsTypeController::class, 'store']);
    Route::get('/edit-color-type/{id}', [App\Http\Controllers\Admin\ColorsTypeController::class, 'edit']);
    Route::put('/update-color-type/{id}', [App\Http\Controllers\Admin\ColorsTypeController::class, 'update']);
    Route::get('/delete-color-type/{id}', [App\Http\Controllers\Admin\ColorsTypeController::class, 'destroy']);

});