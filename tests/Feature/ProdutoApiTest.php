<?php

namespace Tests\Feature;

use App\Models\Produto;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Laravel\Sanctum\Sanctum;

class ProdutoApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_api_usuario_nao_autenticado_nao_pode_acessar_produtos(): void
    {
        $response = $this->getJson(route('produtos.index')); // Note: route names are shared, but api routes usually have prefix 'api.' if resource is used. Wait, I used Route::apiResource('produtos') inside api.php, which defaults to 'produtos.index' but since it's in api.php and prefixed by api automatically? No, Route::apiResource in api.php usually gets 'produtos.index' name but the URL is /api/produtos.
        // Actually, if I used Route::apiResource('produtos') in api.php, the names are 'produtos.index', etc. BUT they might conflict with web routes if they have same names.
        // Laravel usually prefixes API route names with 'api.' if configured in bootstrap/app.php or RouteServiceProvider, but in Laravel 11 it's in routes/api.php.
        // Let's check the route list to be sure about names.
        
        // I'll assume the URL is /api/produtos for now.
        $response = $this->getJson('/api/produtos');
        $response->assertStatus(401);
    }

    public function test_api_usuario_autenticado_pode_ver_lista_de_produtos(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $response = $this->getJson('/api/produtos');
        $response->assertStatus(200);
    }

    public function test_api_usuario_pode_criar_produto(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $dados = [
            'nome' => 'Produto API Test',
            'descricao' => 'Desc API',
            'preco' => 60.00,
            'quantidade_estoque' => 25,
        ];

        $response = $this->postJson('/api/produtos', $dados);

        $response->assertStatus(201)
                 ->assertJsonFragment(['nome' => 'Produto API Test']);
        
        $this->assertDatabaseHas('produtos', ['nome' => 'Produto API Test']);
    }

    public function test_api_usuario_pode_atualizar_produto(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        $produto = Produto::factory()->create();

        $dados = [
            'nome' => 'Produto API Atualizado',
            'descricao' => 'Nova Desc API',
            'preco' => 160.00,
            'quantidade_estoque' => 35,
        ];

        $response = $this->putJson("/api/produtos/{$produto->id}", $dados);

        $response->assertStatus(200)
                 ->assertJsonFragment(['nome' => 'Produto API Atualizado']);
        
        $this->assertDatabaseHas('produtos', ['nome' => 'Produto API Atualizado']);
    }

    public function test_api_usuario_pode_excluir_produto(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        $produto = Produto::factory()->create();

        $response = $this->deleteJson("/api/produtos/{$produto->id}");

        $response->assertStatus(200);
        $this->assertDatabaseMissing('produtos', ['id' => $produto->id]);
    }
}
