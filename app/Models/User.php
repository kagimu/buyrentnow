<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'category_id',
        'user_id',
        'profile_pic',
        'name',
        'first_name',
        'last_name',
        'password',
        'email',
        'last_activity',
        'online',
        'city',
        'country',
        'region',
        'userIp',

    ];

    protected $hidden = [
        'password',
        'remember_token',
        'fcm_token',
    ];

    protected $appends = ['name', 'profile_pic_url'];

    public function getProfilePicUrlAttribute()
    {
        if ($this->profile_pic) {
            return url('storage/'.$this->profile_pic);
        }

        return null;
    }

    public function posts()
    {

        return $this->hasMany(Post::class);
    }

    public function impacts()
    {

        return $this->hasMany(Impact::class);
    }

    public function getNameAttribute()
    {
        return $this->first_name.' '.$this->last_name;
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function loginHistory()
    {
        return $this->hasMany(UserLoginHistory::class);
    }
}
