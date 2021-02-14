<?php
namespace App\Http\Controllers;

use App\Http\Requests\ProfileRequest;
use App\Http\Requests\PasswordRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;

use File;
use Image;

class ProfileController extends Controller
{
    /**
     * Show the form for editing the profile.
     *
     * @return \Illuminate\View\View
     */
    public function edit()
    {
        \LogActivity::addToLog();
        return view('profile.edit');
    }

    /**
     * Update the profile
     *
     * @param  \App\Http\Requests\ProfileRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */    
    public function update(ProfileRequest $request)
    {
		$path = public_path().'/images/'.auth()->user()->username;
        File::makeDirectory($path, $mode = 0777, true, true);

        $file=$request->file('avatar');

		if($file){

                $img = Image::make($file->getRealPath());
				
				list($width, $height) = getimagesize($file->getRealPath());

				// Calculate ratio of desired maximum sizes and original sizes
				$widthRatio = 250 / $width;
				$heightRatio = 250 / $height;

				// Ratio used for calculating new image dimensions
				$ratio = min($widthRatio, $heightRatio);

				// Calculate new image dimensions.
				$newWidth  = (int)$width  * $ratio;
				$newHeight = (int)$height * $ratio;

				$img->resize($newWidth,$newHeight, function ($constraint) { $constraint->aspectRatio(); });

				$img->save($path.'/avatar.jpg');
		}

        auth()->user()->update($request->all());

        return back()->withStatus(__('Profile successfully updated.'));
    }

}
