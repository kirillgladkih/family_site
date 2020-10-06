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
                        $fail('Возраст от не может быть больше возраста до');
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
