<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class FolderFactory extends Factory
{
    public function definition(): array
    {
        return [
            'parent_id' => null,
            'name' => strtoupper($this->faker->unique()->words(2, true)),
            'description' => $this->faker->optional()->sentence(),
            'created_by' => User::factory(),
        ];
    }
}
