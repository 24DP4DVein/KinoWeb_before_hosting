<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    protected $fillable = [
        'title', 'year', 'rating', 'genres', 'duration', 'description', 'cast', 'posterGradient', 'poster_url',
    ];

    protected function casts(): array
    {
        return [
            'genres' => 'array',
            'cast'   => 'array',
            'rating' => 'float',
            'year'   => 'integer',
        ];
    }

    public function watchlistEntries()
    {
        return $this->hasMany(\App\Models\Watchlist::class);
    }

    public function ratings()
    {
        return $this->hasMany(\App\Models\Rating::class);
    }
}
