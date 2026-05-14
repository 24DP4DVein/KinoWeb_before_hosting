<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MovieNote extends Model
{
    protected $fillable = ['user_id', 'movie_id', 'content'];

    public function movie()
    {
        return $this->belongsTo(Movie::class);
    }
}
