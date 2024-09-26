<?php

namespace App\Services\Author;

use App\Models\Author;
use LaravelEasyRepository\BaseService;

interface AuthorService extends BaseService{

    // Write something awesome :)

    public function getAllAuthors(int $limit, string $search = null): object;
    public function findAuthorById(int $authorId): ?Author;
    public function createAuthor(array $data): Author;
    public function updateAuthor(int $authorId, array $data): Author;
    public function deleteAuthor(int $authorId): bool;
    public function getAuthorBooks(int $authorId): object;
    public function getAuthorsUsingCache(int $limit, string $search = null): object;
    public function getAuthorBooksUsingCache(int $authorId): object;
}
