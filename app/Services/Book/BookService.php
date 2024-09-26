<?php

namespace App\Services\Book;

use App\Models\Book;
use LaravelEasyRepository\BaseService;

interface BookService extends BaseService{

    // Write something awesome :)

    public function getAllBooks(int $limit, string $search = null): object;
    public function findBookById(int $bookId): ?Book;
    public function createBook(array $data): Book;
    public function updateBook(int $bookId, array $data): Book;
    public function deleteBook(int $bookId): bool;
    public function getAllBooksUsingCache(int $limit, string $search = null): object;
}
