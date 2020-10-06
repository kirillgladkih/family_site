<?php


namespace App\Repositories;

use App\Models\Client as Model;

class ClientRepository extends ARepository
{
    public function __construct()
    {
        parent::__construct();
    }

    function init()
    {
        return Model::class;
    }

    public static function getRelations()
    {
        return [
            'procreator', 'status', 'type', 'group'
        ];
    }
}