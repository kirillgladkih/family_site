<?php


namespace App\Repositories\Schedule;

use Illuminate\Support\Carbon;
use App\Models\Schedule as Model;

class ClientScheduleRepository extends AScheduleRepository
{
    // // Получает дни
    // public function getDays()
    // {

    //     $raw_result = parent::getDays();
    // }

    // Возвращает все в том числе и часы
    public function all($group_id)
    {
        $modelCollection = $this->start()
            ->where('active', 1)
            ->whereRaw('people_count < place_count')
            ->where('group_id', $group_id)
            ->get();


        $result = $this->filterDaysAndHours($modelCollection);

        return $result;
    }

    public function getHours($group_id, $date)
    {

        $pre = $this->start()
            ->select('hour', 'date')
            ->where('date', '>=', Carbon::today())
            ->where('date', $this->prepareDate($date))
            ->whereRaw('people_count < place_count')
            ->where('group_id', $group_id)
            ->where('active', 1)
            ->get()
            ->sortBy('hour');

        $pre = $this->filterDaysAndHours($pre);
        return $pre;
        $result = [];

        foreach ($pre as $p) {
            $result[] = $p;
        }

        return $result;
    }

    public function getDays($group_id)
    {
        return $this->start()
            ->select('date')
            ->where('date', '>=', Carbon::today())
            ->where('group_id', $group_id)
            ->where('active', 1)
            ->whereRaw('people_count < place_count')
            ->distinct('date')
            ->get()
            ->sortByDesc('date');
    }
}