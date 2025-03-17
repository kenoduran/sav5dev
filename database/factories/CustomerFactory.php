<?php

namespace Database\Factories;

use App\Models\Customer; // Cambiado de Client a Customer
use Illuminate\Database\Eloquent\Factories\Factory;

class CustomerFactory extends Factory
{
    protected $model = Customer::class; // Cambiado de Client a Customer

    public function definition(): array
    {
        return [
            'name' => $this->faker->company,
            'alias' => $this->faker->companySuffix,
            'tax_id' => $this->faker->unique()->ein,
            'email' => $this->faker->unique()->companyEmail,
            'phone' => $this->faker->phoneNumber,
            'secondary_phone' => $this->faker->optional()->phoneNumber,
            'website' => $this->faker->optional()->url,
            'contact_person' => $this->faker->name,
            'contact_email' => $this->faker->email,
            'contact_phone' => $this->faker->phoneNumber,
            'address' => $this->faker->address,
            'city' => $this->faker->city,
            'state' => $this->faker->state,
            'zip_code' => $this->faker->postcode,
            'country' => $this->faker->country,
            'notes' => $this->faker->optional()->sentence,
        ];
    }
}
