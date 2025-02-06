<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Character extends Model
{
    protected $fillable = [
        'name',
        'user_id',
        'profile_image_id',
        'main_prompt',
        'writing_prompt',
        'misc_prompt'
    ];

    protected $with = ['segments'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function worlds()
    {
        return $this->belongsToMany(World::class);
    }

    public function profile_image()
    {
        return $this->belongsTo(Image::class, 'profile_image_id');
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
