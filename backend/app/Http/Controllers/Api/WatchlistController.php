<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Movie;
use App\Models\Watchlist;
use Illuminate\Http\Request;

class WatchlistController extends Controller
{
    public function index(Request $request)
    {
        $ids = Watchlist::where('user_id', $request->user()->id)->pluck('movie_id');

        return response()->json($ids);
    }

    public function store(Request $request, Movie $movie)
    {
        Watchlist::firstOrCreate([
            'user_id' => $request->user()->id,
            'movie_id' => $movie->id,
        ]);

        return response()->json(['ok' => true]);
    }

    public function destroy(Request $request, Movie $movie)
    {
        Watchlist::where('user_id', $request->user()->id)
            ->where('movie_id', $movie->id)
            ->delete();

        return response()->json(['ok' => true]);
    }
}
