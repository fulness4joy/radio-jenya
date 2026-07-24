<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Playlist extends Model
{
    protected $fillable = ["name", "description", "image", "time_start", "channel_id"];

    protected $casts = [
        'time_start' => 'datetime',
    ];

    // public function channel(): HasMany
    // {
    //     return $this->hasMany(Channel::class);
    // }

    public function channel(): BelongsTo
    {
        return $this->belongsTo(Channel::class);
    }
    public function tracks(): BelongsToMany
    {
        return $this->belongsToMany(Track::class, "tracks_to__playlists");
    }
    public function likes(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
