<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $starting_datetime = $this->faker->dateTimeInInterval('-25 days', '+50 days'); 
        $daysDifference = ((int) Carbon::parse(Carbon::now())->diffInDays(Carbon::parse($starting_datetime))) + 1;
        $daysDifference = $daysDifference >= 0 ? "+" . $daysDifference . " days" : $daysDifference . " days";
        // dd([$daysDifference, $this->faker->dateTimeInInterval(($daysDifference), '+10 days')]);
        return [
            'title' => $this->faker->sentence(),
            'description' => $this->faker->paragraph(3),
            'min_bid' => $this->faker->randomNumber(2) * 100,
            'bid_step' => $this->faker->randomNumber(1) * 10,
            'location' => $this->faker->city(),
            'condition' => $this->faker->randomElement(['new', 'used']),
            'starting_datetime' => $starting_datetime,
            'ending_datetime' => $this->faker->dateTimeInInterval(($daysDifference), '+12 days'),
        ];
    }
}
