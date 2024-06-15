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

// 飲食店一覧取得
Route::get('/', [ShopController::class, 'index']);

//飲食店詳細取得
Route::get('/shop/{shop}', [ShopController::class, 'detail'])->name('shop.detail');

//飲食店一覧ページ検索機能
Route::get('/search', [ShopController::class, 'search']);

Route::middleware(['auth'])->group(function () {
    //サンクスページ表示
    Route::get('/thanks', function () {
        return view('thanks');
    });

    //ユーザー飲食店お気に入り一覧取得、ユーザー飲食店予約情報取得
    Route::get('/mypage', [ShopController::class, 'mypageIndex'])->name('mypage.mypageIndex');

    //お気に入り追加
    Route::post('/favorite', [FavoriteController::class, 'addFavorite'])->name('favorite.addFavorite');

    //飲食店一覧ページでのお気に入り削除
    Route::delete('/favorites/delete', [FavoriteController::class, 'deleteFavorite'])->name('favorites.delete');

    //マイページでのお気に入り削除
    Route::delete('/mypage/delete/', [FavoriteController::class, 'delete'])->name('mypage.delete');

    // 飲食店予約情報追加、QRコード作成
    Route::post('/reservation', [ReservationController::class, 'store'])->name('reservation.store');

    // 予約完了ページの表示
    Route::get('/done', [ReservationController::class, 'done'])->name('done');

    //飲食店予約情報削除
    Route::delete('/reservations/{id}', [ReservationController::class, 'destroy'])->name('reservation.destroy');

    // 飲食店予約情報変更
    Route::get('/reservations/{reservation}/edit', [ReservationController::class, 'edit'])->name('reservations.edit');
    Route::put('/reservations/{reservation}', [ReservationController::class, 'update'])->name('reservations.update');

    // 評価機能
    Route::get('/reviews/create/{shop}', [ReviewController::class, 'create'])->name('reviews.create');
    Route::post('/create', [ReviewController::class, 'store'])->name('reviews.store');

    // Stripe決済
    Route::get('/payment', [PaymentController::class, 'viewPayment']);
    Route::post('/payment', [PaymentController::class, 'processPayment'])->name('payment.store');
    Route::get('/payment-result', [PaymentController::class, 'paymentResult'])->name('payment.result');

});

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
    Route::post('/dashboard', [AdminController::class, 'qrConfirm'])->name('dashboard.qrConfirm');
    Route::get('/create', [AdminController::class, 'shopInformation'])->name('shop.info');
    Route::post('/create', [AdminController::class, 'createShop'])->name('shop.create');
    Route::get('/index', [AdminController::class, 'reservationsIndex'])->name('reservation.index');
    Route::get('/edit', [AdminController::class, 'editShop'])->name('manager.edit');
    Route::post('/edit', [AdminController::class, 'updateShop'])->name('manager.update');
    Route::get('/notify', [AdminController::class, 'managerNotifyMail'])->name('manager.notify');
    Route::post('/notify', [AdminController::class, 'send'])->name('admin.notify.send');

    Route::post('/mypage', [AdminController::class, 'qrConfirm'])->name('manager.qrConfirm');
});