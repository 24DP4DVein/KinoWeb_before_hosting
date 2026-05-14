<?php

use Illuminate\Support\Facades\Route;

Route::get('/', fn () => response()->json([
    'message' => 'KinoWEB API. Frontend at http://localhost:3000',
]));
