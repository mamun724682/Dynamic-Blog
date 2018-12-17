<?php

namespace App\Http\Controllers\Author;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
    	$user = Auth::user();
    	$posts = $user->posts;
    	$popular_posts = $user->posts()
    						->withCount('comments')
    						->withCount('favorite_to_users')
    						->orderBy('view_count', 'desc')
    						->orderBy('comments_count')
    						->orderBy('favorite_to_users_count')
    						->take(5)->get();
    	$total_pending_posts = $posts->where('is_approved', false)->count();
    	$total_view = $posts->sum('view_count');

    	return view('author.dashboard', compact('user', 'posts', 'popular_posts', 'total_pending_posts', 'total_view'));
    }
}
