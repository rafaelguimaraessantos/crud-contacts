<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Contact>
 */
class ContactFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'phone' => $this->faker->numerify('(##) #####-####'),
        ];
    }

    /**
     * Indicate that the contact is from a specific region.
     */
    public function fromRegion(string $region): static
    {
        return $this->state(fn (array $attributes) => [
            'phone' => match($region) {
                'sp' => $this->faker->numerify('(11) #####-####'),
                'rj' => $this->faker->numerify('(21) #####-####'),
                'mg' => $this->faker->numerify('(31) #####-####'),
                'rs' => $this->faker->numerify('(51) #####-####'),
                default => $this->faker->numerify('(##) #####-####'),
            }
        ]);
    }
}
