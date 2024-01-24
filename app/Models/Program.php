<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'cover_pic',
        'logo',
        'desc',

        // Add other fields you may need for your user login history
    ];

    protected $casts = [
        'gallery_images' => 'array',

    ];

    protected $appends = ['cover_pic_url', 'logo_url', 'gallery_images_url'];

    public function getCoverPicUrlAttribute()
    {
        if ($this->cover_pic) {
            return url('storage/'.$this->cover_pic);
        }

        return null;
    }

    public function getLogoUrlAttribute()
    {
        if ($this->logo) {
            return url('storage/'.$this->logo);
        }

        return null;
    }

    public function getGalleryImagesUrlAttribute()
    {
        if ($this->gallery_images) {
            $imagesUrl = [];
            foreach ($this->gallery_images as $image) {
                $imageUrl = url('storage/'.$image);
                array_push($imagesUrl, $imageUrl);
            }

            return $imagesUrl;
        }

        return null;
    }
}
