<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Scrumboard;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Scrumboard>
 */
class ScrumboardFactory extends Factory
{
    protected $model = Scrumboard::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'creator_id' => User::factory(), // Verwijzing naar een User ID
            'title' => $this->faker->sentence(3), // Titel van het scrumboard
            'description' => $this->faker->paragraph(), // Beschrijving van het scrumboard
            'active' => $this->faker->boolean(90), // 90% kans dat het actief is
        ];
    }
}
