<?php


namespace App\ApiValidator\Group;

use App\ApiValidator\ApiCoreValidator;

class ApiValidatorSaveGroup extends ApiCoreValidator
{

    public function rules()
    {
        return [
            'name' => 'required|unique:groups,name',
            'age_before' => [
                'required',
                'integer',
                function ($attr,$val, $fail){
                    if($val > $this->req['age_after']){
                        $fail('Возраст до Не может быть больше Возраста до');
                    }
                },
            ],
            'age_after' => [
                'required',
                'integer'
            ]
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'Название группы',
            'age_before' => 'Возраст от',
            'age_after' => 'Возраст до'
        ];
    }

    function messages()
    {
        return [
            'unique' => "такое :attribute уже существует",
            'required' => "Поле не может быть пустым",
            'integer' => 'Вы ввели не число'
        ];
    }
}
