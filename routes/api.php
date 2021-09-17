<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ShopController;
use App\Http\Controllers\Api\HomepageController;
use App\Http\Controllers\AuthController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Route::middleware('auth:sanctum')->get('/test', function() {
//     return 'ovo je test';
// });


// Protected routes, with sanctum middleware
Route::middleware('auth:sanctum')->group(function() {

    Route::get('/test', function() {
        return 'Token je prošao autentifikaciju';
    });

    Route::post('/logout', [AuthController::class, 'logout']);
});



// Public routes
Route::get('/', [HomepageController::class, 'index']);
Route::get('/pizza', [ShopController::class, 'pizza']);
Route::get('/bbq', [ShopController::class, 'bbq']);
Route::get('/drinks', [ShopController::class, 'drinks']);
Route::get('/product/{slug}', [ShopController::class, 'show']);

Route::get('/addons', [ShopController::class, 'addons']);
Route::get('/addonOptions', [ShopController::class, 'addonOptions']);


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

