<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    protected $fillable = [
        'title', 'year', 'rating', 'genres', 'duration', 'description', 'cast', 'posterGradient', 'poster_mime',
    ];

    protected $hidden = ['poster_data'];

    protected $appends = ['has_poster'];

    protected function casts(): array
    {
        return [
            'genres'     => 'array',
            'cast'       => 'array',
            'rating'     => 'float',
            'year'       => 'integer',
            'has_poster' => 'boolean',
        ];
    }

    public function getHasPosterAttribute(): bool
    {
        return !is_null($this->poster_mime);
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
