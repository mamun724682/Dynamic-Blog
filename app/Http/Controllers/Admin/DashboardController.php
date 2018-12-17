<?php

namespace App\Http\Controllers\Admin;

use App\Tag;
use App\Post;
use App\User;
use App\Category;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
    	$posts = Post::all();
    	$popular_posts = Post::approved()
    						->published()
    						->withCount('comments')
    						->withCount('favorite_to_users')
    						->orderBy('view_count', 'desc')
    						->orderBy('comments_count', 'desc')
    						->orderBy('favorite_to_users_count', 'desc')
    						->take(5)->get();

    	$total_pending_posts = Post::where('is_approved', false)->count();
    	$total_views = Post::sum('view_count');
    	$author_count = User::where('role_id', 2)->count();
    	$new_author_today = User::where('role_id', 2)
    							->where('created_at', Carbon::today())->count();
    	$active_authors = User::where('role_id', 2)
    						->withCount('posts')
    						->withCount('comments')
    						->withCount('favorite_posts')
    						->orderBy('posts_count', 'desc')
    						->orderBy('comments_count', 'desc')
    						->orderBy('favorite_posts_count', 'desc')
    						->take(10)->get();
    						
    	$categories_count = Category::all()->count();
    	$tags_count = Tag::all()->count();


    	return view('admin.dashboard', compact('posts', 'popular_posts', 'total_pending_posts', 'total_views', 'author_count', 'new_author_today', 'active_authors', 'categories_count', 'tags_count'));
    }
}
