<?php

namespace Tests\Feature;

use App\Models\Author;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthorValidationTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_author_fails_when_all_fields_are_missing()
    {
        $response = $this->postJson('/api/authors', []);
        $response->assertStatus(422)
            ->assertJsonValidationErrors(['name']);
    }

    public function test_create_author_fails_when_name_is_missing()
    {
        $invalidData = [
            'bio' => 'A valid Author Bio',
            'birth_date' => '1999-10-10',
        ];

        $response = $this->postJson('/api/authors', $invalidData);
        $response->assertStatus(422)
            ->assertJsonValidationErrors(['name']);
    }


    public function test_create_author_fails_when_name_is_empty_name()
    {
        $invalidData = [
            'name' => '', // the only string that doesn't allow its to be empty
            'bio' => 'A valid bio',
            'birth_date' => '1999-10-10',
            'author_id' => 1,
        ];

        $response = $this->postJson('/api/authors', $invalidData);
        $response->assertStatus(422)
            ->assertJsonValidationErrors(['name']);
    }

    public function test_author_validation_fails_with_invalid_date()
    {
        $invalidData = [
            'name' => 'Sample Author name',
            'bio' => 'Sample Author Bio',
            'birth_date' => 'invalid-date', // Invalid date

        ];

        $response = $this->postJson('/api/authors', $invalidData);
        $response->assertStatus(422);

        $response->assertJsonValidationErrors([
            'birth_date',
        ]);
    }

    public function test_author_validation_fails_with_future_date()
    {
        $invalidData = [
            'name' => 'Sample Author name',
            'bio' => 'Sample Author Bio',
            'birth_date' => now()->addDay()->toDateString(),

        ];

        $response = $this->postJson('/api/authors', $invalidData);
        $response->assertStatus(422);

        $response->assertJsonValidationErrors([
            'birth_date',
        ]);
    }

    public function test_author_validation_passes_with_valid_data()
    {
        $validData = [
            'name' => 'Sample Author Name',
            'bio' => 'Sample Author Bio',
            'birth_date' => '1999-10-10',
        ];

        $response = $this->postJson('/api/authors', $validData);
        $response->assertStatus(201);

        $response->assertJson([
            'success' => true,
            'message' => 'Author Create Successful',
        ]);
    }
}
