<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PaymentController;

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

//飲食店詳細取得機能
Route::get('/shop/{shop}', [ShopController::class, 'detail'])->name('shop.detail');

//飲食店一覧ページ検索機能
Route::get('/search', [ShopController::class, 'search']);

// 予約完了ページへの遷移
Route::get('/done', function () {
    return view('done');
});


// 予約情報追加機能
Route::post('/reservation', [ReservationController::class, 'store'])->name('reservation.store')->middleware('auth');

//お気に入り追加機能
Route::post('/favorite', [FavoriteController::class, 'addFavorite'])->name('favorite.addFavorite')->middleware('auth');

//お気に入り削除機能
Route::delete('/favorites/delete', [FavoriteController::class, 'deleteFavorite'])->name('favorites.delete')->middleware('auth');

//マイページでのお気に入り削除機能
Route::delete('/mypage/delete/', [FavoriteController::class, 'delete'])->name('mypage.delete')->middleware('auth');

//マイページお気に入り、予約情報一覧取得
Route::get('/mypage', [ShopController::class, 'mypageIndex'])->name('mypage.mypageIndex')->middleware('auth');

Route::post('/mypage', [ShopController::class, 'qrConfirm'])->name('shop.qeConfirm');

//マイページ予約削除機能
Route::delete('/reservations/{id}', [ReservationController::class, 'destroy'])->name('reservation.destroy');

// 予約情報編集フォーム表示
Route::get('/reservations/{reservation}/edit', [ReservationController::class, 'edit'])->name('reservations.edit')->middleware('auth');

// 予約情報更新
Route::put('/reservations/{reservation}', [ReservationController::class, 'update'])->name('reservations.update')->middleware('auth');


// 評価機能
Route::middleware(['auth'])->group(function () {
    Route::get('/reviews/create/{shop}', [ReviewController::class, 'create'])->name('reviews.create');
Route::post('/create', [ReviewController::class, 'store'])->name('reviews.store');
});

// Stripe決済
Route::get('/payment', [PaymentController::class, 'viewPayment']);
Route::post('/payment', [PaymentController::class, 'processPayment'])->name('payment.store');
Route::get('/payment-result', [PaymentController::class, 'paymentResult'])->name('payment.result');


// 管理者用ルート
Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'adminDashboard']);
    Route::get('/create', [AdminController::class, 'createManager'])->name('admin.create');
    Route::post('/create', [AdminController::class, 'storeManager'])->name('admin.store');
    Route::get('/notify', [AdminController::class, 'adminNotifyMail'])->name('admin.notify');
    Route::post('/notify', [AdminController::class, 'send'])->name('admin.notify.send');
});


// 店舗代表者用ルート
Route::middleware(['auth'])->prefix('manager')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'managerDashboard'])->name('manager.dashboard');
    Route::post('/dashboard', [ShopController::class, 'qrConfirm'])->name('manager.qrConfirm');
    Route::get('/create', [AdminController::class, 'shopInformation'])->name('shop.info');
    Route::post('/create', [AdminController::class, 'createShop'])->name('shop.create');
    // 以下の記述は不要？　なぜupdateShopが２つあるのか
    Route::post('/index', [AdminController::class, 'updateShop'])->name('shop.update');
    Route::get('/index', [AdminController::class, 'reservationsIndex'])->name('reservation.index');
    Route::get('/edit', [AdminController::class, 'editShop'])->name('manager.edit');
    Route::post('/edit', [AdminController::class, 'updateShop'])->name('manager.update');
    Route::get('/notify', [AdminController::class, 'managerNotifyMail'])->name('manager.notify');
    Route::post('/notify', [AdminController::class, 'send'])->name('admin.notify.send');

    
});