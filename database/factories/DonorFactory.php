<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Donor>
 */
class DonorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => $this->faker->unique()->numberBetween(30,49),
            'age' => $this->faker->numberBetween(18, 65),
            'weight' => $this->faker->numberBetween(50, 100),
            'gender' => $this->faker->randomElement(['male', 'female']),
          
            'blood_type_id' => $this->faker->numberBetween(1, 8),
            'city_id' => $this->faker->numberBetween(1, 300),
            'is_eligible' => true,
            

        ];
    }
}
