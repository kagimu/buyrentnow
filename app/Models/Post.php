<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $table = 'posts';

    protected $fillable = [
        'user_id',
        'owner',
        'contact',
        'profile_pic',
        'bedroom',
        'bathroom',
        'desc',
        'price',
        'location',
        'status',
        'size',
        'type',
        'quick_true',
        'video',
    ];

    protected $casts = [
        'images' => 'array',

    ];

    protected $appends = ['profile_pic_url', 'video_url', 'post_images'];

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function isLikedByLoggedInUser()
    {
        return $this->likes->contains('user_id', auth()->user()->id);
    }

    public function getProfilePicUrlAttribute()
    {
        if ($this->profile_pic) {
            return url('storage/'.$this->profile_pic);
        }

        return null;
    }

    public function getVideoUrlAttribute()
    {
        if ($this->video) {
            return url('storage/'.$this->video);
        }

        return null;
    }

    public function getPostImagesAttribute()
    {
        if ($this->images) {
            $imagesUrl = [];
            foreach ($this->images as $image) {
                $imageUrl = url('storage/'.$image);
                array_push($imagesUrl, $imageUrl);
            }

            return $imagesUrl;
        }

        return null;
    }
}
