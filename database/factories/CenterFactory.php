<?php

namespace Database\Factories;

use App\Models\City;
use App\Models\Government;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Center>
 */
class CenterFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'address' => $this->faker->address('ar_EG'),
            'phone' => $this->faker->phoneNumber(),
            'government_id'=>$this->faker->randomElement(Government::pluck('id')->toArray()),
            'city_id' => function (array $attributes) {
                $cityIds = City::where('government_id', $attributes['government_id'])->pluck('id')->toArray();
                return $this->faker->randomElement($cityIds);
            },
            'user_id' => $this->faker->unique()->numberBetween(2, 29),
            'zip_code' => $this->faker->postcode(),
            'opening_time' => $this->faker->time('H:i', '09:00:00'),
            'closing_time' => $this->faker->time('H:i', '17:00:00'),

        ];
    }
}
