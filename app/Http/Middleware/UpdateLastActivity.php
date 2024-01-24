<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

class UpdateLastActivity
{
   
    public function handle(Request $request, Closure $next)
    {
         if (Auth::check()) {
            $user = Auth::user();
            $user->last_activity = now();
            $user->save();
        }
        return $next($request);
    }
}
