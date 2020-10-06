<?php


namespace App\ApiValidator\Schedule;

use App\ApiValidator\ApiCoreValidator;

class ApiValidatorSaveSchedule extends ApiCoreValidator
{

    public function rules()
    {
        return [];
    }

    public function attributes()
    {
        return Attributes::get();
    }
}
