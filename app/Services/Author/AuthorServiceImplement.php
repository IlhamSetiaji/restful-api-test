<?php

namespace App\Services\Author;

use App\Models\Author;
use LaravelEasyRepository\Service;
use App\Repositories\Author\AuthorRepository;
use Illuminate\Support\Facades\Cache;

class AuthorServiceImplement extends Service implements AuthorService
{

    /**
     * don't change $this->mainRepository variable name
     * because used in extends service class
     */
    protected $mainRepository;

    public function __construct(AuthorRepository $mainRepository)
    {
        $this->mainRepository = $mainRepository;
    }

    // Define your custom methods :)

    public function getAllAuthors(int $limit, string $search = null): object
    {
        return $this->mainRepository->getAllAuthors($limit, $search);
    }

    public function findAuthorById(int $authorId): ?Author
    {
        return $this->mainRepository->findAuthorById($authorId);
    }

    public function createAuthor(array $data): Author
    {
        return $this->mainRepository->createAuthor($data);
    }

    public function updateAuthor(int $authorId, array $data): Author
    {
        return $this->mainRepository->updateAuthor($authorId, $data);
    }

    public function deleteAuthor(int $authorId): bool
    {
        return $this->mainRepository->deleteAuthor($authorId);
    }

    public function getAuthorBooks(int $authorId): object
    {
        return $this->mainRepository->getAuthorBooks($authorId);
    }

    public function getAuthorsUsingCache(int $limit, string $search = null): object
    {
        if (Cache::get(env('APP_NAME') . ':authors_data')) {
            return Cache::get(env('APP_NAME') . ':authors_data');
        }

        $authors = $this->mainRepository->getAllAuthors($limit, $search);
        Cache::put(env('APP_NAME') . ':authors_data', $authors, 60);
        return $authors;
    }

    public function getAuthorBooksUsingCache(int $authorId): object
    {
        if (Cache::get(env('APP_NAME') . ':author_books_data')) {
            return Cache::get(env('APP_NAME') . ':author_books_data');
        }

        $authorBooks = $this->mainRepository->getAuthorBooks($authorId);
        Cache::put(env('APP_NAME') . ':author_books_data', $authorBooks, 60);
        return $authorBooks;
    }
}
