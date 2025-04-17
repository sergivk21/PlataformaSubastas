<?php

use App\Http\Controllers\AuctionController;
use App\Http\Controllers\BidController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\WorkerStatusController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('auctions.index');
})->name('home');

// Rutas protegidas por autenticación
Route::middleware(['auth'])->group(function () {
    // Rutas de subastas
    Route::get('/auctions', [AuctionController::class, 'index'])->name('auctions.index');
    Route::get('/auctions/create', [AuctionController::class, 'create'])->name('auctions.create');
    Route::post('/auctions', [AuctionController::class, 'store'])->name('auctions.store');
    Route::get('/auctions/{auction}', [AuctionController::class, 'show'])->name('auctions.show');
    Route::get('/auctions/{auction}/edit', [AuctionController::class, 'edit'])->name('auctions.edit');
    Route::put('/auctions/{auction}', [AuctionController::class, 'update'])->name('auctions.update');
    Route::delete('/auctions/{auction}', [AuctionController::class, 'destroy'])->name('auctions.destroy');
    Route::post('/auctions/delete-all', [AuctionController::class, 'deleteAll'])->name('auctions.delete-all');
    
    // Rutas para móvil
    Route::get('/mobile/auctions', [\App\Http\Controllers\Mobile\AuctionController::class, 'index'])->name('auctions.mobile.index');
    Route::get('/mobile/auctions/{auction}', [\App\Http\Controllers\Mobile\AuctionController::class, 'show'])->name('auctions.mobile.show');
    
    // Rutas de pujas
    Route::post('/auctions/{auction}/bid', [BidController::class, 'store'])->name('auctions.bid');
    
    // Rutas de pago
    Route::post('auctions/{auction}/checkout', [PaymentController::class, 'checkout'])->name('payment.checkout');
    Route::get('payment/success/{auction}', [PaymentController::class, 'success'])->name('payment.success');
    Route::get('payment/cancel/{auction}', [PaymentController::class, 'cancel'])->name('payment.cancel');
    
    // Rutas de perfil
    Route::middleware(['auth'])->group(function () {
        Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
        Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });

    // Perfil móvil
    Route::get('/mobile/profile', [\App\Http\Controllers\ProfileController::class, 'showMobile'])->name('profile.mobile.show');

    // Panel de administración
    Route::group(['prefix' => 'admin', 'middleware' => ['web', 'auth']], function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        
        // Gestión de usuarios
        Route::get('/users', [AdminController::class, 'users'])->name('admin.users');
        Route::get('/users/{user}/edit', [AdminController::class, 'editUser'])->name('admin.users.edit');
        Route::put('/users/{user}', [AdminController::class, 'updateUser'])->name('admin.users.update');
        
        // Gestión de subastas
        Route::get('/auctions', [AdminController::class, 'auctions'])->name('admin.auctions');
        Route::get('/auctions/{auction}/edit', [AdminController::class, 'editAuction'])->name('admin.auctions.edit');
        Route::put('/auctions/{auction}', [AdminController::class, 'updateAuction'])->name('admin.auctions.update');

        // Reportes
        Route::get('/reports', [AdminController::class, 'reports'])->name('admin.reports');
        
        // Estado del worker
        Route::get('/worker/status', [WorkerStatusController::class, 'index'])->name('worker.status');
        Route::post('/worker/ping', [WorkerStatusController::class, 'ping'])->name('worker.ping');
    });

    // Panel de administración móvil
    Route::get('/mobile/admin/dashboard', [\App\Http\Controllers\AdminController::class, 'mobileDashboard'])->name('admin.mobile.dashboard');
    // Panel de administración móvil: gestionar usuarios
    Route::get('/mobile/admin/users', [\App\Http\Controllers\AdminController::class, 'mobileUsers'])->name('admin.mobile.users');
    // Panel de administración móvil: gestionar subastas
    Route::get('/mobile/admin/auctions', [\App\Http\Controllers\AdminController::class, 'mobileAuctions'])->name('admin.mobile.auctions');
    // Panel de administración móvil: reportes
    Route::get('/mobile/admin/reports', [\App\Http\Controllers\AdminController::class, 'mobileReports'])->name('admin.mobile.reports');
});

// Rutas públicas (deben ir después de las protegidas para evitar conflictos)
Route::get('/test-active-auctions', [AuctionController::class, 'testActiveAuctions'])->name('auctions.test.active');

require __DIR__.'/auth.php';
