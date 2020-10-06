<?php

namespace App\Repositories\Schedule;

use App\Models\Schedule as Model;

class LeedScheduleRepository extends AScheduleRepository
{

    public function init()
    {
        return Model::class;
    }
}