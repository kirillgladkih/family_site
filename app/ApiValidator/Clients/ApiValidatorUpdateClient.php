<?php


namespace App\ApiValidator\Clients;

use Illuminate\Validation\Rule;
use App\ApiValidator\ApiCoreValidator;
use App\ApiValidator\CustomRules\ExistsAgeInGroup;
use App\ApiValidator\CustomRules\UniqueColumnForClient;

class ApiValidatorUpdateClient extends ApiCoreValidator
{

    public function rules()
    {
        return [
            'fio' => [
                'required',
                'regex:/^[А-Яа-яЁё\s]+$/u',
                new UniqueColumnForClient($this->req)
            ],
            'age' => [
                'required',
                'integer',
                new ExistsAgeInGroup
            ],
            'procreator_id' => 'required|exists:procreators,id'
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

    function messages()
    {
        return [
            'unique' => "такое :attribute уже существует",
            'required' => "Поле :attribute не может быть пустым",
            'integer' => ':attribute Неверный возраст',
            'regex' => ':attribute Неверный формат',
            'exists' => 'В базе данных нет такого Поля : :attribute'
        ];
    }
}