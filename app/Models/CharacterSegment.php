<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CharacterSegment extends Model
{
    public function character()
    {
        return $this->belongsTo(Character::class);
    }

}
