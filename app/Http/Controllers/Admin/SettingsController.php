<?php

namespace App\Http\Controllers\Admin;

use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class SettingsController extends Controller
{
	public function settings()
	{
		return view('admin.settings');
	}

	public function updateProfile(Request $request)
	{
		$this->validate($request, [
			'name' => 'required',
			'email' => 'required|email',
			'image' => 'image',
		]);

		$image = $request->file('image');
		$slug = str_slug($request->name);
		$user = User::findOrFail(Auth::id());

		if (isset($image)) {

            // Make unique name for image
			$currentDate = Carbon::now()->toDateString();
			$imageName = $slug.'-'.$currentDate.'-'.uniqid().'.'.$image->getClientOriginalExtension();

            // Check category dir exists
			if (!Storage::disk('public')->exists('profile')) {
				Storage::disk('public')->makeDirectory('profile');
			}

            // Delete old bigWide image
			if (Storage::disk('public')->exists('profile/'.$user->image)) {
				Storage::disk('public')->delete('profile/'.$user->image);
			}

            // Resize image for category and upload
			$resizedImg = Image::make($image)->resize(500,500)->stream();
			Storage::disk('public')->put('profile/'.$imageName, $resizedImg);
		} else {
			$imageName = $user->image;
		}

		$user->name = $request->name;
		$user->email = $request->email;
		$user->image = $imageName;
		$user->about = $request->about;
		$user->save();

		Toastr::success('Profile updated successfully :)', 'Success');
		return redirect()->back();
	}

	public function UpdatePassword(Request $request)
	{
		$this->validate($request, [
			'old_password' => 'required',
			'password' => 'required|confirmed'
		]);

		$hashedPassword = Auth::user()->password;

		if (Hash::check($request->old_password, $hashedPassword)) {
			if (!Hash::check($request->password, $hashedPassword)) {
				$user = User::findOrFail(Auth::id());
				$user->password = Hash::make($request->password);
				$user->save();

				Toastr::success('Password changed successfully :)', 'Success');

				Auth::logout();

				return redirect()->back();
			} else {
				Toastr::error('New password cannot be the same as old password :(', 'Error');
				return redirect()->back();
			}
		} else {
			Toastr::error('Current password not matched :(', 'Error');
			return redirect()->back();
		}
	}
}