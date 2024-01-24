<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    use HasFactory;
     protected $fillable = [
        'partner_name',
        'partner_category',
        'cover_pic',
        'desc',

        // Add other fields you may need for your user login history
    ];

    protected $casts = [
        'programs_supported_images' => 'array',
        
    ];

    protected $appends = ["cover_pic_url", "programs_supported_images_url"];

     public function getCover_picUrlAttribute()
    {
        if ($this->cover_pic) {
            return url('storage/' . $this->cover_pic);
        }
        return null;
    }

     public function getProgramsSupportedImagesAttribute()
    {
        if ($this->programs_supported_images) {
            $imagesUrl = [];
            foreach($this->programs_supported_images as $image){
                $imageUrl = url('storage/' . $image);
                array_push($imagesUrl, $imageUrl);
            }
            return $imagesUrl;
        }
        return null;
    }

}