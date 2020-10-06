<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientSchedule extends Model
{
    use HasFactory;

    private const START_HOUR = 6;
    private const END_HOUR   = 22;

    protected $fillable = [
        'day_id', 'hour_id', 'id', 'active', 'client_id'
    ];

    protected $attributes = [
        'active' => false
    ];

    public function hour()
    {
        return $this->belongsTo(Hour::class);
    }

    public function day()
    {
        return $this->belongsTo(Day::class);
    }
    // Создать или выдать график график клиента
    public static function fetchOrCreate($client_id)
    {
        $result = collect([]);

        for ($i = 1; $i <= 7; $i++) {
            $day = Day::where(Day::getDayForFactory($i))->first();
            // Здесь менять количество 
            for ($j = 6; $j <= 22; $j++) {

                $hour = Hour::where('hour', Hour::getHourForFactory($j))->first();

                $findData = [
                    'hour_id'  => $hour->id,
                    'day_id'   => $day->id,
                    'client_id' => $client_id
                ];

                if (!$res = static::where($findData)->first()) {
                    $res = new static;
                    $res->fill($findData);
                    $res->save();
                }

                $res->load(['hour', 'day']);
                $result->push($res);
            }
        }

        $result = $result->map(function ($item) {
            $item->key = $item->hour->hour;
            return $item;
        });

        return $result->groupBy('key');
    }
}
