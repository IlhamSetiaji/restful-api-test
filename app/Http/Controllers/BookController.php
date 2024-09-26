<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseFormatter;
use App\Http\Requests\Book\CreateBookRequest;
use App\Http\Resources\Book\BookResource;
use App\Services\Book\BookService;
use GuzzleHttp\Psr7\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookController extends Controller
{
    private $bookService;

    public function __construct(BookService $bookService)
    {
        $this->bookService = $bookService;
    }

    public function getAllBooks(Request $request): object
    {
        $limit = $request->get('limit', 10);
        $search = $request->get('search', null);

        try {
            $books = $this->bookService->getAllBooks($limit, $search);
            return ResponseFormatter::success([
                'books' => new BookResource($books, $books),
            ], 'Get Books Success', null, null, 200);
        } catch (\Exception $e) {
            return ResponseFormatter::error([
                'message' => $e->getMessage()
            ], 'Get Books Failed', null, null, 500);
        }
    }

    public function findBookById(int $bookId): object
    {
        try {
            $book = $this->bookService->findBookById($bookId);
            if (!$book) {
                return response()->json([
                    'message' => 'Book not found'
                ], 404);
            }
            return ResponseFormatter::success(
                new BookResource($book),
                'Find Book Success',
                null,
                null,
                200
            );
        } catch (\Exception $e) {
            return ResponseFormatter::error([
                'message' => $e->getMessage()
            ], 'Find Book Failed', null, null, 500);
        }
    }

    public function createBook(CreateBookRequest $request): object
    {
        $payload = $request->validated();
        try {
            DB::beginTransaction();
            $book = $this->bookService->createBook($payload);
            $book->load('author');
            DB::commit();
            return ResponseFormatter::success(
                new BookResource($book),
                'Create Book Success',
                null,
                null,
                201
            );
        } catch (\Exception $e) {
            DB::rollBack();
            return ResponseFormatter::error([
                'message' => $e->getMessage()
            ], 'Create Book Failed', null, null, 500);
        }
    }

    public function updateBook(int $bookId, CreateBookRequest $request): object
    {
        $payload = $request->validated();
        try {
            if(!$this->bookService->findBookById($bookId)) {
                return ResponseFormatter::error([
                    'message' => 'Book not found'
                ], 'Update Book Failed', null, null, 404);
            }
            DB::beginTransaction();
            $book = $this->bookService->updateBook($bookId, $payload);
            DB::commit();
            return ResponseFormatter::success(
                new BookResource($book),
                'Update Book Success',
                null,
                null,
                200
            );
        } catch (\Exception $e) {
            DB::rollBack();
            return ResponseFormatter::error([
                'message' => $e->getMessage()
            ], 'Update Book Failed', null, null, 500);
        }
    }

    public function deleteBook(int $bookId): object
    {
        try {
            if(!$this->bookService->findBookById($bookId)) {
                return ResponseFormatter::error([
                    'message' => 'Book not found'
                ], 'Delete Book Failed', null, null, 404);
            }
            DB::beginTransaction();
            $this->bookService->deleteBook($bookId);
            DB::commit();
            return ResponseFormatter::success(
                null,
                'Delete Book Success',
                null,
                null,
                200
            );
        } catch (\Exception $e) {
            DB::rollBack();
            return ResponseFormatter::error([
                'message' => $e->getMessage()
            ], 'Delete Book Failed', null, null, 500);
        }
    }

    public function getAllBooksUsingCache(Request $request): object
    {
        $limit = $request->get('limit', 10);
        $search = $request->get('search', null);

        try {
            $books = $this->bookService->getAllBooksUsingCache($limit, $search);
            return ResponseFormatter::success([
                'books' => new BookResource($books, $books),
            ], 'Get Books Success', null, null, 200);
        } catch (\Exception $e) {
            return ResponseFormatter::error([
                'message' => $e->getMessage()
            ], 'Get Books Failed', null, null, 500);
        }
    }
}
