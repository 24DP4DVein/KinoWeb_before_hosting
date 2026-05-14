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

    public function poster(Movie $movie)
    {
        if (!$movie->poster_mime || !$movie->poster_data) {
            abort(404);
        }

        return response($movie->poster_data, 200)
            ->header('Content-Type', $movie->poster_mime)
            ->header('Cache-Control', 'public, max-age=31536000');
    }
}
