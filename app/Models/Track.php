<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Track extends Model
{
    protected $fillable = ["name", "description", "image", "path", "status", "time"];

    public function playlists(): BelongsToMany
    {
        return $this->belongsToMany(Playlist::class, "tracks_to__playlists");
    }
    
    public function likes(): HasMany
    {
        return $this->hasMany(Tracks_likes::class, "track_id");
    }
}
