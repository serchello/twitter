<?php
namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

use App\Models\Tweet;
use App\Models\Follower;
use App\Models\Following;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([UsersTableSeeder::class]);
        User::factory(20)->create();
        Tweet::factory(90)->create();
        Follower::factory(100)->create();
        Following::factory(100)->create();
    }
}