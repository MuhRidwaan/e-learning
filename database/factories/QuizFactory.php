<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Course;

class QuizFactory extends Factory
{
    public function definition(): array
    {
        return [
            'course_id' => Course::factory(),
            'title' => 'Kuis: ' . $this->faker->sentence(2),
            'description' => $this->faker->paragraph(),
            'duration_minutes' => $this->faker->randomElement([15, 30, 45, 60]),
            'passing_score' => $this->faker->randomElement([60, 70, 75, 80]),
            'max_attempts' => $this->faker->numberBetween(1, 3),
            'deadline' => now()->addDays($this->faker->numberBetween(7, 30)),
        ];
    }
}
