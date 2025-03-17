<?php

namespace Database\Factories;

use App\Models\Employee;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class EmployeeFactory extends Factory
{
    protected $model = Employee::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name, // Solo un campo 'name'
            'alias' => $this->faker->optional()->companySuffix,
            'employee_id' => $this->faker->unique()->randomNumber(5),
            'email' => $this->faker->unique()->safeEmail,
            'phone' => $this->faker->phoneNumber,
            'secondary_phone' => $this->faker->optional()->phoneNumber,
            'position' => $this->faker->jobTitle,
            'department' => $this->faker->word,
            'hire_date' => $this->faker->date(),
            'salary' => $this->faker->randomFloat(2, 3000, 10000),
            'website' => $this->faker->optional()->url,
            'address' => $this->faker->address,
            'city' => $this->faker->city,
            'state' => $this->faker->state,
            'zip_code' => $this->faker->postcode,
            'country' => $this->faker->country,
            'notes' => $this->faker->optional()->sentence,
        ];
    }
}

