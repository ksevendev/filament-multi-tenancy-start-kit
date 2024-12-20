<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Integrations>
 */
class IntegrationsFactory extends Factory
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
            'url'       => $this->faker->url,
            'api_key'   => $this->faker->uuid,
            'api_token' => $this->faker->uuid,
            'settings'  => null,
            'is_active' => true,
        ];
    }
}
