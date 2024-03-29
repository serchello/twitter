<?php

namespace Database\Factories;

use App\Models\Following;
use Illuminate\Database\Eloquent\Factories\Factory;

class FollowingFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Following::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => $this->faker->unique(true)->numberBetween(1, 20),
            'following_id' => $this->faker->unique(true)->numberBetween(1, 20)
        ];
    }
}
