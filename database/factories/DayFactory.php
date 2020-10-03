<?php

namespace Database\Factories;

use App\Models\Day;
use Illuminate\Database\Eloquent\Factories\Factory;

class DayFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Day::class;
    protected static $iterator = 0;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        static::$iterator++;
        $item = Day::getDayForFactory(static::$iterator);

        return $item;
    }
}
