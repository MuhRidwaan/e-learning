<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Course;

class CourseModuleFactory extends Factory
{
    public function definition(): array
    {
        return [
            'course_id' => Course::factory(),
            'title' => $this->faker->words(4, true),
            'description' => $this->faker->paragraph(),
            'order' => $this->faker->numberBetween(1, 10),
        ];
    }
}
