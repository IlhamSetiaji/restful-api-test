<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseFormatter;
use App\Http\Requests\Author\CreateAuthorRequest;
use App\Http\Resources\Author\AuthorResource;
use App\Http\Resources\Book\BookResource;
use App\Services\Author\AuthorService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AuthorController extends Controller
{
    private $authorService;

    public function __construct(AuthorService $authorService)
    {
        $this->authorService = $authorService;
    }

    public function getAllAuthors(Request $request): object
    {
        $limit = $request->get('limit', 10);
        $search = $request->get('search', null);

        try {
            $authors = $this->authorService->getAllAuthors($limit, $search);
            return ResponseFormatter::success([
                new AuthorResource($authors, $authors),
            ], 'Get Authors Success', null, null, 200);
        } catch (\Exception $e) {
            return ResponseFormatter::error([
                'message' => $e->getMessage()
            ], 'Get Authors Failed', null, null, 500);
        }
    }

    public function findAuthorById(int $authorId): object
    {
        try {
            $author = $this->authorService->findAuthorById($authorId);
            if (!$author) {
                return ResponseFormatter::error([
                    'message' => 'Author not found'
                ], 'Find Author Failed', null, null, 404);
            }
            return ResponseFormatter::success(
                new AuthorResource($author),
                'Find Author Success',
                null,
                null,
                200
            );
        } catch (\Exception $e) {
            return ResponseFormatter::error([
                'message' => $e->getMessage()
            ], 'Find Author Failed', null, null, 500);
        }
    }

    public function createAuthor(CreateAuthorRequest $request): object
    {
        $payload = $request->validated();

        try {
            DB::beginTransaction();
            $author = $this->authorService->createAuthor($payload);
            DB::commit();
            return ResponseFormatter::success(
                new AuthorResource($author),
                'Create Author Success',
                null,
                null,
                201
            );
        } catch (\Exception $e) {
            DB::rollBack();
            return ResponseFormatter::error([
                'message' => $e->getMessage()
            ], 'Create Author Failed', null, null, 500);
        }
    }

    public function updateAuthor(int $authorId, CreateAuthorRequest $request): object
    {
        $payload = $request->validated();

        try {
            if (!$this->authorService->findAuthorById($authorId)) {
                return ResponseFormatter::error([
                    'message' => 'Author not found'
                ], 'Update Author Failed', null, null, 404);
            }
            DB::beginTransaction();
            $author = $this->authorService->updateAuthor($authorId, $payload);
            DB::commit();
            return ResponseFormatter::success(
                new AuthorResource($author),
                'Update Author Success',
                null,
                null,
                200
            );
        } catch (\Exception $e) {
            DB::rollBack();
            return ResponseFormatter::error([
                'message' => $e->getMessage()
            ], 'Update Author Failed', null, null, 500);
        }
    }

    public function deleteAuthor(int $authorId): object
    {
        try {
            if (!$this->authorService->findAuthorById($authorId)) {
                return ResponseFormatter::error([
                    'message' => 'Author not found'
                ], 'Delete Author Failed', null, null, 404);
            }
            DB::beginTransaction();
            $this->authorService->deleteAuthor($authorId);
            DB::commit();
            return ResponseFormatter::success(
                null,
                'Delete Author Success',
                null,
                null,
                200
            );
        } catch (\Exception $e) {
            DB::rollBack();
            return ResponseFormatter::error([
                'message' => $e->getMessage()
            ], 'Delete Author Failed', null, null, 500);
        }
    }

    public function getAuthorBooks(int $authorId): object
    {
        try {
            if (!$this->authorService->findAuthorById($authorId)) {
                return ResponseFormatter::error([
                    'message' => 'Author not found'
                ], 'Get Author Books Failed', null, null, 404);
            }
            $books = $this->authorService->getAuthorBooks($authorId);
            return ResponseFormatter::success([
                new BookResource($books, $books),
            ], 'Get Author Books Success', null, null, 200);
        } catch (\Exception $e) {
            return ResponseFormatter::error([
                'message' => $e->getMessage()
            ], 'Get Author Books Failed', null, null, 500);
        }
    }

    public function getAuthorsUsingCache(Request $request): object
    {
        $limit = $request->get('limit', 10);
        $search = $request->get('search', null);

        try {
            $authors = $this->authorService->getAuthorsUsingCache($limit, $search);
            return ResponseFormatter::success([
                new AuthorResource($authors, $authors),
            ], 'Get Authors Using Cache Success', null, null, 200);
        } catch (\Exception $e) {
            return ResponseFormatter::error([
                'message' => $e->getMessage()
            ], 'Get Authors Using Cache Failed', null, null, 500);
        }
    }

    public function getAuthorBooksUsingCache(int $authorId): object
    {
        try {
            if (!$this->authorService->findAuthorById($authorId)) {
                return ResponseFormatter::error([
                    'message' => 'Author not found'
                ], 'Get Author Books Using Cache Failed', null, null, 404);
            }
            $authorBooks = $this->authorService->getAuthorBooksUsingCache($authorId);
            return ResponseFormatter::success([
                new BookResource($authorBooks, $authorBooks),
            ], 'Get Author Books Using Cache Success', null, null, 200);
        } catch (\Exception $e) {
            return ResponseFormatter::error([
                'message' => $e->getMessage()
            ], 'Get Author Books Using Cache Failed', null, null, 500);
        }
    }
}
