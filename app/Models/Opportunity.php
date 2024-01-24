<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Opportunity extends Model
{
    use HasFactory;
     protected $fillable = [
        'title',
        'desc',
        'date',
        'documents',
        'cover_pic',

        // Add other fields you may need for your user login history
    ];

    protected $appends = ["cover_pic_url", "documents_url"];

     public function getDocumentsUrlAttribute()
    {
        if ($this->documents) {
            return url('storage/' . $this->documents);
        }
        return null;
    }

    public function getCoverUrlAttribute()
    {
        if ($this->cover_pic) {
            return url('storage/' . $this->cover_pic);
        }
        return null;
    }

}