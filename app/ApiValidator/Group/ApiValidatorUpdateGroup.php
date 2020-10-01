<?php


namespace App\ApiValidator\Group;

use App\ApiValidator\ApiCoreValidator;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ApiValidatorUpdateGroup extends ApiCoreValidator
{

    public function rules()
    {
        return [
            'name' => "required|unique:groups,name,".$this->req['id'],
            'age_before' => [
                'required',
                'integer',
                function ($attr, $val, $fail) {
                    if ($val > $this->req['age_after']) {
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
            'required' => ":attribute не может быть пустым",
            'integer' => ':attribute должен быть числом'
        ];
    }
}
