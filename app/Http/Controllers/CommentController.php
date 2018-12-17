<?php

namespace App\Http\Controllers;

use App\Comment;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request, $post)
    {
    	$this->validate($request, [
    		'comment' => 'required'
    	]);

    	$comment = new Comment;
    	$comment->post_id = $post;
    	$comment->user_id = Auth::id();
    	$comment->comment = $request->comment;
    	$comment->save();

    	Toastr::success('Comment published successfully :)', 'Success');
        return redirect()->back();
    }
}