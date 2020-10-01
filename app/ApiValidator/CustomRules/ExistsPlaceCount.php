<?php

namespace App\ApiValidator\CustomRules;

use App\Models\Client;
use App\Models\Schedule;
use Illuminate\Contracts\Validation\Rule;

class ExistsPlaceCount implements Rule
{
    private $req;

    public function __construct($req)
    {
        $this->req = $req;
    }

    public function passes($attribute, $value)
    {
        $client = Client::find($this->req['client_id']);

        if ($client->client_status != 2) {
            return true;
        }

        $schedule = Schedule::where('date', $this->req['date'])
            ->where('hour', $this->req['hour'])
            ->where('group_id', $client->group_id)->first();

        $people_count = (int) $schedule->people_count + 1;
        $place_count  = (int) $schedule->place_count;

        if ($this->req['procreator_with'] == 'Y') {
            $people_count++;
        }

        if ($people_count <= $place_count) {
            return true;
        }

        return false;
    }

    public function message()
    {
        return 'Недостаточно мест на запись ' . $this->req['date'] . " " . $this->req['hour'];
    }
}