<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CharacterSegment extends Model
{
    protected $fillable = [
        'segment_type',
        'content',
        'character_id',
        'title',
        'scene_trigger',
        'order'
    ];


    public function character()
    {
        return $this->belongsTo(Character::class);
    }

}
