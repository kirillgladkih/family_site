<?php

namespace App\ApiValidator\CustomRules;

use App\Models\Record;
use Illuminate\Contracts\Validation\Rule;

class UniqueColumnForRecord implements Rule
{
    private $req = null;
    private $h;
    public function __construct($req)
    {
        $this->req = $req;
    }

    public function passes($attribute, $value)
    {
        $find = Record::where('hour', $this->req['hour'])
            ->where('date', $this->req['date'])
            ->where('client_id', $this->req['client_id'])
            ->first();

        if ($find) {
            return false;
        }

        return true;
    }

    public function message()
    {
        return 'Данный пользователь уже записан на ' . $this->req['date'] . " " . $this->req['hour'];
    }
}