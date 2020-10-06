<?php

namespace App\Http\Controllers\Api;

use App\ApiValidator\Clients\Procreator\ApiValidatorSaveProcreator;
use App\ApiValidator\Clients\Procreator\ApiValidatorUpdateProcreator;
use App\Http\Controllers\CoreApiController;
use App\Repositories\ProcreatorRepository;
use Illuminate\Http\Request;

class ProcreatorApiController extends CoreApiController
{
    public function __construct()
    {
        $this->repository = new ProcreatorRepository;
        $this->saveValidator  = new ApiValidatorSaveProcreator();
        $this->updateValidator = new ApiValidatorUpdateProcreator();
    }
}
