<?php


namespace App\Repositories;

use App\Models\Procreator as Model;

class ProcreatorRepository extends ARepository
{
    public function __construct()
    {
        parent::__construct();
    }

    function init()
    {
        return Model::class;
    }

    public function save($data)
    {

        return $this->start()
            ->create($data);
    }
}