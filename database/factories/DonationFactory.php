<?php

namespace Database\Factories;

use App\Models\Donor;
use App\Models\Center;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Donation>
 */
class DonationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $donor = Donor::inRandomOrder()->first();
        $center = Center::inRandomOrder()->first();

        return [
            'donor_id' => $donor->id,
            'center_id' => $center->id,
            'donation_date' => $this->faker->dateTimeBetween('-1 years', 'now'),
            'blood_type_id' => $donor->blood_type_id,
            
        ];
    }
}
