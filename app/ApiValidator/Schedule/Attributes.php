<?php


namespace App\ApiValidator\Schedule;


class Attributes
{
    static function get()
    {
        return [
            'name' => 'Название группы',
            'age_before' => 'Возраст от',
            'age_after' => 'Возраст до'
        ];
    }
}
