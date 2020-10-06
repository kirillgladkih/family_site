<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Day extends CoreModel
{
    use HasFactory;

    const DAYS = [
        ['day_ru' => "Пн", 'day_en' => "Mon"],
        ['day_ru' => "Вт", 'day_en' => "Tue"],
        ['day_ru' => "Ср", 'day_en' => "Wed"],
        ['day_ru' => "Чт", 'day_en' => "Thu"],
        ['day_ru' => "Пт", 'day_en' => "Fri"],
        ['day_ru' => "Сб", 'day_en' => "Sat"],
        ['day_ru' => "Вс", 'day_en' => "Sun"],
    ];

    protected $fillable = [
        'day_ru', 'day_en', 'id'
    ];

    public static function getDayForFactory(int $i)
    {
        return self::DAYS[$i - 1];
    }
}
