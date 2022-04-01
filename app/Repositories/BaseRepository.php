<?php

namespace App\Repositories;

use App\Repositories\RepositoryInterface;

abstract class BaseRepository implements RepositoryInterface
{
    protected $model;

    public function __construct()
    {
        $this->setModel();
    }

    abstract public function getModel();

    public function setModel()
    {
        $this->model = app()->make(
            $this->getModel()
        );
    }

    public function get()
    {
        return $this->model->all();
    }

    public function add($data)
    {
        return $this->model->create($data);
    }

    public function update($data, $id)
    {
        if (is_array($id))
            return $this->model->whereIn('id', $id)->update($data);
        return $this->model->where('id', $id)->update($data);
    }

    public function delete($data, $id)
    {
        if (is_array($id))
            return $this->model->whereIn('id', $id)->update($data);
        return $this->model->where('id', $id)->update($data);
    }

    public function forceDelete($id)
    {
        if (is_array($id))
            return $this->model->whereIn('id', $id)->delete();
        return $this->model->where('id', $id)->delete();
    }
}
