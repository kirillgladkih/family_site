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

    public function getAll()
    {
        return $this->start()
            ->with('procreator')
            ->with('type')
            ->with('group')
            ->get();
    }

    public function save($data)
    {

        $this->start()->create($data);


        return $this->findByParamsWithRelation($data, 'procreator', 'type', 'group');
    }

    public function edit($id, $data)
    {
        $model = $this->find($id);

        $model->update($data);

        return $this->start()
            ->where('id', $id)
            ->with('procreator')
            ->with('type')
            ->with('group')
            ->first();
    }
}