<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\LineMessagingController;
use App\Http\Controllers\LineWebhookController;

// Route::get('/', function () {
//     return Inertia::render('Top', [
//         'canLogin' => Route::has('login'),
//         'canRegister' => Route::has('register'),
//         'laravelVersion' => Application::VERSION,
//         'phpVersion' => PHP_VERSION,
//     ]);
// });

Route::redirect('/', '/admin/login');
Route::redirect('/login', '/admin/login');


Route::post('/line/webhook', [LineWebhookController::class, 'handle']);

Route::prefix('admin')->group(function () {
    Route::redirect('/', '/admin/login');

    Route::get('/login',   [AdminAuthController::class, 'index'])->name('admin.login');
    Route::post('/login',  [AdminAuthController::class, 'login']);
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

    Route::middleware('auth:admin')->group(function () {
        Route::get('/dashboard', function () {
            return Inertia::render('Admin/Dashboard');
        })->name('admin.dashboard');

        Route::get('/line-message', function () {
            return Inertia::render('Admin/LineMessage');
        })->name('admin.line-message');

        Route::post('/line-message', [LineMessagingController::class, 'sendMessage']);
    });
});

// Route::get('/mypage', function () {
//     return Inertia::render('MyPage');
// })->middleware(['auth', 'verified'])->name('mypage');

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });




// require __DIR__.'/auth.php';
