<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reward extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'image',
        'description',
        'challenge_id',
        'user_id'
    ];

    public function challenges()   //many to many
    {
        return $this->belongsToMany(Challenge::class);
    }
}