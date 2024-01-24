<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Models\Impact;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
     public function dashboard()
    {
        session(['title' => 'Dashboard']);

        $posts = number_format(Post::count());
        $impacts = number_format(Impact::count());
        $clients = number_format(User::where('role', 'client')->count());

        $active_clients = User::withCount(['posts', 'impacts'])
            ->where('role', 'client')
            ->orderByDesc(DB::raw('posts_count + impacts_count'))
            ->take(10)
            ->get();

        return view('dashboard', compact('posts', 'impacts', 'clients', 'active_clients'));
    }
}
