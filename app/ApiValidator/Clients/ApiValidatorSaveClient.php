<?php


namespace App\ApiValidator\Clients;

use App\ApiValidator\ApiCoreValidator;
use App\ApiValidator\CustomRules\ExistsAgeInGroup;
use App\ApiValidator\CustomRules\UniqueColumnForClient;

class ApiValidatorSaveClient extends ApiCoreValidator
{

    public function rules()
    {
        return [
            'fio' => [
                'required',
                "regex:/^[А-Яа-яЁё\s]+$/u",
                new UniqueColumnForClient($this->req)
            ],
            'age' => [
                'required',
                'integer',
                new ExistsAgeInGroup
            ],
            'procreator_id' => 'exists:procreators,id'
        ];
    }

    public function attributes()
    {
        return [
            'fio' => 'ФИО',
            'age' => 'Возраст',
            'procreator_id' => "Родитель"
        ];
    }
}