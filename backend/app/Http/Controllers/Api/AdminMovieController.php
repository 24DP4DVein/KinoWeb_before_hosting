<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Genre;
use App\Models\Movie;
use Illuminate\Http\Request;

class AdminMovieController extends Controller
{
    public function index()
    {
        $movies = Movie::withCount('watchlistEntries')->orderBy('id')->get();
        return response()->json($movies);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'year' => 'required|integer|min:1888|max:2100',
            'rating' => 'required|numeric|min:0|max:10',
            'genres' => 'required|array|min:1',
            'genres.*' => 'string',
            'duration' => 'required|string|max:20',
            'description' => 'required|string',
            'cast' => 'required|array|min:1',
            'cast.*' => 'string',
            'posterGradient' => 'required|string',
            'poster' => 'nullable|image|max:3072',
        ]);

        $genreNames = $data['genres'];
        unset($data['genres']);

        $movie = Movie::create($data);

        $genreIds = collect($genreNames)
            ->map(fn ($name) => Genre::firstOrCreate(['name' => $name])->id);
        $movie->genres()->sync($genreIds);

        if ($request->hasFile('poster')) {
            $file = $request->file('poster');
            $movie->poster_data = file_get_contents($file->getRealPath());
            $movie->poster_mime = $file->getMimeType();
            $movie->save();
        }

        return response()->json($movie->fresh(), 201);
    }

    public function update(Request $request, Movie $movie)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'year' => 'required|integer|min:1888|max:2100',
            'rating' => 'required|numeric|min:0|max:10',
            'genres' => 'required|array|min:1',
            'genres.*' => 'string',
            'duration' => 'required|string|max:20',
            'description' => 'required|string',
            'cast' => 'required|array|min:1',
            'cast.*' => 'string',
            'posterGradient' => 'required|string',
            'poster' => 'nullable|image|max:3072',
        ]);

        $genreNames = $data['genres'];
        unset($data['genres']);

        $movie->update($data);

        $genreIds = collect($genreNames)
            ->map(fn ($name) => Genre::firstOrCreate(['name' => $name])->id);
        $movie->genres()->sync($genreIds);

        if ($request->hasFile('poster')) {
            $file = $request->file('poster');
            $movie->poster_data = file_get_contents($file->getRealPath());
            $movie->poster_mime = $file->getMimeType();
            $movie->save();
        }

        return response()->json($movie->fresh());
    }

    public function destroy(Movie $movie)
    {
        $movie->delete();
        return response()->json(['ok' => true]);
    }

    public function uploadPoster(Request $request, Movie $movie)
    {
        $request->validate(['poster' => 'nullable|image|max:3072']);

        if (!$request->hasFile('poster')) {
            return response()->json(['has_poster' => $movie->has_poster]);
        }

        $file = $request->file('poster');
        $movie->poster_data = file_get_contents($file->getRealPath());
        $movie->poster_mime = $file->getMimeType();
        $movie->save();

        return response()->json(['has_poster' => true]);
    }

    public function stats()
    {
        $movies = Movie::withCount(['watchlistEntries', 'ratings'])
            ->withAvg('ratings', 'rating')
            ->orderByDesc('watchlist_entries_count')
            ->get()
            ->map(fn ($m) => [
                'id' => $m->id,
                'title' => $m->title,
                'year' => $m->year,
                'rating' => $m->rating,
                'watchlist_count' => $m->watchlist_entries_count,
                'ratings_count' => $m->ratings_count,
                'avg_user_rating' => $m->ratings_avg_rating ? round($m->ratings_avg_rating, 1) : null,
            ]);

        return response()->json($movies);
    }
}
