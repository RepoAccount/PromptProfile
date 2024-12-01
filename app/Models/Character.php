<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Character extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function worlds()
    {
        return $this->belongsToMany(World::class);
    }

    public function segments()
    {
        return $this->hasMany(CharacterSegment::class);
    }

    public function memories()
    {
        return $this->hasMany(CharacterMemory::class);
    }

    public function images()
    {
        return $this->hasMany(Image::class);
    }

}
