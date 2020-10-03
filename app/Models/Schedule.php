<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Schedule extends CoreModel
{
    use HasFactory;

    private const START_HOUR = 6;
    private const END_HOUR   = 22;

    protected $fillable = [
        'day_id', 'hour_id', 'group_id',
        'id', 'active', 'place_count', 'week_id'
    ];

    protected $attributes = [
        'active' => false,
        'place_count' => 8
    ];

    public $relations = [
        'group', 'hour', 'day', 'week'
    ];

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function hour()
    {
        return $this->belongsTo(Hour::class);
    }

    public function week()
    {
        return $this->belongsTo(Week::class);
    }

    public function day()
    {
        return $this->belongsTo(Day::class);
    }
    // Создать или выдать график по определенной группе и создать график для записи
    public static function fetchOrCreate(int $week_id, int $group_id)
    {
        $result = collect([]);

        for ($i = 1; $i <= 7; $i++) {
            $day = Day::where(Day::getDayForFactory($i))->first();
            // Здесь менять количество 
            for ($j = 6; $j <= 22; $j++) {

                $hour = Hour::where('hour', Hour::getHourForFactory($j))->first();

                $findData = [
                    'group_id' => $group_id,
                    'hour_id'  => $hour->id,
                    'day_id'   => $day->id,
                    'week_id'  => $week_id,
                ];

                if (!$res = Schedule::where($findData)->first()) {
                    $res = new Schedule();
                    $res->fill($findData);
                    $res->save();
                }

                $res->group;
                $res->hour;
                $res->day;
                $res->week;
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
