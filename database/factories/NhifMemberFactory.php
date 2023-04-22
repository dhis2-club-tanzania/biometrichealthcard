<?php

namespace Database\Factories;

use Illuminate\Http\File;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\NhifMember>
 */
class NhifMemberFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $gender = fake()->randomElement(['male', 'female']);
        return [
            'FirstName' => fake()->firstName($gender),
            'Surname' => fake()->lastName(),
            'CardNo' => fake()->unique()->numberBetween(1000000000, 9999999999),
            'MobileNo' => fake()->phoneNumber() ,
            'Gender' => $gender ,
            'FingerprintStatus' => false,
            'image' => fake()->image('storage\app\public\images',400,300, null, false) ,
        ];
    }
}
