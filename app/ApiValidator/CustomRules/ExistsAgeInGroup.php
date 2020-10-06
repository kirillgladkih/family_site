<?php

namespace App\ApiValidator\CustomRules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\Group;

class ExistsAgeInGroup implements Rule
{
    public function passes($attribute, $value)
    {
        $groups = Group::all();

        $age = (int) $value;

        foreach ($groups as $group) {
            if ($group->age_before <=  $age && $group->age_after >= $age) {
                return true;
            }
        }
        return false;
    }

    public function message()
    {
        return 'Такой возрастной группы не существует';
    }
}