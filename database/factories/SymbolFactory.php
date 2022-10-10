<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Symbol>
 */
class SymbolFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $user = User::inRandomOrder()->first();
        $number = $this->faker->numberBetween(10, 30);
        return [
            'user_id' => $user->id,
            'image' => $this->faker->image('storage', 50),
            'points' => [
                "three"=>$number,"four"=>$number+rand(3,6),"five"=>$number+rand(6,9),
            ]
        ];
    }
}
