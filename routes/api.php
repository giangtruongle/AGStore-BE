<?php

use App\Http\Controllers\Api\V1\UserController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\Client\V1\CartController;
use App\Http\Controllers\Api\Client\V1\CategoryController;
use App\Http\Controllers\Api\Client\V1\HomeController;
use App\Http\Controllers\Api\Client\V1\PlaceOrderController;
use App\Http\Controllers\Api\Client\V1\ProductCartController;
use App\Http\Controllers\Api\Client\V1\ProductController as V1ProductController;
use App\Http\Controllers\Api\V1\ProductCategoryController;
use App\Http\Controllers\Api\V1\ProductController;
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
// header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
// header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token, Authorization, Accept,charset,boundary,Content-Length');
// header('Access-Control-Allow-Origin: *');

Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class,'register']);
Route::get('getCategory', [CategoryController::class, 'getCategory']);
Route::get('fetchProducts/{slug}', [CategoryController::class, 'getProducts']);


Route::middleware('auth:sanctum', 'isApiAdmin')->group(function(){
    Route::get('/checkAuthenicated', function(){
        return response()->json(['message'=>'Your are in', 'status'=>200],200);
    });
});

Route::middleware('auth:sanctum')->group(function(){
    Route::post('logout', [AuthController::class, 'logout']);
    Route::apiResource('v1/users', UserController::class);
    Route::apiResource('v1/product-category', ProductCategoryController::class);
    Route::apiResource('v1/product', ProductController::class);

});

Route::get('client/v1/categorie_list', [CategoryController::class, 'showCategory']);
Route::apiResource('client/v1/list_products', HomeController::class);
Route::post('client/v1/add-to-cart', [ProductCartController::class, 'addProductToCart']);
Route::get('client/v1/shopping-cart', [ProductCartController::class, 'showListCart']);
Route::put('client/v1/cart-updateQuantity/{cart_id}/{scope}', [ProductCartController::class, 'updateQuantity']);
Route::delete('client/v1/delete-cart-item/{cart_id}',[ProductCartController::class, 'deleteCartItem']);
Route::post('client/v1/place-order',[PlaceOrderController::class, 'placeOrder']);








