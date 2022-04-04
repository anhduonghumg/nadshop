<?php

namespace App\Repositories;


interface RepositoryInterface
{

    public function get();
    public function get_list_by_id($id);
    public function add($data);
    public function update($data, $id);
    public function delete($data, $id);
    public function forceDelete($id);
}
