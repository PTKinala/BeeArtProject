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

Auth::routes();

Route::get('load-cart-data', [App\Http\Controllers\Frontend\CartController::class, 'cartcount']);
Route::post('add-to-cart', [App\Http\Controllers\Frontend\CartController::class, 'addProduct']);
Route::post('delete-cart-item', [App\Http\Controllers\Frontend\CartController::class, 'deleteproduct']);
Route::post('update-cart', [App\Http\Controllers\Frontend\CartController::class, 'updatecart']);

Route::middleware(['auth'])->group(function () {
    Route::get('cart', [App\Http\Controllers\Frontend\CartController::class, 'viewCart']);
    Route::get('checkout', [App\Http\Controllers\Frontend\CheckoutController::class, 'index']);
    Route::post('place-order', [App\Http\Controllers\Frontend\CheckoutController::class, 'placeorder']);

    Route::get('my-orders', [App\Http\Controllers\Frontend\UserController::class, 'index']);
    Route::get('view-order/{id}', [App\Http\Controllers\Frontend\UserController::class, 'view']);
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

});