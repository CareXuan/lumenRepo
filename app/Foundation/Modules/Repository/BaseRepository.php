<?php


namespace App\Foundation\Modules\Repository;

use Illuminate\Database\Eloquent\Model;
use Doctrine\DBAL\Exception\ServerException;

abstract class BaseRepository implements RepositoryInterface
{
    protected $model;

    protected $query = null;

    public function __construct()
    {

    }

    public function makeModel()
    {
        $model = app($this->setModel());
        if (!$model instanceof Model) {
            throw new ServerException("Class {$this->model()} must be an instance of Illuminate\\Database\\Eloquent\\Model");
        }

        return $this->model = $model;
    }

    /**
     * 获取Eloquent Model
     *
     * @return mixed
     */
    public function m()
    {
        return $this->model;
    }

    public function write()
    {
        return $this->model->writePdo();
    }

    public function getQuery($isNew = false)
    {
        return $this->query || $isNew ? $this->query : $this->model->query();
    }

    public function getById($id, $select = ['*'])
    {
        return $this->m();
    }
}