<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $type = $this->faker->randomElement(['B', 'I']);
        return [
            'type' => $type,
            'name' => $type == 'B' ? $this->faker->company() : $this->faker->name(),
            'email' => $this->faker->email(),
            'address' => $this->faker->address(),
            'city' => $this->faker->city(),
            'state' => $this->faker->country(),
            'postal_code' => $this->faker->postcode(),
        ];
    }
}
