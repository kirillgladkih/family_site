<?php


namespace App\Repositories\Schedule;


use App\Models\Schedule as Model;
use App\Repositories\ARepository;
use Illuminate\Support\Carbon;

abstract class AScheduleRepository extends ARepository
{

    public function init()
    {
        return Model::class;
    }

    public function prepareDate($date)
    {
        return Carbon::create($date)->format('Y-m-d');
    }

    // Сортирует график начиная от сегодня
    protected function filterDaysAndHours($modelCollection)
    {
        date_default_timezone_set("Asia/Yekaterinburg");
        return $modelCollection->filter(function ($item) {
            $today = Carbon::now()->format('Y/m/d');
            $ref_day = Carbon::create($item->date)->format('Y/m/d');
            $hour    = strtotime(date('H:i'));
            $ref_hour    = strtotime(date('H:i', strtotime($item->hour)));
            // $str = date('H:i') . " $hour " . date('H:i', strtotime($item->hour)) . " $ref_hour ";
            // file_put_contents(__DIR__ . '/log.txt', $str . "\n", FILE_APPEND);
            if (strtotime($ref_day) >= strtotime($today)) {
                if (
                    strtotime($ref_day) == strtotime($today)
                    && $hour > $ref_hour
                ) {

                    return;
                }

                return $item;
            }
        })->sortByDesc('date')
            ->toArray();
    }


    public function getHours($group_id, $date)
    {

        $date = Carbon::create($date)->format('Y-m-d');

        $pre = $this->start()
            ->select('hour', 'date')
            ->where('date', '>=', Carbon::today())
            ->where('date', $date)
            ->where('group_id', $group_id)
            ->where('active', 1)
            ->get()
            ->sortBy('hour');

        $pre = $this->filterDaysAndHours($pre);

        $result = [];

        foreach ($pre as $p) {
            $result[] = $p;
        }

        return $result;
    }

    // Получает дни
    public function getDays($group_id)
    {
        return $this->start()
            ->select('date')
            ->where('date', '>=', Carbon::today())
            ->where('group_id', $group_id)
            ->where('active', 1)
            ->distinct('date')
            ->get()
            ->sortByDesc('date');
    }


    // Возвращает все в том числе и часы
    public function all($group_id)
    {
        $modelCollection = $this->start()
            ->where('active', 1)
            ->where('group_id', $group_id)
            ->get();


        $result = $this->filterDaysAndHours($modelCollection);

        return $result;
    }
}