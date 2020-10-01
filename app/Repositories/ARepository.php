<?php


namespace App\Repositories;


use Illuminate\Database\Eloquent\Model;

abstract class ARepository
{
    private $model;

    public function __construct()
    {
        $this->model = $this->init();
    }

    /*
     * @return Model
     * */
    abstract function init();

    public function start()
    {
        return new $this->model;
    }

    public function getAll()
    {
        return $this->start()
            ->select('*')
            ->get();
    }

    public function find($id)
    {
        return $this->start()
            ->select('*')
            ->where('id', $id)
            ->get();
    }
}