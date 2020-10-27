<?php


namespace App\Repositories;

use App\Models\Record;
use App\Models\Schedule as Model;
use Illuminate\Support\Facades\Hash;

class ScheduleRepository extends ARepository
{
    private $clientRepository;
    private $dates;


    public function __construct()
    {
        $this->clientRepository = new ClientRepository();

        for ($i = 0; $i <= 13; $i++) {
            $this->dates[$i]['date'] = date('Y-m-d', strtotime("+$i day"));
            $this->dates[$i]['day_code'] = date('D', strtotime("+$i day"));
            $this->dates[$i]['week'] = $i <= 6 ? 1 : 2;
        }

        parent::__construct();
    }

    function init()
    {
        return Model::class;
    }

    public static function getRelations()
    {
        return [
            'group', 'hour', 'day', 'week'
        ];
    }

    public function editSchedule(array $data)
    {
        $model = $this->start()
            ->where('id', $data['id'])->first();

        if ($model) {
            $model->fill($data);
            $model->save();
        }

        $relations = static::getRelations();

        if (count($relations) > 0) {
            foreach ($relations as $relation) {
                $model->$relation;
            }
        }

        return $model ? $model : false;
    }

    private function makeDate(Model $schedule)
    {
        foreach ($this->dates as $day) {
            if (
                $schedule->day->day_en == $day['day_code']
                && $schedule->week_id == $day['week']
            ) {
                $schedule->record_permission = $schedule->place_count > 0 ? true : false;
                // $schedule->date = $day['date'] . ' ' . $schedule->day->day_ru;
                $schedule->date = $day['date'];

                return $schedule;
            }
        }
    }

    // График для оттдельного клиента
    public function mapSchedule($client_id)
    {
        $client = $this->clientRepository->find($client_id);
        $group_id = $client->group_id;
        $schedule = $this->getAll();
        $result = [];
        $dates = [];
        // Если клиент лид, то добавляем вне зависимости от места
        // Если клиент не лид, то проверяем наличие мест
        foreach ($schedule as $obj) {
            if ($obj->group_id === $group_id && $obj->active) {
                $data = $this->makeDate($obj);

                $record = Record::select('*')->where([
                    'date' => $data->date,
                    'client_id' => $client->id,
                    'hour' => $data->hour->hour
                ])
                    ->first();

                $data->record_id = $record ? $record['id'] : null;

                if ($record) {
                    if (is_int($record->visit)) {
                        continue;
                    }
                }

                $prepare_date = [
                    'date' => $data->date,
                    'ru' => $data->day->day_ru
                ];

                $now = strtotime(date('H:i'));
                $hour = strtotime($data->hour->hour);
                $now_date = strtotime(date('Y-m-d'));
                $date = strtotime(date('Y-m-d', strtotime($data->date)));

                if (!in_array($prepare_date, $dates)) {
                    //Если сегодня то время должно быть больше чем сейчас есть 
                    $needle = $now_date == $date && $hour > $now || $date > $now_date;
                    if ($needle) {
                        $dates[] = $prepare_date;
                    }
                }

                if ($hour > $now || $date > $now_date) {
                    $result['items'][] = $data;
                }
            }
        }

        usort($dates, function ($a, $b) {
            if ($a['date'] == $b['date']) {
                return 0;
            }

            return (strtotime($a['date']) < strtotime($b['date'])) ? -1 : 1;
        });

        $result['dates'] = $dates;
        return $result;
    }
}
