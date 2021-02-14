<?php
namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

use App\Models\User;
use App\Models\Tweet;
use App\Models\Follower;
use App\Models\Following;


class UserControllerTest extends TestCase
{

    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }
    
    /**
     * test_corrent_user_inserted
     *
     * @return void
     */
    public function test_corrent_user_inserted()
    {
        $user = User::factory()->create([
            'name' => 'Sergios Gavriilidis',
            'username' => 'serchello',
            'avatar' => 'avatar.jpg',
            'password' => 'secret'
        ]);

        $this->assertDatabaseHas('users', [
            'username' => 'serchello',
        ]);

    }
    public function test_faker_user_inserted()
    {
        $user = User::factory()->create();

        $this->assertDatabaseHas('users', [
            'username' => $user->username
        ]);
    }

    public function test_add_tweet_from_user_created()
    {
        $user = User::factory()->create();

        $text  = "Lorem Ipsum is simply dummy text of the printing and typesetting";

        $tweet = Tweet::factory()->create([
            'user_id' => $user->id, 
            'text' => $text 
        ]);

        $this->assertDatabaseHas('tweets', ['text' => $text ]);
    }

    public function test_text_required_add_tweet()
    {
        $user = User::factory()->create();

        $response = $this->post('addTweet' , [
            'user_id' => $user->id, 
            'text' => ""
        ]);

        $response->assertStatus(302);
    }


    public function test_check_route_postTweet_and_profile()
    {
        $this->withoutExceptionHandLing();
        $user = User::factory()->create();

        $response = $this->actingAs($user)
        ->get(url('postTweet'))->assertStatus(200);

        $response = $this->actingAs($user)
        ->get(url('profile',  $user->username))->assertStatus(200);
    }

    public function test_usersList_get_all_excluding_current_user()
    {
        $this->withoutExceptionHandLing();
        
        $user = User::factory()->create();
        $user2 = User::factory()->create();
        $user3 = User::factory()->create();

        $follower = Follower::factory()->create([
            'user_id' => $user->id,
            'follower_id' => $user2->id
        ]);
        $follower = Follower::factory()->create([
            'user_id' => $user->id,
            'follower_id' => $user3->id
        ]);

        $following = Following::factory()->create([
            'user_id' => $user->id,
            'following_id' => $user3->id
        ]);

        $response = $this->actingAs($user)
                ->get(url('userslist'))->assertDontSeeText($user->username);

    }
}
