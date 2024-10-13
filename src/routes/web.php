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

require __DIR__ . '/auth.php';

Route::get('/', [ShopController::class, 'index']);
Route::get('/detail/{shop}', [ShopController::class, 'detail'])->name('detail');
Route::get('/search', [ShopController::class, 'search']);

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/thanks', [UserController::class, 'thanks'])->name('thanks');

    Route::get('/mypage', [ShopController::class, 'mypageIndex'])->name('mypage.mypageIndex');
    Route::delete('/mypage/delete/', [FavoriteController::class, 'delete'])->name('mypage.delete');

    Route::post('/favorite', [FavoriteController::class, 'addFavorite'])->name('favorite.addFavorite');
    Route::delete('/favorites/delete', [FavoriteController::class, 'deleteFavorite'])->name('favorites.delete');

    Route::post('/reservation', [ReservationController::class, 'store'])->name('reservation.store');
    Route::get('/done', [ReservationController::class, 'done'])->name('done');

    Route::get('/reservations/{reservation}/edit', [ReservationController::class, 'edit'])->name('reservations.edit');
    Route::put('/reservations/{reservation}', [ReservationController::class, 'update'])->name('reservations.update');
    Route::delete('/reservations/{id}', [ReservationController::class, 'destroy'])->name('reservation.destroy');

    Route::get('/reviews/create/{shop}', [ReviewController::class, 'create'])->name('reviews.create');
    Route::post('/create', [ReviewController::class, 'store'])->name('reviews.store');

    Route::get('reviews/{review}/edit', [ReviewController::class, 'edit'])->name('reviews.edit');
    Route::put('reviews/{review}', [ReviewController::class, 'update'])->name('reviews.update');
    Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');
    Route::get('/detail/{shop}/reviews', [ReviewController::class, 'index'])->name('reviews.index');

    Route::get('/payment', [PaymentController::class, 'viewPayment']);
    Route::post('/payment', [PaymentController::class, 'processPayment'])->name('payment.store');
    Route::get('/payment-result', [PaymentController::class, 'paymentResult'])->name('payment.result');
});

// 管理者用ルート
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'adminDashboard']);
    Route::get('/create', [AdminController::class, 'createManager'])->name('admin.create');
    Route::post('/create', [AdminController::class, 'storeManager'])->name('admin.store');
    Route::get('/notify', [AdminController::class, 'adminNotifyMail'])->name('admin.notify');
    Route::post('/notify', [AdminController::class, 'send'])->name('admin.notify.send');
});


// 店舗代表者用ルート
Route::middleware(['auth', 'manager'])->prefix('manager')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'managerDashboard'])->name('manager.dashboard');
    Route::post('/dashboard', [AdminController::class, 'qrConfirm'])->name('dashboard.qrConfirm');
    Route::get('/create', [AdminController::class, 'shopInformation'])->name('shop.info');
    Route::post('/create', [AdminController::class, 'createShop'])->name('shop.create');
    Route::get('/index', [AdminController::class, 'reservationsIndex'])->name('reservation.index');
    Route::get('/edit', [AdminController::class, 'editShop'])->name('manager.edit');
    Route::post('/edit', [AdminController::class, 'updateShop'])->name('manager.update');
    Route::get('/notify', [AdminController::class, 'managerNotifyMail'])->name('manager.notify');
    Route::post('/notify', [AdminController::class, 'send'])->name('admin.notify.send');

    Route::get('/reservation/confirm/{id}', [AdminController::class, 'qrConfirm'])->name('reservation.confirm');
});
