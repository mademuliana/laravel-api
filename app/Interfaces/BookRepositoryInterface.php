<?php

namespace App\Interfaces;

interface BookRepositoryInterface
{
    public function index();
    public function getById($id);
    public function getByAuthorId($id);
    public function store(array $data);
    public function update(array $data, $id);
    public function delete($id);
}
