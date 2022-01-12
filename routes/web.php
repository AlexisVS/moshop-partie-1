<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Models\Shop;
use App\Models\User;
use Carbon\Carbon;
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


Route::get('{any}', function () {
    $data = ['data' => [
        'users' => User::all(),
        'shops' => Shop::all(),
    ]];

    return view('app', $data);
})->where('any', '.*');

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth'])->name('dashboard');

require __DIR__ . '/auth.php';
