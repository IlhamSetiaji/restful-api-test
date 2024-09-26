<?php

namespace Tests\Unit;

use App\Models\Author;
use App\Repositories\Author\AuthorRepository;
use App\Services\Author\AuthorServiceImplement;
use Mockery;
use PHPUnit\Framework\TestCase;

class AuthorServiceTest extends TestCase
{
    protected $authorRepositoryMock;
    protected $authorService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->authorRepositoryMock = Mockery::mock(AuthorRepository::class);
        $this->authorService = new AuthorServiceImplement($this->authorRepositoryMock);
    }

    public function testGetAllAuthors()
    {
        $limit = 10;
        $search = 'John Doe';

        $this->authorRepositoryMock->shouldReceive('getAllAuthors')
            ->once()
            ->with($limit, $search)
            ->andReturn(collect());

        $result = $this->authorService->getAllAuthors($limit, $search);

        $this->assertInstanceOf('Illuminate\Support\Collection', $result);
    }

    public function testFindAuthorById()
    {
        $author = new Author();
        $author->id = 1;
        $author->name = 'John Doe';
        $author->bio = 'Lorem ipsum';
        $author->birth_date = '1990-01-01';

        $this->authorRepositoryMock->shouldReceive('findAuthorById')
            ->once()
            ->with(1)
            ->andReturn($author);

        $result = $this->authorService->findAuthorById(1);

        $this->assertInstanceOf(Author::class, $result);
        $this->assertEquals(1, $result->id);
        $this->assertEquals('John Doe', $result->name);
        $this->assertEquals('Lorem ipsum', $result->bio);
        $this->assertEquals('1990-01-01', $result->birth_date);
    }

    public function testCreateAuthor()
    {
        $data = ['name' => 'John Doe', 'bio' => 'Lorem ipsum', 'birth_date' => '1990-01-01'];

        $author = new Author();
        $author->id = 1;
        $author->name = $data['name'];
        $author->bio = $data['bio'];
        $author->birth_date = $data['birth_date'];

        $this->authorRepositoryMock->shouldReceive('createAuthor')
            ->once()
            ->with($data)
            ->andReturn($author);

        $result = $this->authorService->createAuthor($data);

        $this->assertInstanceOf(Author::class, $result);
        $this->assertEquals(1, $result->id);
        $this->assertEquals('John Doe', $result->name);
        $this->assertEquals('Lorem ipsum', $result->bio);
        $this->assertEquals('1990-01-01', $result->birth_date);
    }

    public function testUpdateAuthor()
    {
        $data = ['name' => 'John Doe', 'bio' => 'Lorem ipsum', 'birth_date' => '1990-01-01'];

        $author = new Author();
        $author->id = 1;
        $author->name = $data['name'];
        $author->bio = $data['bio'];
        $author->birth_date = $data['birth_date'];

        $this->authorRepositoryMock->shouldReceive('updateAuthor')
            ->once()
            ->with(1, $data)
            ->andReturn($author);

        $result = $this->authorService->updateAuthor(1, $data);

        $this->assertInstanceOf(Author::class, $result);
        $this->assertEquals(1, $result->id);
        $this->assertEquals('John Doe', $result->name);
        $this->assertEquals('Lorem ipsum', $result->bio);
        $this->assertEquals('1990-01-01', $result->birth_date);
    }

    public function testDeleteAuthor()
    {
        $this->authorRepositoryMock->shouldReceive('deleteAuthor')
            ->once()
            ->with(1)
            ->andReturn(true);

        $result = $this->authorService->deleteAuthor(1);

        $this->assertTrue($result);
    }

    public function testGetAuthorBooks()
    {
        $author = new Author();
        $author->id = 1;
        $author->name = 'John Doe';
        $author->bio = 'Lorem ipsum';
        $author->birth_date = '1990-01-01';

        $this->authorRepositoryMock->shouldReceive('getAuthorBooks')
            ->once()
            ->with(1)
            ->andReturn(collect());

        $result = $this->authorService->getAuthorBooks(1);

        $this->assertInstanceOf('Illuminate\Support\Collection', $result);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
