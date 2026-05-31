<?php

namespace Database\Factories;

use App\Models\Folder;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class DocumentFactory extends Factory
{
    public function definition(): array
    {
        return [
            'folder_id' => Folder::factory(),
            'user_id' => User::factory(),
            'file_name' => $this->faker->uuid().'.pdf',
            'original_name' => $this->faker->words(3, true),
            'extension' => 'pdf',
            'mime_type' => 'application/pdf',
            'size' => $this->faker->numberBetween(10000, 2000000),
            'path' => 'documents/example.pdf',
        ];
    }
}
