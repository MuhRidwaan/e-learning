<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Syllabus;
use App\Models\User;

class CourseFactory extends Factory
{
    public function definition(): array
    {
        // 3 = Pengajar in our system, let's just pick one or a random instructor
        $instructorId = \DB::table('role_user')->where('role_id', 3)->inRandomOrder()->value('model_id') ?? 3;

        return [
            'syllabus_id' => Syllabus::factory(),
            'instructor_id' => $instructorId,
            'title' => $this->faker->sentence(4),
            'description' => $this->faker->paragraphs(3, true),
            'status' => 'published',
            'duration_weeks' => $this->faker->numberBetween(4, 16),
            'max_students' => $this->faker->numberBetween(20, 100),
            'published_at' => now(),
            'assignment_weight' => 40,
            'quiz_weight' => 60,
        ];
    }
}
