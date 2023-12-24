<?php

namespace Database\Factories;

use Faker\Provider\Address;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        return [
            'user_name' => fake()->userName(),
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'age' => fake()->numberBetween(18,100),
            'postal_code' => fake()->postcode(),
            'phone_number' => fake()->randomNumber(),
            'address' => fake()->address(),
            'country' => fake()->country(),
            'province' =>fake()->city() ,
            'city' => fake()->city(),
            'gender' => fake()->randomElement(['male','female']),
            'image' => fake()->image(),
            'created_at' => fake()->time(),
            'updated_at' => fake()->time(),
            'email' => fake()->unique()->safeEmail(),
//            'email_verified_at' => now(),

            'password' => static::$password ??= Hash::make('password'),
//            'remember_token' => Str::random(10),
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
}
