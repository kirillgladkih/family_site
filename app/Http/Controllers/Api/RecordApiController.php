<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Repositories\RecordRepository;
use App\ApiValidator\Record\ApiValidatorSaveRecord;
use App\ApiValidator\Record\ApiValidatorUpdateRecord;
use App\Http\Controllers\CoreApiController;
use App\Models\Client;
use Illuminate\Support\Facades\Response;

class RecordApiController extends CoreApiController
{
    public function __construct()
    {
        $this->repository = new RecordRepository();
        $this->saveValidator  = new ApiValidatorSaveRecord();
        $this->updateValidator = new ApiValidatorUpdateRecord();
    }

    public function history($client_id, $before, $after)
    {
        $client = Client::find($client_id);
        $response = 'not found';
        $status = '404';

        if ($client) {
            $response = $this->repository->history($client_id, $before, $after);
            $status = '200';
        }

        return Response::json($response, $status);
    }

    public function visit($id, Request $request)
    {
        $response = $this->repository->visit($request->input(), $id);
        $status   = '200';

        return Response::json($response, $status);
    }
}
