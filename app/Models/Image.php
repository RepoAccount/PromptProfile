<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $fillable = [
        'character_id',
        'type',
        'file_path',
        'description'
    ];

    public function character()
    {
        return $this->belongsTo(Character::class);
    }
}
