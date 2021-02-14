<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Hash;


use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;

use Auth;
use Config;
use Route;
use File;
use Image;
use DB;

use App\Tweets;
use App\Followers;
use App\Followings;



use App\Mail\Newfollower;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    
    /**
     * add Tweet
     *
     * @param Request $request
     * @return void
     */
    public function addTweet(Request $request)
    {
		$validated = $request->validate([
			'text' => 'required|max:140',
			'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:1000'
		]);

        $auth_id = auth()->user()->id;
        $username = auth()->user()->username;
    
		$random_str = "";

		$path = public_path().'/images/'.$username;
        File::makeDirectory($path, $mode = 0777, true, true);
       
		$input = $request->except('_token');
		$file=$request->file('image');

		if($file){

                $random_str = Str::random($length = 20);
                $random_str = $random_str.'.jpg';
                $img = Image::make($file->getRealPath());
				
				list($width, $height) = getimagesize($file->getRealPath());

				// Calculate ratio of desired maximum sizes and original sizes
				$widthRatio = 500 / $width;
				$heightRatio = 250 / $height;

				// Ratio used for calculating new image dimensions
				$ratio = min($widthRatio, $heightRatio);

				// Calculate new image dimensions.
				$newWidth  = (int)$width  * $ratio;
				$newHeight = (int)$height * $ratio;

				$img->resize($newWidth,$newHeight, function ($constraint) { $constraint->aspectRatio(); });

				$img->save($path.'/'.$random_str);
		}
			
        $tweet = new Tweets;
		$tweet->user_id = $auth_id;
        $tweet->username = $username;
        $tweet->text = $request->text;
		$tweet->image = $random_str;
        $tweet->save();
        
        return redirect('/postTweet')->with('message', 'Twitter stored!');
    }
  	
  	/**
  	 * /profile
  	 *
  	 * @param $username
  	 * @return void
  	 */
  	public function getUser($username)
    {
        $auth_id = auth()->user()->id;

		$users= DB::table('users')
			->select('users.id', 'users.username', 'users.email',
			DB::raw('(SELECT COUNT(1) FROM followers WHERE users.id = followers.user_id) AS total_followers'),
			DB::raw('(SELECT COUNT(1) FROM followings WHERE users.id = followings.following_id) AS total_followings'),
			DB::raw('COUNT(1) as total_tweets'))
            
			->Join('tweets', 'users.id', '=', 'tweets.user_id')
			->where('users.id', $auth_id)
			->groupBy('users.id', 'users.username', 'users.email')	
            ->get();

		$tweets = DB::table('tweets')->select('username', 'text', 'image', 'updated_at')->where('user_id', $auth_id)->orderBy('updated_at', 'desc')->paginate(5);
        \LogActivity::addToLog(); 
        return view('pages.userprofile', ['users' => $users, 'tweets'=>$tweets]);
    }
	
	/**
	 * timeline
	 *
	 * @return void
	 */
	public function timeline()
    {
        $auth_id = auth()->user()->id;

		$followers= DB::table('followers')
			->select('users.id', 'users.username', 'tweets.text', 'tweets.created_at')
			->Join('tweets', 'tweets.user_id', '=', 'followers.follower_id')
			->Join('users', 'users.id', '=', 'followers.follower_id')
			->where('followers.user_id', $auth_id)
            ->paginate(5);

		$followings= DB::table('followings')
			->select('users.id', 'users.username', 'tweets.text', 'tweets.created_at')
			->Join('tweets', 'tweets.user_id', '=', 'followings.following_id')
			->Join('users', 'users.id', '=', 'followings.following_id')
			->where('followings.user_id', $auth_id)
            ->paginate(5);
        \LogActivity::addToLog();
        return view('pages.timeline', ['followers' => $followers, 'followings'=>$followings]);
    }
	
	/**
	 * users List
	 *
	 * @return void
	 */
	public function usersList()
    {
 		$auth_id = auth()->user()->id;

		$userslists= DB::table('users')
			->select('users.id', 'users.username', 
			DB::raw('COUNT(followers.user_id) AS total_followers'),
            DB::raw('(SELECT COUNT(1) FROM followings WHERE users.id = followings.user_id) AS total_followings'),
			DB::raw('(SELECT COUNT(1) FROM tweets WHERE tweets.user_id = users.id) AS total_user_tweets'),

			DB::raw("MAX((SELECT CASE WHEN followings.user_id ='$auth_id' THEN 1 ELSE 0 END 
			FROM followings WHERE followings.following_id = users.id AND followings.user_id = '$auth_id' )) AS S"))

			->leftJoin('followers', 'users.id', '=', 'followers.user_id')
			->where('users.id','!=', $auth_id)
			->groupBy('users.id','users.username')
			->orderByRaw('total_followers DESC')
            ->paginate(5);
         \LogActivity::addToLog();
         return view('pages.userslist', ['userslists' => $userslists]);
    }
	
	/**
	 * follow Unfollow function
	 *
	 * @param  mixed $request
	 * @return void
	 */
	public function followUnfollow(Request $request)
    {   
		$id_following = (int)$request->input('id_person');
		$username = auth()->user()->username;
        $auth_id = auth()->user()->id;

		if($request->input('follow_unfollow') == null)
		{
			
		    $followings = new Followings;
			$followings->user_id = $auth_id;
			$followings->following_id = $id_following;
			$followings->save();

            $followers = new Followers;
			$followers->user_id = $id_following;
			$followers->follower_id = $auth_id;
			$followers->save();	

            $email = DB::table('users')->where('id', $id_following)->value('email');

			Mail::to($email)->send(new Newfollower);
		}
		else
		{
		    DB::table('followers')
			->where('user_id', $id_following)
			->where('follower_id', $auth_id)
			->delete();

			 DB::table('followings')
			->where('user_id',  $auth_id)
			->where('following_id',$id_following)
			->delete();
		}
        \LogActivity::addToLog();
        return redirect('/userslist');
    }



}
