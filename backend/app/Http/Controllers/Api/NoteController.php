<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Movie;
use App\Models\MovieNote;
use Illuminate\Http\Request;

class NoteController extends Controller
{
    public function index(Request $request)
    {
        $notes = MovieNote::where('user_id', $request->user()->id)
            ->get()
            ->keyBy('movie_id')
            ->map(fn ($n) => $n->content);

        return response()->json($notes);
    }

    public function store(Request $request, Movie $movie)
    {
        $request->validate(['content' => 'required|string|max:2000']);

        $note = MovieNote::updateOrCreate(
            ['user_id' => $request->user()->id, 'movie_id' => $movie->id],
            ['content' => $request->content]
        );

        return response()->json($note);
    }

    public function destroy(Request $request, Movie $movie)
    {
        MovieNote::where('user_id', $request->user()->id)
            ->where('movie_id', $movie->id)
            ->delete();

        return response()->json(['ok' => true]);
    }
}
