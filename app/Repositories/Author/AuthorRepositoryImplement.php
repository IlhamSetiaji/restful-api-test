<?php

namespace App\Repositories\Author;

use LaravelEasyRepository\Implementations\Eloquent;
use App\Models\Author;

class AuthorRepositoryImplement extends Eloquent implements AuthorRepository
{

    /**
     * Model class to be used in this repository for the common methods inside Eloquent
     * Don't remove or change $this->model variable name
     * @property Model|mixed $model;
     */
    protected $model;

    public function __construct(Author $model)
    {
        $this->model = $model;
    }

    // Write something awesome :)

    public function getAllAuthors(int $limit, string $search = null): object
    {
        $query = $this->model->query();

        if ($search) {
            $query->where('name', 'like', '%' . $search . '%')->orWhere('bio', 'like', '%' . $search . '%');
        }

        return $query->paginate($limit);
    }

    public function findAuthorById(int $authorId): ?Author
    {
        return $this->model->find($authorId);
    }

    public function createAuthor(array $data): Author
    {
        return $this->model->create($data);
    }

    public function updateAuthor(int $authorId, array $data): Author
    {
        $author = $this->model->find($authorId);
        $author->update($data);
        return $author;
    }

    public function deleteAuthor(int $authorId): bool
    {
        return $this->model->destroy($authorId);
    }

    public function getAuthorBooks(int $authorId): object
    {
        $author = $this->model->find($authorId);
        return $author->books()->with('author')->paginate(10);
    }
}
