<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class PostesApiTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
    }

    public function test_create_poste_success()
    {
        $payload = [
            'titre' => 'Titre Test',
            'contenu' => 'Ceci est un contenu de test'
        ];

        $response = $this->postJson('/api/postes', $payload);

        $response
            ->assertStatus(201)
            ->assertJson([
                'message' => 'Poste inserré'
            ]);

        $this->assertDatabaseHas('postes', [
            'titre' => 'Titre Test',
            'contenu' => 'Ceci est un contenu de test'
        ]);
    }

    public function test_get_poste_by_id_success()
    {
        DB::insert(
            'INSERT INTO postes (titre, contenu, created_at, updated_at)
            VALUES (?, ?, ?, ?)',
            ['Titre Test', 'Ceci est un contenu de test', now(), now()]
        );

        $poste = DB::selectOne(
            'SELECT id FROM postes WHERE titre = ?',
            ['Titre Test']
        );

        $response = $this->getJson('/api/postes/' . $poste->id);

        $response
            ->assertStatus(200)
            ->assertJson([
                'id' => $poste->id,
                'title' => 'Titre Test',
                'content' => 'Ceci est un contenu de test'
            ]);
    }
}
