<?php

namespace Database\Factories;

use App\Models\User;
use Faker\Provider\pt_BR\Address;
use Faker\Provider\pt_BR\Person;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends Factory<User>
 */
class EmployeeFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $address = app(Address::class);
        $employee = app(Person::class);
        return [
            'name' => $employee->name,
            'email' => fake()->unique()->safeEmail(),
            'cpf' => $employee->cpf,
            'city' => "$address->cityPrefix $address->citySuffix",
            'state' => $address->state,
            'manager_id' => User::query()->firstOr(
                fn () => User::factory()->create()
            ),
        ];
    }
}
