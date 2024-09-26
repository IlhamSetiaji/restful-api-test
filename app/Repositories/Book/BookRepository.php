<?php

namespace App\Repositories\Book;

use App\Models\Book;
use LaravelEasyRepository\Repository;

interface BookRepository extends Repository
{

    // Write something awesome :)

    public function getAllBooks(int $limit, string $search = null): object;
    public function findBookById(int $bookId): ?Book;
    public function createBook(array $data): Book;
    public function updateBook(int $bookId, array $data): Book;
    public function deleteBook(int $bookId): bool;
}
