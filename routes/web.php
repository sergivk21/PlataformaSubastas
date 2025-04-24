<?php

use App\Http\Controllers\AuctionController;
use App\Http\Controllers\BidController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\WorkerStatusController;
use Illuminate\Support\Facades\Route;

// Página principal adaptativa
Route::get('/', function () {
    if (
        request()->getHost() && str_contains(request()->getHost(), 'ngrok')
        || preg_match('/Mobile|Android|iPhone|iPad|iPod|Opera Mini|IEMobile|WPDesktop/i', request()->header('User-Agent'))
    ) {
        return view('home.mobile');
    }
    return view('home');
})->name('home');

// Redireccionar automáticamente a la versión móvil si el acceso es por ngrok
Route::middleware(['web'])->group(function () {
    Route::get('/login', function () {
        if (
            request()->getHost() && str_contains(request()->getHost(), 'ngrok')
            || preg_match('/Mobile|Android|iPhone|iPad|iPod|Opera Mini|IEMobile|WPDesktop/i', request()->header('User-Agent'))
        ) {
            return view('auth.mobile.login');
        }
        return view('auth.login');
    })->name('login');
});

// Página principal móvil dedicada
Route::get('/mobile/home', function () {
    return view('home.mobile');
})->name('home.mobile');

// Página principal de escritorio dedicada
Route::get('/desktop/home', function () {
    return view('home');
})->name('home.desktop');

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
    Route::get('/mobile/auctions/create', [\App\Http\Controllers\Mobile\AuctionController::class, 'create'])->name('auctions.mobile.create');
    Route::post('/mobile/auctions', [\App\Http\Controllers\Mobile\AuctionController::class, 'store'])->name('auctions.mobile.store');
    Route::get('/mobile/auctions/{auction}', [\App\Http\Controllers\Mobile\AuctionController::class, 'show'])->name('auctions.mobile.show');
    Route::delete('/mobile/auctions/{auction}', [\App\Http\Controllers\Mobile\AuctionController::class, 'destroy'])->name('auctions.mobile.destroy');
    
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
    Route::middleware(['auth'])->group(function () {
        Route::get('/mobile/profile', [ProfileController::class, 'showMobile'])->name('profile.mobile.show');
        Route::put('/mobile/profile', [ProfileController::class, 'update'])->name('profile.mobile.update');
    });

    // Panel de administración
    Route::group(['prefix' => 'admin', 'middleware' => ['web', 'auth']], function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        
        // Gestión de usuarios
        Route::get('/users', [AdminController::class, 'users'])->name('admin.users');
        Route::get('/users/{user}/edit', [AdminController::class, 'editUser'])->name('admin.users.edit');
        Route::put('/users/{user}', [AdminController::class, 'updateUser'])->name('admin.users.update');
        Route::delete('/users/{user}', [AdminController::class, 'deleteUser'])->name('admin.users.delete');
        
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
    // Vista móvil para editar usuario
    Route::get('/mobile/admin/users/{user}/edit', [\App\Http\Controllers\AdminController::class, 'editMobileUser'])->name('admin.mobile.users.edit');
    Route::put('/mobile/admin/users/{user}', [\App\Http\Controllers\AdminController::class, 'updateMobileUser'])->name('admin.mobile.users.update');
    // Panel de administración móvil: gestionar subastas
    Route::get('/mobile/admin/auctions', [\App\Http\Controllers\AdminController::class, 'mobileAuctions'])->name('admin.mobile.auctions');
    // Panel de administración móvil: reportes
    Route::get('/mobile/admin/reports', [\App\Http\Controllers\AdminController::class, 'mobileReports'])->name('admin.mobile.reports');
});

// Rutas públicas (deben ir después de las protegidas para evitar conflictos)
Route::get('/test-active-auctions', [AuctionController::class, 'testActiveAuctions'])->name('auctions.test.active');

require __DIR__.'/auth.php';
