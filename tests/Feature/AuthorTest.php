<?php

namespace Tests\Feature;

use App\Models\Author;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthorTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_get_all_authors()
    {
        Author::factory()->count(3)->create();

        $response = $this->getJson('/api/authors');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'data' => [
                    '*' => ['id','name', 'bio', 'birth_date']
                ]
            ]);
    }

    public function test_can_get_single_author()
    {
        $author = Author::factory()->create();
        $response = $this->getJson("/api/authors/{$author->id}");
        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'data' => [
                    'id' => $author->id,
                    'name' => $author->name,
                    'bio' => $author->bio,
                    'birth_date' => $author->birth_date->format('Y-m-d'),
                ]
            ]);
    }

    public function test_can_create_author()
    {
        $authorData = [
            'name' => 'New author title',
            'bio' => 'New author bio',
            'birth_date' => '1995-02-10'
        ];
        $response = $this->postJson('/api/authors', $authorData);
        $response->assertStatus(201)
            ->assertJson([
                'success' => true,
                'message' => 'Author Create Successful'
            ]);
        $this->assertDatabaseHas('authors', $authorData);
    }

    public function test_can_update_author()
    {
        $author = Author::factory()->create();
        $updateData = [
            'name' => 'New author name',
            'bio' => 'New author bio',
            'birth_date' => '1995-02-10'
        ];
        $response = $this->putJson("/api/authors/{$author->id}", $updateData);
        $response->assertStatus(201)
            ->assertJson([
                'success' => true,
                'data' => 'Author Update Successful'
            ]);
        $this->assertDatabaseHas('authors', $updateData);
    }

    public function test_can_delete_author()
    {
        $author = Author::factory()->create();
        $response = $this->deleteJson("/api/authors/{$author->id}");
        $response->assertStatus(204);
        $this->assertDatabaseMissing('authors', ['id' => $author->id]);
    }
}
