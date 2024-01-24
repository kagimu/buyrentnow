<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserLoginHistory extends Model
{
    use HasFactory;
     protected $fillable = [
        'login_date',
        // Add other fields you may need for your user login history
    ];

}
