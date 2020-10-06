<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Repositories\GroupRepository;
use Illuminate\Support\Facades\Response;
use App\Http\Controllers\CoreApiController;
use App\ApiValidator\Group\ApiValidatorSaveGroup;
use App\ApiValidator\Group\ApiValidatorUpdateGroup;

class GroupApiController extends CoreApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->repository = new GroupRepository();
        $this->saveValidator  = new ApiValidatorSaveGroup();
        $this->updateValidator = new ApiValidatorUpdateGroup();
    }

}
