<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'username' => fake()->userName(), // Toegevoegd veld voor gebruikersnaam
            'first_name' => fake()->firstName(), // Toegevoegd veld voor voornaam
            'last_name' => fake()->lastName(), // Toegevoegd veld voor achternaam
            'phone_number' => fake()->phoneNumber(), // Toegevoegd veld voor telefoonnummer
            'profile_bio' => fake()->sentence(), // Toegevoegd veld voor bio
            'profile_picture' => fake()->imageUrl(200, 200), // Toegevoegd veld voor profielfoto
            'is_administrator' => fake()->boolean(), // Toegevoegd veld voor adminstatus
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    public function customUser(): static
    {
        return $this->state(fn (array $attributes) => [
            'username' => 'testuser123',
            'first_name' => 'John',
            'last_name' => 'Doe',
            'phone_number' => '1234567890',
            'profile_bio' => 'This is a test bio.',
            'profile_picture' => '/test_picture.jpg',
            'is_administrator' => true,
        ]);
    }
}
