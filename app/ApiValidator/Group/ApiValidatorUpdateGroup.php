<?php


namespace App\ApiValidator\Group;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\ApiValidator\ApiCoreValidator;
use App\ApiValidator\Group\Attributes;

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
        return Attributes::get();
    }
}
