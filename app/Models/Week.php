<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Week extends CoreModel
{
    use HasFactory;

    const WEEKS = [
        ['name' => 'Неделя 1'],
        ['name' => 'Неделя 2']
    ];

    public static function getWeekForFactory(int $i)
    {
        return self::WEEKS[$i - 1];
    }
    
    protected $fillable = [
        'name', 'id'
    ];
}
