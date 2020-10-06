<?php


namespace App\Repositories\Schedule;


use App\Repositories\ARepository;
use App\Repositories\ClientRepository;
use App\Models\Schedule as Model;

class ScheduleRepository extends ARepository
{
    private $clientRepository;

    public function __construct()
    {
        parent::__construct();

        $this->client = new ClientRepository();
    }

    public function init()
    {
        return Model::class;
    }

    public function getTimeTable($day, $group_id)
    {
        $date = date('Y-m-d', strtotime($day));
        
        return $this->start()
            ->where('date', $date)
            ->where('group_id', $group_id)
            ->get();
    }

    public function getHours($date, $client_id)
    {
        $client = $this->client->find($client_id);

        return $this
            ->start()
            ->where('date', $date)
            ->where('group_id', $client->group_id)
            ->where('active', 1)
            ->get();
    }

    public function getSchedule($date_start, $date_end, $group_id)
    {
        date_default_timezone_set("Asia/Yekaterinburg");

        $date_start = date('Y/m/d', strtotime($date_start));
        $date_end = date('Y/m/d', strtotime($date_end));

        return $this->start()
            ->select('*')
            ->where('date', '>=', $date_start)
            ->where('date', '<=', $date_end)
            ->where('group_id', $group_id)
            ->get();
    }

    public function findByParamsSchedule($day, $group_id, $start, $end)
    {
        $result = [];

        $count = (int) $end;
        $i   = (int) $start;

        for ($i; $i <= $count; $i++) {

            $data = [
                'hour' => $i . ':00',
                'date'  => $day,
                'group_id' => $group_id,
                'active' => 0,
                'place_count' => 8,
                'people_count' => 0
            ];

            $findData = [
                'hour' => $i . ':00',
                'date'  => $day,
                'group_id' => $group_id,
            ];

            if (!$model = $this->start()->where($findData)->first()) {
                $model = $this->start()->firstOrCreate($data);
            }

            array_push($result, $model);
        }

        return $result;
    }

    public function save($data)
    {
        return $this->start()
            ->updateOrCreate($data);
    }
}