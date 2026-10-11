<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    return redirect()->route('posts.index');
});

// Breeze mengarahkan user ke route 'dashboard' setelah login.
Route::get('/dashboard', function () {
    return redirect()->route('posts.index');
})->middleware('auth')->name('dashboard');

// --- Blog CRUD dengan proteksi role ---

// Harus login untuk melihat dan membuat post.
// 'create' harus SEBELUM '{post}', kalau tidak dianggap id post -> 404.
Route::middleware('auth')->group(function () {
    Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
    Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
    Route::get('/posts/{post}', [PostController::class, 'show'])->name('posts.show');
});

// Hanya admin & editor yang boleh edit/hapus.
// Kepemilikan post (editor hanya miliknya) dicek PostPolicy.
Route::middleware(['auth', 'role:admin,editor'])->group(function () {
    Route::get('/posts/{post}/edit', [PostController::class, 'edit'])->name('posts.edit');
    Route::put('/posts/{post}', [PostController::class, 'update'])->name('posts.update');
    Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');
});

// Route khusus admin (untuk testing middleware role)
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', function () {
        return 'Halaman ini hanya bisa diakses oleh role admin.';
    })->name('admin.dashboard');
});

// Profil bawaan Breeze
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Route login/register/logout bawaan Breeze
require __DIR__.'/auth.php';