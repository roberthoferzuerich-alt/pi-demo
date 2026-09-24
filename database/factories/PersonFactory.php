<?php

namespace Database\Factories;

use App\Models\Person;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Person>
 */
class PersonFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $firstName = fake()->firstName();
        $lastName = fake()->lastName();

        return [
            'first_name' => $firstName,
            'last_name' => $lastName,
            'email' => fake()->unique()->safeEmail(),
            'job_title' => fake()->jobTitle(),
            'department' => fake()->randomElement(['Software Engineering', 'Product Management', 'Design', 'Marketing', 'Sales', 'Customer Support', 'Human Resources']),
            'city' => fake()->city(),
            'phone' => fake()->phoneNumber(),
            'avatar_url' => 'https://i.pravatar.cc/150?u=' . md5($firstName . $lastName . rand(1, 1000)),
        ];
    }
}
