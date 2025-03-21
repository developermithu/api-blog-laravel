<?php

use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


// Authenticated Routes
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // Only admin can create, edit and delete posts
    Route::apiResource('posts', PostController::class)->except(['index', 'show']);

    Route::post('posts/{id}/restore', [PostController::class, 'restore'])->name('restore');
    Route::delete('posts/{id}/force-delete', [PostController::class, 'forceDelete'])->name('force-delete');

});

// Anyone can view posts
Route::get('posts', [PostController::class, 'index']);
Route::get('posts/{post}', [PostController::class, 'show']);

Route::get('categories', [CategoryController::class, 'index']);

