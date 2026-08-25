<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\AdminArticleController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ArticleController::class, 'home'])->name('home');

Route::get('/kategori/{category}', [ArticleController::class, 'category'])
    ->name('category')
    ->where('category', implode('|', array_keys(App\Http\Controllers\ArticleController::CATEGORIES)));

Route::get('/artikel/{article}', [ArticleController::class, 'show'])->name('article.show');

/* ---------- Auth (admin) ---------- */
Route::get('/login', [AuthController::class, 'showLogin'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'login'])->middleware('guest');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

/* ---------- Admin CRUD ---------- */
Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::resource('articles', AdminArticleController::class)->names([
        'index' => 'articles.index',
        'create' => 'articles.create',
        'store' => 'articles.store',
        'edit' => 'articles.edit',
        'update' => 'articles.update',
        'destroy' => 'articles.destroy',
    ]);
});
