<?php

use App\Http\Controllers\Api\AddressController;
use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\CheckoutController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\SubCategoryController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\UserController;
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


Route::controller(AuthController::class)
    ->group(function () {
        Route::post('/register', 'register');
        Route::post('/login', 'login');
        Route::post('/logout', 'logout')->middleware('auth:sanctum');
    });

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [UserController::class, 'getAuthenticatedUser']);

    Route::controller(ProfileController::class)
        ->prefix('profile/update')
        ->group(function () {
            Route::post('/user-info', 'userInfoUpdate');
            Route::post('/user-address', 'userAddressUpdate');
            Route::post('/user-password', 'changePassword');
        });

    Route::controller(ProductController::class)
        ->prefix('products')
        ->group(function () {
            Route::get('/check-slug', 'checkSlug');
            Route::get('/generate-discount', 'generateDiscount');
        });

    Route::controller(CartController::class)
        ->prefix('cart')
        ->group(function () {
            Route::get('/products', 'index');
            Route::post('/add', 'store');
            Route::put('/{product}', 'update');
            Route::delete('/{product}', 'destroy');
            Route::delete('/', 'clearCart');
        });

    Route::controller(CheckoutController::class)
        ->group(function () {
            Route::get('checkout', 'getUserInfo');
            // Route::get('checkout', 'getSession');
            Route::post('purchase', 'purchase');
        });

    Route::controller(AddressController::class)
        ->group(function () {
            Route::get('/regions', 'getRegions');
            Route::get('/districts', 'getDistricts');
            Route::get('/townships', 'getTownships');
        });

    Route::apiResources([
        'products' => ProductController::class,
        'categories' => CategoryController::class,
        'sub_categories' => SubCategoryController::class,
    ]);
});
