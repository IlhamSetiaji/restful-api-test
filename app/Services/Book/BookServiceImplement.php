<?php

namespace App\Services\Book;

use App\Models\Book;
use LaravelEasyRepository\Service;
use App\Repositories\Book\BookRepository;
use Illuminate\Support\Facades\Cache;

class BookServiceImplement extends Service implements BookService
{

    /**
     * don't change $this->mainRepository variable name
     * because used in extends service class
     */
    protected $mainRepository;

    public function __construct(BookRepository $mainRepository)
    {
        $this->mainRepository = $mainRepository;
    }

    // Define your custom methods :)

    public function getAllBooks(int $limit, string $search = null): object
    {
        return $this->mainRepository->getAllBooks($limit, $search);
    }

    public function findBookById(int $bookId): ?Book
    {
        return $this->mainRepository->findBookById($bookId);
    }

    public function createBook(array $data): Book
    {
        return $this->mainRepository->createBook($data);
    }

    public function updateBook(int $bookId, array $data): Book
    {
        return $this->mainRepository->updateBook($bookId, $data);
    }

    public function deleteBook(int $bookId): bool
    {
        return $this->mainRepository->deleteBook($bookId);
    }

    public function getAllBooksUsingCache(int $limit, string $search = null): object
    {
        if (Cache::get(env('APP_NAME') . ':books_data')) {
            return Cache::get(env('APP_NAME') . ':books_data');
        }

        $books = $this->mainRepository->getAllBooks($limit, $search);
        Cache::put(env('APP_NAME') . ':books_data', $books, 60);
        return $books;
    }
}
