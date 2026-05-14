<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\MovieController;
use App\Http\Controllers\Api\WatchlistController;
use App\Http\Controllers\Api\RatingController;
use App\Http\Controllers\Api\AdminMovieController;
use App\Http\Controllers\Api\NoteController;
use Illuminate\Support\Facades\Route;

Route::get('/health', fn () => response()->json(['ok' => true]));

Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login',    [AuthController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::get('/user',   [AuthController::class, 'user']);
    });
});

Route::get('/movies',               [MovieController::class, 'index']);
Route::get('/movies/{movie}',       [MovieController::class, 'show']);
Route::get('/movies/{movie}/poster',[MovieController::class, 'poster']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/watchlist',              [WatchlistController::class, 'index']);
    Route::post('/watchlist/{movie}',     [WatchlistController::class, 'store']);
    Route::delete('/watchlist/{movie}',   [WatchlistController::class, 'destroy']);

    Route::get('/ratings',            [RatingController::class, 'index']);
    Route::post('/ratings/{movie}',   [RatingController::class, 'store']);

    Route::get('/notes',              [NoteController::class, 'index']);
    Route::post('/notes/{movie}',     [NoteController::class, 'store']);
    Route::delete('/notes/{movie}',   [NoteController::class, 'destroy']);
});

Route::middleware(['auth:sanctum', 'admin'])->prefix('admin')->group(function () {
    Route::get('/movies',                          [AdminMovieController::class, 'index']);
    Route::post('/movies',                         [AdminMovieController::class, 'store']);
    Route::put('/movies/{movie}',                  [AdminMovieController::class, 'update']);
    Route::delete('/movies/{movie}',               [AdminMovieController::class, 'destroy']);
    Route::post('/movies/{movie}/poster',          [AdminMovieController::class, 'uploadPoster']);
    Route::get('/stats',                           [AdminMovieController::class, 'stats']);
});
