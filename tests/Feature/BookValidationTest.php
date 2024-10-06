<?php

namespace Tests\Feature;

use App\Models\Author;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookValidationTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_book_fails_when_all_fields_are_missing()
    {
        $response = $this->postJson('/api/books', []);
        $response->assertStatus(422)
            ->assertJsonValidationErrors(['title', 'author_id']);
    }

    public function test_create_book_fails_when_title_is_missing()
    {
        $author = Author::factory()->create();

        $invalidData = [
            'description' => 'A valid book description',
            'publish_date' => '1999-10-10',
            'author_id' => $author->id,
        ];

        $response = $this->postJson('/api/books', $invalidData);
        $response->assertStatus(422)
            ->assertJsonValidationErrors(['title']);
    }

    public function test_create_book_fails_when_author_id_is_missing()
    {
        $invalidData = [
            'title' => 'New Book',
            'description' => 'Description of the book',
            'publish_date' => '2024-10-06',
        ];

        $response = $this->postJson('/api/books', $invalidData);
        $response->assertStatus(422)
            ->assertJsonValidationErrors(['author_id']);
    }

    public function test_create_book_fails_when_title_is_empty_title()
    {
        $invalidData = [
            'title' => '', // the only string that doesn't allow its to be empty
            'description' => 'A valid description',
            'publish_date' => '2024-10-06',
            'author_id' => 1,
        ];

        $response = $this->postJson('/api/books', $invalidData);
        $response->assertStatus(422)
            ->assertJsonValidationErrors(['title']);
    }

    public function test_book_validation_fails_with_invalid_date()
    {
        $author = Author::factory()->create();
        $invalidData = [
            'title' => 'A sample book title',
            'description' => 'A sample book description',
            'publish_date' => 'invalid-date', // Invalid date
            'author_id' => $author->id,
        ];

        $response = $this->postJson('/api/books', $invalidData);
        $response->assertStatus(422);

        $response->assertJsonValidationErrors([
            'publish_date',
        ]);
    }

    public function test_book_validation_fails_with_future_date()
    {
        $author = Author::factory()->create();
        $invalidData = [
            'title' => 'A sample book title',
            'description' => 'A sample book description',
            'publish_date' => now()->addDay()->toDateString(), // Invalid date
            'author_id' => $author->id,
        ];

        $response = $this->postJson('/api/books', $invalidData);
        $response->assertStatus(422);

        $response->assertJsonValidationErrors([
            'publish_date',
        ]);
    }

    public function test_book_validation_fails_with_invalid_author_id()
    {
        $invalidData = [
            'title' => 'Sample Title',
            'description' => 'A sample book description',
            'publish_date' => '1999-10-10',
            'author_id' => 9999, // Non-existent author
        ];

        $response = $this->postJson('/api/books', $invalidData);

        $response->assertStatus(422);

        $response->assertJsonValidationErrors('author_id');
    }

    public function test_book_validation_passes_with_valid_data()
    {
        $author = Author::factory()->create();

        $validData = [
            'title' => 'Valid Book Title',
            'description' => 'A valid book description',
            'publish_date' => '1999-10-10',
            'author_id' => $author->id,
        ];

        $response = $this->postJson('/api/books', $validData);
        $response->assertStatus(201);

        $response->assertJson([
            'success' => true,
            'message' => 'Book Create Successful',
        ]);
    }
}
