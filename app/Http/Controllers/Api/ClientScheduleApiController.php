<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\ClientSchedule;
use App\Repositories\ClientScheduleRepository;
use Illuminate\Support\Facades\Response;
use App\Http\Controllers\CoreApiController;
use App\ApiValidator\Schedule\ApiValidatorSaveSchedule;
use App\ApiValidator\Schedule\ApiValidatorUpdateSchedule;

class ClientScheduleApiController extends CoreApiController
{
    public function __construct()
    {
        $this->repository = new ClientScheduleRepository();
        $this->saveValidator  = new ApiValidatorSaveSchedule();
        $this->updateValidator = new ApiValidatorUpdateSchedule();
    }

    public function index(Request $request)
    {
        return $this->repository->getAll();
    }

    //Получить расписание группы по неделе
    public function getSchedule($client_id)
    {
        $response = ['error' => 'not found'];
        $status   = '404';

        $response = ClientSchedule::fetchOrCreate($client_id);
        $status   = '200';

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
}
