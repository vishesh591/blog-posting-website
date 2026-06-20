<?php

use App\Http\Controllers\Admin\BlogController as AdminBlogController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InteractionController;
use App\Http\Controllers\MediaLibraryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicBlogController;
use App\Http\Controllers\SearchController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
Route::post('/contact', [HomeController::class, 'sendContact'])->name('contact.send');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.attempt');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.store');
    Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');
    Route::get('/reset-password/{token}', [AuthController::class, 'showResetPassword'])->name('password.reset');
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');
});

Route::get('/blogs', [PublicBlogController::class, 'index'])->name('blogs.index');
Route::get('/blogs/{slug}', [PublicBlogController::class, 'show'])->name('blogs.show');
Route::get('/authors/{author}', [PublicBlogController::class, 'author'])->name('authors.show');
Route::get('/categories/{slug}', [PublicBlogController::class, 'category'])->name('categories.show');
Route::get('/tags/{slug}', [PublicBlogController::class, 'tag'])->name('tags.show');
Route::get('/search', [SearchController::class, 'index'])->name('search.index');
Route::get('/search/suggestions', [SearchController::class, 'suggestions'])->name('search.suggestions');

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/email/verify', [AuthController::class, 'verifyNotice'])->name('verification.notice');
    Route::get('/email/verify/{id}/{hash}', [AuthController::class, 'verifyEmail'])->middleware('signed')->name('verification.verify');
    Route::post('/email/verification-notification', [AuthController::class, 'resendVerification'])->middleware('throttle:6,1')->name('verification.send');

    Route::middleware('verified')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
        Route::get('/dashboard/notifications', [DashboardController::class, 'notifications'])->name('dashboard.notifications');
        Route::post('/dashboard/notifications/read', [DashboardController::class, 'markNotificationsRead'])->name('dashboard.notifications.read');

        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');

        Route::prefix('dashboard')->name('dashboard.')->middleware('role:admin,author')->group(function () {
            Route::resource('blogs', AdminBlogController::class)->except(['show']);
            Route::get('blogs/{blog}/preview', [AdminBlogController::class, 'preview'])->name('blogs.preview');
            Route::get('categories', [CategoryController::class, 'index'])->name('categories.index');
            Route::post('categories', [CategoryController::class, 'store'])->name('categories.store');
            Route::delete('categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');
            Route::get('tags', [TagController::class, 'index'])->name('tags.index');
            Route::post('tags', [TagController::class, 'store'])->name('tags.store');
            Route::delete('tags/{tag}', [TagController::class, 'destroy'])->name('tags.destroy');
            Route::get('media', [MediaLibraryController::class, 'index'])->name('media.index');
            Route::post('media', [MediaLibraryController::class, 'store'])->name('media.store');
            Route::put('media/{media}', [MediaLibraryController::class, 'update'])->name('media.update');
            Route::delete('media/{media}', [MediaLibraryController::class, 'destroy'])->name('media.destroy');
            Route::get('media/{media}/download', [MediaLibraryController::class, 'download'])->name('media.download');
        });

        Route::post('/blogs/{blog}/comments', [CommentController::class, 'store'])->name('comments.store');
        Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
        Route::post('/blogs/{blog}/like', [InteractionController::class, 'like'])->name('blogs.like');
        Route::post('/blogs/{blog}/bookmark', [InteractionController::class, 'bookmark'])->name('blogs.bookmark');
    });
});
