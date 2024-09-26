<?php

use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('authors')->group(function () {
    Route::get('/', [AuthorController::class, 'getAllAuthors']);
    Route::get('/cache', [AuthorController::class, 'getAuthorsUsingCache']);
    Route::get('/{authorId}', [AuthorController::class, 'findAuthorById']);
    Route::post('/', [AuthorController::class, 'createAuthor']);
    Route::put('/{authorId}', [AuthorController::class, 'updateAuthor']);
    Route::delete('/{authorId}', [AuthorController::class, 'deleteAuthor']);
    Route::get('/{authorId}/books', [AuthorController::class, 'getAuthorBooks']);
    Route::get('/{authorId}/books/cache', [AuthorController::class, 'getAuthorBooksUsingCache']);
});

Route::prefix('books')->group(function () {
    Route::get('/', [BookController::class, 'getAllBooks']);
    Route::get('/cache', [BookController::class, 'getAllBooksUsingCache']);
    Route::get('/{bookId}', [BookController::class, 'findBookById']);
    Route::post('/', [BookController::class, 'createBook']);
    Route::put('/{bookId}', [BookController::class, 'updateBook']);
    Route::delete('/{bookId}', [BookController::class, 'deleteBook']);
});
