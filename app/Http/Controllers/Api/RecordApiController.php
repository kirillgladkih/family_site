<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Repositories\RecordRepository;
use App\ApiValidator\Record\ApiValidatorSaveRecord;
use App\ApiValidator\Record\ApiValidatorUpdateRecord;
use App\Http\Controllers\CoreApiController;
use Illuminate\Http\Response;

class RecordApiController extends CoreApiController
{
    public function __construct()
    {
        $this->repository = new RecordRepository();
        $this->saveValidator  = new ApiValidatorSaveRecord();
        $this->updateValidator = new ApiValidatorUpdateRecord();
    }


    public function deleteWhere(Request $request)
    {
        $response = $this->repository->deleteWhere($$request->input());

        return Response::json(
            $response,
            '200'
        );
    }
}
