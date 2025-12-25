<?php

namespace Tests\Feature\Api;

use App\Models\Produto;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProdutoApiTest extends TestCase
{
    use RefreshDatabase;

    protected $user;
    protected $token;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        /** @var \Tymon\JWTAuth\JWTGuard $guard */
        $guard = auth('api');
        $this->token = $guard->login($this->user);
    }

    protected function headers()
    {
        return ['Authorization' => 'Bearer ' . $this->token];
    }

    public function test_can_list_produtos()
    {
        Produto::factory()->count(3)->create();

        $response = $this->getJson('/api/produtos', $this->headers());

        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'data' => [
                         '*' => ['id', 'nome', 'preco']
                     ],
                     'meta' => [
                         'current_page',
                         'last_page',
                         'per_page',
                         'total'
                     ]
                 ]);
    }

    public function test_can_create_produto()
    {
        $data = [
            'nome' => 'Novo Produto',
            'descricao' => 'Descrição do novo produto',
            'preco' => '150,00', // Sending as BR format string because of Request logic
            'quantidade_estoque' => 10,
        ];

        $response = $this->postJson('/api/produtos', $data, $this->headers());

        $response->assertStatus(201)
                 ->assertJsonPath('data.nome', 'Novo Produto')
                 ->assertJsonPath('data.preco', '150.00'); // DB stores as decimal
        
        $this->assertDatabaseHas('produtos', ['nome' => 'Novo Produto']);
    }

    public function test_can_show_produto()
    {
        $produto = Produto::factory()->create();

        $response = $this->getJson("/api/produtos/{$produto->id}", $this->headers());

        $response->assertStatus(200)
                 ->assertJsonPath('data.id', $produto->id);
    }

    public function test_can_update_produto()
    {
        $produto = Produto::factory()->create();
        $data = [
            'nome' => 'Produto Atualizado',
            'descricao' => 'Descrição Atualizada',
            'preco' => '200,50',
            'quantidade_estoque' => 20,
        ];

        $response = $this->putJson("/api/produtos/{$produto->id}", $data, $this->headers());

        $response->assertStatus(200)
                 ->assertJsonPath('data.nome', 'Produto Atualizado');

        $this->assertDatabaseHas('produtos', ['id' => $produto->id, 'nome' => 'Produto Atualizado']);
    }

    public function test_can_delete_produto()
    {
        $produto = Produto::factory()->create();

        $response = $this->deleteJson("/api/produtos/{$produto->id}", [], $this->headers());

        $response->assertStatus(200);
        $this->assertDatabaseMissing('produtos', ['id' => $produto->id]);
    }

    public function test_unauthenticated_user_cannot_access_produtos()
    {
        /** @var \Tymon\JWTAuth\JWTGuard $guard */
        $guard = auth('api');
        $guard->logout();
        
        $response = $this->getJson('/api/produtos');
        $response->assertStatus(401);
    }
}
