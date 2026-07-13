<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

class SyllabusFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->words(3, true),
            'description' => $this->faker->paragraph(),
            'duration_weeks' => $this->faker->numberBetween(4, 16),
            'theme' => null,
            'created_by' => User::where('email', 'admin@gmail.com')->value('id') ?? 1,
        ];
    }
}
