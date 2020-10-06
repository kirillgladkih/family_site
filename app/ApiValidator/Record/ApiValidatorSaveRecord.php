<?php


namespace App\ApiValidator\Record;

use App\Models\Record;
use Illuminate\Validation\Rule;
use App\ApiValidator\ApiCoreValidator;
use App\ApiValidator\CustomRules\ExistsPayedHours;
use App\ApiValidator\CustomRules\ExistsPlaceCount;
use App\ApiValidator\CustomRules\UniqueColumnForRecord;


class ApiValidatorSaveRecord extends ApiCoreValidator
{

    public function rules()
    {
        return [
            'date' => [
                'required',
                new UniqueColumnForRecord($this->req)
            ],
            'client_id' => [
                'exists:clients,id',
                new ExistsPayedHours($this->req),
                new ExistsPlaceCount($this->req)
            ],
            'friends' => "integer"
        ];
    }

    public function attributes()
    {
        return [
            'client_id' => 'Возраст до',
            'friends' => 'Количество друзей с собой'
        ];
    }

    function messages()
    {
        return [
            'required' => "Поле не может быть пустым",
            'integer' => ":attribute не число",
            'exists.client_id' => 'Данного клиента не существует в базе данных'
        ];
    }
}