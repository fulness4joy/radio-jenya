<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Channel extends Model
{
    protected $fillable = ["name", "description", "image"];

    public function likes(): HasMany
    {
        return $this->hasMany(UsersLikes::class, "channel_id");
    }
}
