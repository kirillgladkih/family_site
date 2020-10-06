<?php

namespace App\Http\Controllers\Api;

use App\ApiValidator\Clients\ApiValidatorSaveClient;
use App\ApiValidator\Clients\ApiValidatorUpdateClient;
use App\Http\Controllers\CoreApiController;
use App\Repositories\ClientRepository;
use Illuminate\Http\Request;

class ClientApiController extends CoreApiController
{
    public function __construct()
    {
        $this->repository = new ClientRepository();
        $this->saveValidator  = new ApiValidatorSaveClient();
        $this->updateValidator = new ApiValidatorUpdateClient();
    }
}
