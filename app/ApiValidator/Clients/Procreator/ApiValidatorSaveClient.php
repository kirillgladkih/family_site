<?php


namespace App\ApiValidator\Clients;

use App\ApiValidator\ApiCoreValidator;
use Illuminate\Validation\Rule;

class ApiValidatorSaveClient extends ApiCoreValidator
{

    public function rules()
    {
        return [
            'fio' => 'required|regex:/^[А-Яа-яЁё\s]+$/u',
            'phone' => 'required|regex:/^\+[0-9]{11}$/|unique:procreators,phone',
            'viber_id' => [
                Rule::unique('procreators')->where(function () {
                    return $this->req['viber_id'] !== null;
                })
            ],
            'vk_id' => [
                Rule::unique('procreators')->where(function () {
                    return $this->req['vk_id'] !== null;
                })
            ],
        ];
    }

    public function attributes()
    {
        return [
            'fio' => 'ФИО',
            'phone' => 'Телефон',
        ];
    }

    function messages()
    {
        return [
            'unique' => "такое :attribute уже существует",
            'required' => "Поле :attribute не может быть пустым",
            'integer' => 'Вы ввели не число',
            'phone.regex' => 'Неверный формат номера телефона, пожалуйста, попробуйте снова начиная с +7',
            'regex' => 'Неверный формат'
        ];
    }
}