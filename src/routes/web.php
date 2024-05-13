<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\FavoriteController;

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

require __DIR__.'/auth.php';


Route::get('/thanks', function () {
    return view('thanks');
});

Route::get('/', [ShopController::class, 'index']);
Route::get('/search', [ShopController::class, 'search']);


Route::post('/shop/toggle-favorite', [ShopController::class, 'toggleFavorite'])->name('shop.toggleFavorite')->middleware('auth');

Route::get('/shop/{shop}', [ShopController::class, 'detail'])->name('shop.detail');

// 予約完了ページへの遷移
Route::get('/done', function () {
    return view('done');
});

// reservastionsテーブルへの登録
Route::post('/reservation', [ReservationController::class, 'store'])->name('reservation.store')->middleware('auth');

//お気に入り追加機能
Route::post('/favorite', [FavoriteController::class, 'addFavorite'])->name('favorite.addFavorite')->middleware('auth');

//お気に入り削除機能
Route::delete('/favorites/delete', [FavoriteController::class, 'deleteFavorite'])->name('favorites.delete')->middleware('auth');

//お気に入り一覧取得機能
Route::get('/mypage', [FavoriteController::class, 'favoriteIndex'])->middleware('auth');

//マイページでのお気に入り削除機能
Route::delete('/mypage/delete/', [FavoriteController::class, 'delete'])->name('mypage.delete')->middleware('auth');

