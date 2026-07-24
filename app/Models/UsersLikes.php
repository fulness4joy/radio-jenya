<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UsersLikes extends Model
{
    protected $fillable = ["user_id", "channel_id"];

    public function channel(): BelongsTo
    {
        return $this->belongsTo(Channel::class, "channel_id");
    }
}
