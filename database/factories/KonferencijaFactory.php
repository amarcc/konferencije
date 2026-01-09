<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Konferencija>
 */
class KonferencijaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'ime' => fake() -> sentence(rand(1, 4)),
            'pocetak' => fake() -> dateTimeBetween("now", "+1 year")
        ];
    }
}
