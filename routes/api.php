<?php

use App\Http\Controllers\AppController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommandeController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PanierController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ShopController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
  return $request->user();
});

Route::name('api.auth.')->group(function () {
  Route::post('/login',  [AuthenticatedSessionController::class, 'store'])->name('login');
  Route::post('/register', [RegisteredUserController::class, 'store'])->name('register');
  Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
});

Route::get('/home', [HomeController::class, 'index']); // shop par defaut

Route::name('api.')->middleware(['auth:sanctum'])->group(function () {

  Route::get('/profile', [ProfileController::class, 'show']);
  Route::post('/edit-profile', [ProfileController::class, 'update']);
  Route::put('/update-img-profile', [ProfileController::class, 'updateImageProfile']);

  Route::get('/my-shop', [ShopController::class, 'showMyShop']); // Shop de l'utilisateur authentifier
  Route::get('/shops', [ShopController::class, 'index']); // All shops
  Route::get('/shops/{shopId}', [ShopController::class, 'show']); //show shop

  Route::resource('/articles', ArticleController::class);
  Route::put('/articles/{articleId}/update-image', [ArticleController::class, 'updateImageArticle']);

  Route::resource('/paniers', PanierController::class);

  Route::post('/buy', [AppController::class, 'buy']);

  Route::get('/commandes', [CommandeController::class, 'index']);
});


// Route::get()
