<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Tracks_likes extends Model
{
    protected $fillable = ["user_id", "track_id"];

    public function track(): BelongsTo
    {
        return $this->belongsTo(Track::class, "track_id");
    }
}
