<?php


namespace App\Repositories;

use App\Models\Group as Model;
use Illuminate\Support\Facades\Response;

class GroupRepository extends ARepository
{
    public function __construct()
    {
        parent::__construct();
    }

    function init()
    {
        return Model::class;
    }

    public function getGroupIdCompareAge($age)
    {
        $groups = $this->getAll();

        $age = (int) $age;

        foreach ($groups as $group_key => $group) {
            if (
                $group->age_before <= $age
                && $age <= $group->age_after
            ) {
                return $group->id;
            }
        }
    }
}