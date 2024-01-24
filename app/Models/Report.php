<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;
     protected $fillable = [
        'title',
        'desc',
        'year',
        'reports',
        

        // Add other fields you may need for your user login history
    ];

     public function getReportsUrlAttribute()
    {
        if ($this->reports) {
            return url('storage/' . $this->reports);
        }
        return null;
    }

}