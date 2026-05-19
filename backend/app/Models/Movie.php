<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Movie extends Model
{
    protected $fillable = [
        'title', 'year', 'rating', 'duration', 'description', 'cast', 'posterGradient', 'poster_mime',
    ];

    protected $hidden = ['poster_data'];

    protected $appends = ['has_poster'];

    protected $with = ['genres'];

    protected function casts(): array
    {
        return [
            'cast'       => 'array',
            'rating'     => 'float',
            'year'       => 'integer',
            'has_poster' => 'boolean',
        ];
    }

    public function toArray(): array
    {
        $arr = parent::toArray();
        if (isset($arr['genres']) && is_array($arr['genres'])) {
            $arr['genres'] = array_column($arr['genres'], 'name');
        }
        return $arr;
    }

    public function getHasPosterAttribute(): bool
    {
        return !is_null($this->poster_mime);
    }

    public function genres(): BelongsToMany
    {
        return $this->belongsToMany(Genre::class);
    }

    public function watchlistEntries(): HasMany
    {
        return $this->hasMany(\App\Models\Watchlist::class);
    }

    public function ratings(): HasMany
    {
        return $this->hasMany(\App\Models\Rating::class);
    }
}
