<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});



// Users authantication
Route::post('/login',[App\Http\Controllers\api\LoginApiController::class, 'login']);
Route::post('/signup',[App\Http\Controllers\api\LoginApiController::class, 'signup']);
Route::get('/logout', [App\Http\Controllers\api\LoginApiController::class, 'logout']);
// Users authantication


Route::get('/shop', [App\Http\Controllers\fashi\UsersController::class, 'shop']);
Route::get('/', [App\Http\Controllers\fashi\UsersController::class, 'index']);
Route::post('/product/add-to-cart/{id}', [App\Http\Controllers\fashi\UsersController::class, 'addToCart']);
Route::get('/cart', [App\Http\Controllers\fashi\UsersController::class, 'shoppingCart']);
Route::get('/checkout', [App\Http\Controllers\fashi\UsersController::class, 'checkout']);

Route::get('/product', [App\Http\Controllers\api\UsersController::class, 'product']);


Route::get('/category', [App\Http\Controllers\api\HomeApiController::class, 'category']);
Route::get('/blog', [App\Http\Controllers\api\HomeApiController::class, 'blog']);



// Route::middleware('auth:api')->group(function () {
//     Route::get('get-user', [PassportAuthController::class, 'userInfo']);
// });