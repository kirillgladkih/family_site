<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Hour extends CoreModel
{
    use HasFactory;

    protected $fillable = [
        'hour', 'id'
    ];

    public function getHourAttribute($value)
    {
        return Carbon::parse($value)->format("H:i");
    }

    // Используется в HourFactory
    public static function getHourForFactory(int $i)
    {
        if($i == 24){
            return "00:00:00";
        }
        return $i < 10 ? '0'.$i.':00:00' : $i.':00:00';
    }
}
