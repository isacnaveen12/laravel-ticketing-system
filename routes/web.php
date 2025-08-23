<?php

use App\Http\Controllers\Customer\AuthController;
use App\Http\Controllers\Customer\DashboardController;
use App\Http\Controllers\Customer\TicketController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Customer Authentication Routes
Route::prefix('customer')->name('customer.')->group(function () {
    // Guest routes (not authenticated)
    Route::middleware('guest')->group(function () {
        Route::get('register', [AuthController::class, 'showRegister'])->name('register');
        Route::post('register', [AuthController::class, 'register']);
        Route::get('login', [AuthController::class, 'showLogin'])->name('login');
        Route::post('login', [AuthController::class, 'login']);
    });

    // Authenticated customer routes
    Route::middleware('auth')->group(function () {
        Route::post('logout', [AuthController::class, 'logout'])->name('logout');
        
        // Dashboard
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
        
        // Tickets
        Route::prefix('tickets')->name('tickets.')->group(function () {
            Route::get('/', [TicketController::class, 'index'])->name('index');
            Route::get('create', [TicketController::class, 'create'])->name('create');
            Route::post('/', [TicketController::class, 'store'])->name('store');
            Route::get('{ticket}', [TicketController::class, 'show'])->name('show');
            Route::post('{ticket}/comments', [TicketController::class, 'addComment'])->name('comment');
            Route::get('attachment/{attachment}/download', [TicketController::class, 'downloadAttachment'])->name('attachment.download');
        });
    });
});

// Redirect /customer to dashboard for authenticated users, login for guests
Route::get('/customer', function () {
    return auth()->check() 
        ? redirect()->route('customer.dashboard')
        : redirect()->route('customer.login');
});
