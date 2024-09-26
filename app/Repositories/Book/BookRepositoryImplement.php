<?php

namespace App\Repositories\Book;

use LaravelEasyRepository\Implementations\Eloquent;
use App\Models\Book;

class BookRepositoryImplement extends Eloquent implements BookRepository{

    /**
    * Model class to be used in this repository for the common methods inside Eloquent
    * Don't remove or change $this->model variable name
    * @property Model|mixed $model;
    */
    protected $model;

    public function __construct(Book $model)
    {
        $this->model = $model;
    }

    // Write something awesome :)

    public function getAllBooks(int $limit, string $search = null): object
    {
        $query = $this->model->query();

        if ($search) {
            $query->where('title', 'like', '%' . $search . '%')->orWhere('description', 'like', '%' . $search . '%');
        }

        return $query->with('author')->paginate($limit);
    }

    public function findBookById(int $bookId): ?Book
    {
        return $this->model->with('author')->find($bookId);
    }

    public function createBook(array $data): Book
    {
        return $this->model->create($data);
    }

    public function updateBook(int $bookId, array $data): Book
    {
        $book = $this->model->with('author')->find($bookId);
        $book->update($data);
        return $book;
    }

    public function deleteBook(int $bookId): bool
    {
        return $this->model->destroy($bookId);
    }
}
