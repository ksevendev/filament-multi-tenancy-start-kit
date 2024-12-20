<?php

namespace Database\Factories\Business;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Business\Lead>
 */
class LeadFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'tenant_id' => 1,
            'name'      => $this->faker->name,
            'email'     => $this->faker->unique()->safeEmail,
            'phone'     => $this->faker->phoneNumber,
        ];
    }
}
