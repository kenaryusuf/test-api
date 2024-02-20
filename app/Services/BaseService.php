<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

abstract class BaseService
{
    /**
     * @var Model
     */
    private $model;

    /**
     * @param Model $model
     * @return Model
     */
    public function setModel(Model $model)
    {
        $this->model = $model;

        return $model;
    }

    /**
     * @return Model
     */
    public function model()
    {
        return $this->model;
    }

    /**
     * @return Builder
     */
    public function query(): Builder
    {
        return $this->model->query();
    }

    public function findById($id)
    {
        return $this->model->find($id);
    }
    public function get()
    {
        return $this->query()->get();
    }
}
