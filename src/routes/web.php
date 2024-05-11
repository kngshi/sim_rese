<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\ReservationController;

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


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');
// ※マイページは認証で入れるように設定。

Route::get('/thanks', function () {
    return view('thanks');
});

Route::get('/', [ShopController::class, 'index']);
Route::get('/search', [ShopController::class, 'search']);


Route::get('/shop/{shop}', [ShopController::class, 'detail'])->name('shop.detail');

// 予約完了ページへの遷移
Route::get('/done', function () {
    return view('done');
});

// reservastionsテーブルへの登録
Route::post('/reservation', [ReservationController::class, 'store'])->name('reservation.store')->middleware('auth');

Route::get('/mypage', [ShopController::class, 'mypage'])->middleware('auth');


require __DIR__.'/auth.php';


