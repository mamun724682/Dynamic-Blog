<?php

namespace App\Http\Controllers\Admin;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;

class AuthorController extends Controller
{
    public function index()
    {
    	$authors = User::authors()
    					->withCount('posts')
    					->withCount('comments')
    					->withCount('favorite_posts')
    					->get();

    	return view('admin.authors', compact('authors'));
    }

    public function destroy($id)
    {
    	User::findOrFail($id)->delete();

    	Toastr::success('User deleted successfully :)', 'Success');
    	return redirect()->back();
    }
}
