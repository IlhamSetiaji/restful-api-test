<?php

namespace Tests\Unit;

use App\Models\Book;
use App\Repositories\Book\BookRepository;
use App\Services\Book\BookServiceImplement;
use Mockery;
use PHPUnit\Framework\TestCase;

class BookServiceTest extends TestCase
{
    protected $bookRepositoryMock;
    protected $bookService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->bookRepositoryMock = Mockery::mock(BookRepository::class);
        $this->bookService = new BookServiceImplement($this->bookRepositoryMock);
    }

    public function testGetAllBooks()
    {
        $limit = 10;
        $search = 'The Great Gatsby';

        $this->bookRepositoryMock->shouldReceive('getAllBooks')
            ->once()
            ->with($limit, $search)
            ->andReturn(collect());

        $result = $this->bookService->getAllBooks($limit, $search);

        $this->assertInstanceOf('Illuminate\Support\Collection', $result);
    }

    public function testFindBookById()
    {
        $book = new Book();
        $book->id = 1;
        $book->title = 'The Great Gatsby';
        $book->description = 'Lorem ipsum';
        $book->release_date = '1925-04-10';

        $this->bookRepositoryMock->shouldReceive('findBookById')
            ->once()
            ->with(1)
            ->andReturn($book);

        $result = $this->bookService->findBookById(1);

        $this->assertInstanceOf(Book::class, $result);
        $this->assertEquals(1, $result->id);
        $this->assertEquals('The Great Gatsby', $result->title);
        $this->assertEquals('Lorem ipsum', $result->description);
        $this->assertEquals('1925-04-10', $result->release_date);
    }

    public function testCreateBook()
    {
        $book = new Book();
        $book->id = 1;
        $book->title = 'The Great Gatsby';
        $book->description = 'Lorem ipsum';
        $book->release_date = '1925-04-10';

        $this->bookRepositoryMock->shouldReceive('createBook')
            ->once()
            ->with([
                'title' => 'The Great Gatsby',
                'description' => 'Lorem ipsum',
                'release_date' => '1925-04-10',
            ])
            ->andReturn($book);

        $result = $this->bookService->createBook([
            'title' => 'The Great Gatsby',
            'description' => 'Lorem ipsum',
            'release_date' => '1925-04-10',
        ]);

        $this->assertInstanceOf(Book::class, $result);
        $this->assertEquals(1, $result->id);
        $this->assertEquals('The Great Gatsby', $result->title);
        $this->assertEquals('Lorem ipsum', $result->description);
        $this->assertEquals('1925-04-10', $result->release_date);
    }

    public function testUpdateBook()
    {
        $book = new Book();
        $book->id = 1;
        $book->title = 'The Great Gatsby';
        $book->description = 'Lorem ipsum';
        $book->release_date = '1925-04-10';

        $this->bookRepositoryMock->shouldReceive('updateBook')
            ->once()
            ->with(1, [
                'title' => 'The Great Gatsby',
                'description' => 'Lorem ipsum',
                'release_date' => '1925-04-10',
            ])
            ->andReturn($book);

        $result = $this->bookService->updateBook(1, [
            'title' => 'The Great Gatsby',
            'description' => 'Lorem ipsum',
            'release_date' => '1925-04-10',
        ]);

        $this->assertInstanceOf(Book::class, $result);
        $this->assertEquals(1, $result->id);
        $this->assertEquals('The Great Gatsby', $result->title);
        $this->assertEquals('Lorem ipsum', $result->description);
        $this->assertEquals('1925-04-10', $result->release_date);
    }

    public function testDeleteBook()
    {
        $this->bookRepositoryMock->shouldReceive('deleteBook')
            ->once()
            ->with(1)
            ->andReturn(true);

        $result = $this->bookService->deleteBook(1);

        $this->assertTrue($result);
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        Mockery::close();
    }
}
