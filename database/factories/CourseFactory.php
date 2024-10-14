<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Course>
 */
class CourseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $start = fake()->numberBetween(8,18);
        return [
            'key' => fake()->unique()->regexify('[A-Za-z0-9]{6}'),
            'name' => fake()->userName(),
            'credits' => rand(8, 10),
            'start' => $start . ':00',
            'end' => ($start + 1) . ':00'
        ];
    }
}
