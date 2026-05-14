<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Movie;

class MovieController extends Controller
{
    public function index()
    {
        return response()->json(Movie::orderBy('id')->get());
    }

    public function show(Movie $movie)
    {
        return response()->json($movie);
    }
}
