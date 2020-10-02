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
    /**
     * Сохранение модели
     *
     * @param [array] $data
     * @return Model $model
     */
    public function save(array $data)
    {
        $model = $this->start()
            ->fill($data);

        $model->save();

        return $model;
    }
    /**
     * Удаление
     *
     * @param integer $id
     * @return bool
     */
    public function remove(int $id){
        $model = $this->start()->find($id);
       
        return $model ? $model->delete() : false;
    }

    /**
     *  Редактирование модели
     *
     * @param array $data
     * @param integer $id
     * @return Model $model | bool
     */
    public function edit(array $data, int $id)
    {
        $model = $this->start()
            ->where('id', $id)
            ->first();
        if($model){
            $model->fill($data);
            $model->save();
        }

        return $model ? $model : false;
    }
    /**
     * Все записи из бд
     *
     * @return array | null
     */
    public function getAll()
    {
        return $this->start()
            ->select('*')
            ->get();
    }
    /**
     * Поиск в бд
     *
     * @param integer $id
     * @return array | null
     */
    public function find(int $id)
    {
        $model = $this->start()
            ->select('*')
            ->where('id', $id)
            ->first();

        return $model ? $model : false;
    }
}
