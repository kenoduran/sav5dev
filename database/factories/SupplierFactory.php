<?php

namespace Database\Factories;

use App\Models\Supplier;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class SupplierFactory extends Factory
{
    protected $model = Supplier::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->company,
            'alias' => $this->faker->optional()->companySuffix,
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
