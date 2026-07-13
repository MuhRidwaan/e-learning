<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Course;

class AssignmentFactory extends Factory
{
    public function definition(): array
    {
        return [
            'course_id' => Course::factory(),
            'title' => 'Tugas: ' . $this->faker->sentence(3),
            'description' => $this->faker->paragraphs(2, true),
            'due_date' => now()->addDays($this->faker->numberBetween(7, 30)),
            'max_score' => 100,
            'created_by' => 3, // Pengajar default
        ];
    }
}
