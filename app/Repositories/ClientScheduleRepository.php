<?php


namespace App\Repositories;

use App\Models\ClientSchedule as Model;

class ClientScheduleRepository extends ARepository
{
    public function __construct()
    {
        parent::__construct();
    }

    function init()
    {
        return Model::class;
    }

    public static function getRelations()
    {
        return [
            'hour', 'day'
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
}
