<?php

namespace App\Repositories;
use App\Models\Book;
use App\Interfaces\BookRepositoryInterface;
use Illuminate\Support\Facades\Cache;
class BookRepository implements BookRepositoryInterface
{
    public function index(){
        return Book::all();
    }

    public function getById($id){
       return Book::findOrFail($id);
    }

    public function getByAuthorId($id){
        $cacheKey = 'author_books_' . $id;
        return Cache::remember($cacheKey, 60, function () use ($id) {
            return Book::where('author_id', $id)->get();
        });
     }

    public function store(array $data){
       return Book::create($data);
       Cache::forget('author_books_' . $book->author_id);
    }

    public function update(array $data,$id){
       return Book::whereId($id)->update($data);
       Cache::forget('author_books_' . $book->author_id);
    }

    public function delete($id){
       Book::destroy($id);
    }
}
