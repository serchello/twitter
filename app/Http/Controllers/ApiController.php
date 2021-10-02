<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Http\Resources\UserResource;
use App\Http\Requests\UserRequest;
use Symfony\Component\HttpFoundation\Response;

use DB;
use DateTime;
use Route;

class ApiController extends Controller
{

    private $CACHE_TIMEOUT = 60;

    /**
     * users API
     *
     * @return void
     */
    public function users()
    {
        $userslists= DB::table('users')
			->select('users.id','users.username', 'users.email',
			DB::raw('COUNT(followers.user_id) AS total_followers'),
            DB::raw('(SELECT COUNT(1) FROM followings WHERE users.id = followings.user_id) AS total_followings'),
			DB::raw('(SELECT COUNT(1) FROM tweets WHERE tweets.user_id = users.id) AS total_user_tweets'),
            'users.avatar')

			->leftJoin('followers', 'users.id', '=', 'followers.user_id')
			->groupBy('users.id','users.username', 'users.email', 'users.avatar')
			->orderByRaw('total_followers DESC')
            ->get();

        $api_users_cache = Cache::put('users', $userslists, $this->CACHE_TIMEOUT);

		$users = Cache::get('users');
		if(!$users){
			return "Time over!";
		}

        return view('pages.api_users', ['userslists' => $userslists]);
	}

    /**
     * statistics API
     *
     * @return void
     */
    public function statistics()
    {

        $today = date('Y-m-d H:i:s');
        $yesterday = date('Y-m-d H:i:s' ,strtotime("-1 days"));

		$statistics= DB::table('log_activities')
			->select('username', 'url', DB::raw('COUNT(1) total_visits'))
            ->whereBetween('updated_at', [''.$yesterday.'', ''.$today.''])
			->groupBy('username','url')
			->orderByRaw('total_visits DESC')
            ->get();

        $api_statistics_cache = Cache::put('statistics', $statistics, $this->CACHE_TIMEOUT);

		$statistics = Cache::get('statistics');
		if(!$statistics){
			return "Time over!";
		}

        return view('pages.api_statistics', ['statistics' => $statistics]);
    }


    public function getUsers()
    {
        $users = User::all();   // Dont work with All()->paginate(2);
        return UserResource::collection($users);
        //return new UserResource(User::paginate());
	}


    public function getUser(User $user)
    {
        return new UserResource($user);
	}

    public function createUser(UserRequest $request)
    {
        $user = User::create($request->all());
        return new UserResource($user);
	}

    public function deleteUser(User $user)
    {
        $user->delete();
        return response(null, Response::HTTP_NO_CONTENT);
	}

}