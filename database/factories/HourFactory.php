<?php

namespace Database\Factories;

use App\Models\Hour;
use Illuminate\Database\Eloquent\Factories\Factory;

class HourFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */

    protected $model = Hour::class;
    protected static $iterator = 0;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        static::$iterator++;

        $hour = Hour::getHourForFactory(static::$iterator);

        return [
            'hour' => $hour
        ];
    }
}
