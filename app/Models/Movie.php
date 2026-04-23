<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Movie extends Model
{
    protected $fillable = [
        'title',
        'youtube_id',
        'description',
        'year',
        'status',
        'created_by',
    ];

    public function genres(): BelongsToMany
    {
        return $this->belongsToMany(Genre::class, 'movie_genre');
    }

    public function casts(): BelongsToMany
    {
        return $this->belongsToMany(Cast::class, 'movie_cast');
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function watchlists(): HasMany
    {
        return $this->hasMany(Watchlist::class);
    }
}
