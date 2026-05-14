<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
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
            'title'          => 'required|string|max:255',
            'year'           => 'required|integer|min:1888|max:2100',
            'rating'         => 'required|numeric|min:0|max:10',
            'genres'         => 'required|array|min:1',
            'genres.*'       => 'string',
            'duration'       => 'required|string|max:20',
            'description'    => 'required|string',
            'cast'           => 'required|array|min:1',
            'cast.*'         => 'string',
            'posterGradient' => 'required|string',
        ]);

        $movie = Movie::create($data);
        return response()->json($movie, 201);
    }

    public function update(Request $request, Movie $movie)
    {
        $data = $request->validate([
            'title'          => 'required|string|max:255',
            'year'           => 'required|integer|min:1888|max:2100',
            'rating'         => 'required|numeric|min:0|max:10',
            'genres'         => 'required|array|min:1',
            'genres.*'       => 'string',
            'duration'       => 'required|string|max:20',
            'description'    => 'required|string',
            'cast'           => 'required|array|min:1',
            'cast.*'         => 'string',
            'posterGradient' => 'required|string',
        ]);

        $movie->update($data);
        return response()->json($movie);
    }

    public function destroy(Movie $movie)
    {
        if ($movie->poster_url) {
            $this->deletePosterFile($movie->poster_url);
        }
        $movie->delete();
        return response()->json(['ok' => true]);
    }

    public function uploadPoster(Request $request, Movie $movie)
    {
        $request->validate(['poster' => 'required|image|max:5120']);

        if ($movie->poster_url) {
            $this->deletePosterFile($movie->poster_url);
        }

        $uploadDir = public_path('uploads/posters');
        if (! is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $file     = $request->file('poster');
        $filename = uniqid('poster_') . '.' . $file->getClientOriginalExtension();
        $file->move($uploadDir, $filename);

        $movie->update(['poster_url' => '/uploads/posters/' . $filename]);

        return response()->json(['poster_url' => $movie->poster_url]);
    }

    public function stats()
    {
        $movies = Movie::withCount(['watchlistEntries', 'ratings'])
            ->withAvg('ratings', 'rating')
            ->orderByDesc('watchlist_entries_count')
            ->get()
            ->map(fn ($m) => [
                'id'              => $m->id,
                'title'           => $m->title,
                'year'            => $m->year,
                'rating'          => $m->rating,
                'watchlist_count' => $m->watchlist_entries_count,
                'ratings_count'   => $m->ratings_count,
                'avg_user_rating' => $m->ratings_avg_rating ? round($m->ratings_avg_rating, 1) : null,
            ]);

        return response()->json($movies);
    }

    private function deletePosterFile(string $posterUrl): void
    {
        $path = public_path(ltrim($posterUrl, '/'));
        if (file_exists($path)) {
            unlink($path);
        }
    }
}
