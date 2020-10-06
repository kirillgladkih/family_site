<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Repositories\ScheduleRepository;
use App\Http\Controllers\CoreApiController;
use App\ApiValidator\Schedule\ApiValidatorSaveSchedule;
use App\ApiValidator\Schedule\ApiValidatorUpdateSchedule;
use App\Models\Group;
use App\Models\Schedule;
use Illuminate\Support\Facades\Response;

class ScheduleApiController extends CoreApiController
{
    public function __construct()
    {
        $this->repository = new ScheduleRepository();
        $this->saveValidator  = new ApiValidatorSaveSchedule();
        $this->updateValidator = new ApiValidatorUpdateSchedule();
    }

    public function index(Request $request)
    {
        return $this->repository->getAll();
    }

    //Получить расписание группы по неделе
    public function getSchedule(int $week_id, int $group_id)
    {
        $response = ['error' => 'not found'];
        $status   = '404';

        if ($group = Group::where('id', $group_id)->first()) {
            $response = Schedule::fetchOrCreate($week_id, $group_id);;
            $status   = '200';
        }

        return Response::json(
            $response,
            $status
        );
    }
    // Редактирование графика
    public function updateSchedule(Request $request)
    {

        if ($errors = $this->updateValidator->init($request))
            return Response::json(
                $errors,
                '422'
            );

        $response = [
            'data' =>
            [
                'errors' =>
                [
                    ['not found']
                ]
            ]
        ];

        $status   = '422';

        if ($model = $this->repository
            ->editSchedule($request->input())
        ) {
            $response = $model;
            $status   = '200';
        }

        return Response::json(
            $response,
            $status
        );
    }
    // Получить все недели
    public function getWeeks()
    {
        $response = ['error' => 'not found'];
        $status   = '404';

        if ($fetch = \App\Models\Week::all()) {
            $status   = '200';
            $response = $fetch;
        }

        return Response::json(
            $response,
            $status
        );
    }
}
