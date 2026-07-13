<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\QuizQuestion;

class QuizOptionFactory extends Factory
{
    public function definition(): array
    {
        return [
            'question_id' => QuizQuestion::factory(),
            'option_text' => $this->faker->sentence(3),
            'is_correct' => false,
        ];
    }
}
