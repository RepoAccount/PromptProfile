<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CharacterMemory extends Model
{
    protected $fillable = [
        'character_id',
        'title',
        'context',
        'excerpt',
        'scene_trigger',
        'order'
    ];

    public function character()
    {
        return $this->belongsTo(Character::class);
    }

}
