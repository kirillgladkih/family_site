<?php


namespace App\Repositories;

use App\Models\Group;
use App\Models\Record as Model;
use App\Repositories\ScheduleRepository;

class RecordRepository extends ARepository
{
    private $scheduleRepository;
    private $clientRepository;
    private $procreatorRepository;

    public function __construct()
    {
        date_default_timezone_set("Asia/Yekaterinburg");
        $this->scheduleRepository = new ScheduleRepository();
        $this->clientRepository = new ClientRepository();
        $this->procreatorRepository = new ProcreatorRepository();

        parent::__construct();
    }

    function init()
    {
        return Model::class;
    }

    public function save($data)
    {
        $schedule = $this->scheduleRepository->find($data['schedule_id']);
        $client   = $this->clientRepository->find($data['client_id']);

        $client->payed = (int) $client->payed - 1;

        $client->save();

        if ($client->group_id != 1) {
            $place_count = $data['with_procreator'] == 1 ? 2 : 1;
            $schedule->place_count = (int) $schedule->place_count - $place_count;
            $schedule->save();
        }

        return parent::save($data);
    }

    public function history($client_id, $before, $after)
    {
        $collections = $this->start()
            ->where('client_id', $client_id)
            ->where('date', '>=', $before)
            ->where('date', '<=', $after)
            ->orderBy('date', 'ASC')
            ->get();

        return $collections;
    }
    // Метод отвечает за отметку посещаемости

    public function visit($data, $id)
    {
        $record = $this->find($id);

        $record->visit = $data['visit'];

        $client = $this->clientRepository->find($data['client_id']);

        if ($data['visit'] == 1) {
            $client->visit = (int) $client->visit + 1;
        } else {
            $client->pass = (int) $client->pass + 1;
        }

        $record->save();
        $client->save();

        return true;
    }

    public function remove(int $id)
    {
        $model = $this->start()->find($id);
        $client   = $this->clientRepository->find($model->client_id);
        $schedule = $this->scheduleRepository->find($model->schedule_id);

        $client->payed = (int) $client->payed + 1;

        $client->save();

        if ($client->group_id != 1) {
            $place_count = $model->with_procreator == 1 ? 2 : 1;
            $schedule->place_count = (int) $schedule->place_count + $place_count;
            $schedule->save();
        }

        return $model ? $model->delete() : false;
    }

    public function getAll()
    {
        //Показывать записи только начиная с вчерашнего дня
        $date = date('Y/m/d', strtotime('-1 day'));
        //Обычные записи
        $all = $this->start()
            ->select('*')
            ->where('date', '>=', $date)
            ->orderBy('date', 'ASC')
            ->with(['client'])
            ->get();

        $result = [];

        foreach ($all as $index => $item) {
            $tmp = $all[$index];

            if (!is_int($tmp->visit)) {
                $tmp->group = Group::find($item->client->group_id);
                $tmp->procreator = $this->procreatorRepository->find($item->client->procreator_id);

                $result[] = $tmp;
            }
        }

        return $result;
    }
}
