<?php

namespace App\ApiValidator\CustomRules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\Client;

class ExistsPayedHours implements Rule
{
    private $req;

    public function __construct($req)
    {
        $this->req = $req;
    }

    public function passes($attribute, $value)
    {
        $client = Client::find($this->req['client_id']);

        if ((int) $client->payed > -1) {
            return true;
        }

        return false;
    }

    public function message()
    {
        return 'Недостаточно оплаченных часов';
    }
}
