<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'post_id', 'parent_id', 'comment'];

    protected $appends = ['time', 'owner'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function replies()
    {
        return $this->hasMany(Reply::class);
    }

    public function getTimeAttribute()
    {
        return strtotime($this->created_at);
    }

    public function getOwnerAttribute()
    {
        if (auth()->check()) {
            return $this->user->id == auth()->id();
        }

        return false;
    }
}
