<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Movie;
use App\Models\Rating;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    public function index(Request $request)
    {
        $ratings = Rating::where('user_id', $request->user()->id)
            ->pluck('rating', 'movie_id');

        return response()->json($ratings);
    }

    public function store(Request $request, Movie $movie)
    {
        $request->validate(['rating' => 'required|integer|min:1|max:10']);

        Rating::updateOrCreate(
            ['user_id' => $request->user()->id, 'movie_id' => $movie->id],
            ['rating' => $request->rating]
        );

        return response()->json(['ok' => true]);
    }
}
