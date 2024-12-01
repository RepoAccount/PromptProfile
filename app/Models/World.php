<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class World extends Model
{
    public function characters()
    {
        return $this->belongsToMany(Character::class);
    }

}
