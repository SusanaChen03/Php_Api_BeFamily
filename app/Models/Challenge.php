<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Challenge extends Model
{
    use HasFactory;

    protected $fillable = [
        'familyName',
        'name',
        'repeat',
        'reward',
        'member_id',
        'user_id',
        'color',
        'urlReward',
        'isActive'
    ];


    public function rewards()   //many to many
    {
        return $this->belongsToMany(Reward::class);
    }
}
