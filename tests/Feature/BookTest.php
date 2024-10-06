<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\Author;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_get_all_books()
    {
        Book::factory()->count(3)->create();

        $response = $this->getJson('/api/books');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'data' => [
                    '*' => ['id','title', 'description', 'publish_date','author_id']
                ]
            ]);
    }

    public function test_can_get_single_book()
    {

        $book = Book::factory()->create();
        $response = $this->getJson("/api/books/{$book->id}");
        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'data' => [
                    'id' => $book->id,
                    'title' => $book->title,
                    'description' => $book->description,
                    'publish_date' => $book->publish_date->format('Y-m-d'),
                    'author_id' => $book->author_id,
                ]
            ]);
    }

    public function test_can_create_book()
    {
        $author = Author::factory()->create();
        $bookData = [
            'title' => 'New book title',
            'description' => 'New book Description',
            'publish_date' => '1995-02-10',
            'author_id' => $author->id
        ];
        $response = $this->postJson('/api/books', $bookData);
        $response->assertStatus(201)
            ->assertJson([
                'success' => true,
                'message' => 'Book Create Successful'
            ]);
        $this->assertDatabaseHas('books', $bookData);
    }

    public function test_can_update_book()
    {
        $author = Author::factory()->create();
        $book = Book::factory()->create();
        $updateData = [
            'title' => 'Update book title',
            'description' => 'Update book Description',
            'publish_date' => '1999-02-10',
            'author_id' => $author->id
        ];
        $response = $this->putJson("/api/books/{$book->id}", $updateData);
        $response->assertStatus(201)
            ->assertJson([
                'success' => true,
                'data' => 'Book Update Successful'
            ]);
        $this->assertDatabaseHas('books', $updateData);
    }

    public function test_can_delete_book()
    {
        $book = Book::factory()->create();
        $response = $this->deleteJson("/api/books/{$book->id}");
        $response->assertStatus(204);
        $this->assertDatabaseMissing('books', ['id' => $book->id]);
    }
}
