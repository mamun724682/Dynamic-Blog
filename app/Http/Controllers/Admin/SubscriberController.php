<?php

namespace App\Http\Controllers\Admin;

use App\Subscriber;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;

class SubscriberController extends Controller
{
    public function index()
    {
    	$subscribers = Subscriber::latest()->get();
    	return view('admin.subscriber', compact('subscribers'));
    }

    public function destroy($subscriber)
    {
    	Subscriber::findOrFail($subscriber)->delete();
    	Toastr::success('Subscriber deleted successfully :)', 'Success');
        return redirect()->back();
    }
}
