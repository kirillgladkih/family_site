<?php


namespace App\Repositories;

use App\Models\Client;
use App\Models\Group;
use App\Models\Record as Model;
use App\Models\Record;
use App\Models\Schedule;

class RecordRepository extends ARepository
{
    public function __construct()
    {
        parent::__construct();
    }

    function init()
    {
        return Model::class;
    }

    public function save($data)
    {
        $client = Client::find($data['client_id']);
        if ($data['procreator_with'] == 'Y') {
            $data['procreator_id'] = $client->procreator_id;
        }

        $schedule = Schedule::where('date', $data['date'])
            ->where('hour', $data['hour'])
            ->where('group_id', $client->group_id)->first();

        if ($client->client_status == 2) {
            $count = 1;

            if ($data['procreator_with'] != 'N') {
                $count++;
            }
            $schedule->people_count = (int) $schedule->people_count + $count;
        } elseif ($client->client_status == 1) {
            $schedule->lead_count = (int) $schedule->lead_count + 1;
        }

        $schedule->save();

        return $this->start()->create($data);
    }

    public function visit($record_id, $client_id)
    {
        $client = Client::where('id', $client_id)->first();

        $client->hours_payed = (int) $client->hours_payed - 1;
        $client->hours_visit = (int) $client->hours_visit + 1;
        $client->save();

        return $this->remove($record_id);
    }

    public function pass($record_id, $client_id)
    {

        $client = Client::where('id', $client_id)->first();

        $client->hours_payed = (int) $client->hours_payed - 1;
        $client->hours_missed = (int) $client->hours_missed + 1;
        $client->save();

        return $this->remove($record_id);
    }

    public function remove($id)
    {
        $record = Record::where('id', $id)->first();

        $client = Client::where('id', $record->client_id)->first();

        $schedule = Schedule::where([
            'group_id' => $client->group_id,
            'hour' => $record->hour,
            'date' => $record->date
        ])->first();

        $count = 0;

        if ($client->client_status == 2) {
            $count += 1;
            if ($record->procreator_id != null) {
                $count += 1;
            }

            $schedule->people_count = (int) $schedule->people_count - $count;
        } elseif ($client->client_status == 1) {

            $schedule->lead_count = (int) $schedule->lead_count - 1;
        }

        $schedule->save();

        return $this->start()
            ->destroy($id);
    }

    public function all()
    {
        //Показывать записи только начиная с вчерашнего дня
        date_default_timezone_set("Asia/Yekaterinburg");

        $date = date('Y/m/d', strtotime('-1 day'));

        $all = $this->start()
            ->select('*')
            ->where('date', '>=', $date)
            ->with(['client'])
            ->get();

        foreach ($all as $index => $item) {
            $all[$index]->group = Group::find($item->client->group_id);
        }

        return $all;
    }
}
