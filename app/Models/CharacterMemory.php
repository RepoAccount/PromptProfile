<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CharacterMemory extends Model
{
    public function character()
    {
        return $this->belongsTo(Character::class);
    }

}
