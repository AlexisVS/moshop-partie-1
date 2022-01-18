<?php

use App\Http\Controllers\AppController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CommandeController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PanierController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ShopController;
use Illuminate\Http\Request;
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


// Route::post('/tokens/create', function (Request $request) {
//     $token = $request->user()->createToken($request->token_name);

//     return ['token' => $token->plainTextToken];
// });

/* ! -------------------------------------------------------------------------- */
/* !                    Changer l'url des routes pour l'exo 2                   */
/* ! -------------------------------------------------------------------------- */

Route::prefix('/app')->group(function () {
  // /register les 3 se trouvent dans auth.php
  // /login les 3 se trouvent dans auth.php
  // /logout les 3 se trouvent dans auth.php
  Route::get('/profile', [ProfileController::class, 'show']);
  Route::post('/edit-profile', [ProfileController::class, 'update']);
  Route::put('/update-img-profile', [ProfileController::class, 'updateImageProfile']);

  Route::get('/home', [HomeController::class, 'index']); // shop par defaut

  Route::get('/my-shop', [ShopController::class, 'showMyShop']); // Shop de l'utilisateur authentifier
  Route::get('/shops', [ShopController::class, 'index']); // All shops
  Route::get('/shops/{shopId}', [ShopController::class, 'show']); //show shop

  Route::resource('/articles', ArticleController::class);
  Route::put('/articles/{articleId}/update-image', [ArticleController::class, 'updateImageArticle']);

  Route::resource('/paniers', PanierController::class);

  Route::post('/buy', [AppController::class, 'buy']);

  Route::get('/commandes', [CommandeController::class, 'index']);
});
Route::get('{any}', [AppController::class, 'index'])->where('any', '.*');

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth'])->name('dashboard');

require __DIR__ . '/auth.php';
