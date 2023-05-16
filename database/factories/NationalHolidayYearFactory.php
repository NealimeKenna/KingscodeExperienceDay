<?php

namespace Database\Factories;

use App\Models\NationalHolidayYear;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\NationalHolidayYear>
 */
class NationalHolidayYearFactory extends Factory
{
    protected $model = NationalHolidayYear::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'year' => $this->faker->year('2037'),
            'monday' => $this->faker->randomDigit(),
            'tuesday' => $this->faker->randomDigit(),
            'wednesday' => $this->faker->randomDigit(),
            'thursday' => $this->faker->randomDigit(),
            'friday' => $this->faker->randomDigit(),
            'saturday' => $this->faker->randomDigit(),
            'sunday' => $this->faker->randomDigit(),
        ];
    }
}
