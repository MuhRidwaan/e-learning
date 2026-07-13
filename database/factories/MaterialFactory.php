<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\CourseModule;

class MaterialFactory extends Factory
{
    public function definition(): array
    {
        return [
            'module_id' => CourseModule::factory(),
            'title' => $this->faker->sentence(),
            'content' => $this->faker->paragraphs(4, true),
            'type' => $this->faker->randomElement(['pdf', 'video', 'link']),
            'file_path' => null,
            'order' => $this->faker->numberBetween(1, 5),
            'duration_minutes' => $this->faker->numberBetween(5, 60),
        ];
    }
}
