<?php

namespace App\Repositories\Schedule;

use App\Models\ClientSchedule;
use Illuminate\Support\Carbon;
use App\Models\Schedule as Model;

class ClientSubscriptionRepository extends AScheduleRepository
{
    private $client_schedule;

    function init()
    {
        return Model::class;
    }

    public function __construct()
    {
        parent::__construct();
        $this->client_schedule = new ClientSchedule();
    }

    public function getHoursForSub($group_id, $client_id, $date)
    {
        $date = $this->prepareDate($date);
        $day  = Carbon::create($date)->format('D');
        $result  = [];

        $allHours = $this->start()
            ->select('date', 'hour')
            ->where('date', '>=', Carbon::today())
            ->whereRaw('people_count < place_count')
            ->where('date', '=', $date)
            ->where('group_id', $group_id)
            ->where('active', 1)
            ->distinct('date')
            ->get()
            ->sortBy('date');

        $allHours = $this->filterDaysAndHours($allHours);

        $avaiHours = $this->client_schedule
            ->select('day', 'hour')
            ->where('day', $day)
            ->where('client_id', $client_id)
            ->where('active', 1)
            ->distinct('day')
            ->get()
            ->sortByDesc('day')
            ->toArray();

        $aHours = [];
        $avHours = [];

        foreach ($allHours as $allHour) {
            $aHours[] = $allHour['hour'];
        }

        foreach ($avaiHours as $allHour) {
            $avHours[] = $allHour['hour'];
        }

        foreach ($aHours as $aHour) {
            if (in_array($aHour, $avHours)) {
                array_push($result, ["hour" => $aHour]);
            }
        }
        return $result;
    }

    public function getDaysForSub($group_id, $client_id)
    {
        $result  = [];

        $allDays = $this->start()
            ->select('date')
            ->where('date', '>=', Carbon::today())
            ->where('group_id', $group_id)
            ->whereRaw('people_count < place_count')
            ->where('active', 1)
            ->distinct('date')
            ->get()
            ->sortByDesc('date')
            ->toArray();

        $avaiDays = $this->client_schedule
            ->select('day')
            ->where('client_id', $client_id)
            ->where('active', 1)
            ->distinct('day')
            ->get()
            ->sortByDesc('day')
            ->toArray();

        $aDays = [];
        $avDays = [];

        foreach ($allDays as $allDay) {
            $aDays[] = $allDay['date'];
        }

        foreach ($avaiDays as $allDay) {
            $avDays[] = $allDay['day'];
        }

        foreach ($aDays as $allDay) {
            $day = Carbon::create($allDay)->format('D');

            $now = strtotime(date('yy-m-d'));
            $ref = strtotime($allDay);

            if (
                in_array($day, $avDays)
                && $ref >= $now
            ) {
                $result[]['date'] = $allDay;
            }
        }

        return $result;
    }
}