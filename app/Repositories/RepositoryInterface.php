<?php

namespace App\Repositories;


interface RepositoryInterface
{

    public function get();
    public function add($data);
    public function update($data, $id);
    public function delete($data, $id);
    public function forceDelete($id);
}
