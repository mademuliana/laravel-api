<?php

namespace App\Repositories;
use App\Models\Author;
use App\Interfaces\AuthorRepositoryInterface;
class AuthorRepository implements AuthorRepositoryInterface
{
    public function index(){
        return Author::all();
    }

    public function getById($id){
       return Author::findOrFail($id);
    }

    public function store(array $data){
       return Author::create($data);
    }

    public function update(array $data,$id){
       return Author::whereId($id)->update($data);
    }

    public function delete($id){
       Author::destroy($id);
    }
}
