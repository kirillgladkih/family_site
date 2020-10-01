<?php

namespace App\ApiValidator\CustomRules;

use App\Models\Client;
use Illuminate\Contracts\Validation\Rule;

class UniqueColumnForClient implements Rule
{
    private $req = null;

    public function __construct($req)
    {
        $this->req = $req;
    }

    public function passes($attribute, $value)
    {


        $find = Client::where('age', $this->req['age'])
            ->where('fio', $this->req['fio'])
            ->where('procreator_id', $this->req['procreator_id']);

        if (isset($this->req['id'])) {
            $find = $find->where('id', '!=', $this->req['id']);
        }

        $find = $find->first();

        if ($find) {
            return false;
        }

        return true;
    }

    public function message()
    {
        return 'Данный клиент уже есть в базе данных';
    }
}