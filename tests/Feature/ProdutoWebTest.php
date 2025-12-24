<?php

namespace Tests\Feature;

use App\Models\Produto;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProdutoWebTest extends TestCase
{
    use RefreshDatabase;

    public function test_usuario_nao_autenticado_nao_pode_acessar_produtos(): void
    {
        $response = $this->get(route('produtos.index'));
        $response->assertRedirect(route('login'));
    }

    public function test_usuario_autenticado_pode_ver_lista_de_produtos(): void
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get(route('produtos.index'));
        $response->assertStatus(200);
        $response->assertViewIs('produtos.index');
    }

    public function test_usuario_pode_criar_produto(): void
    {
        $user = User::factory()->create();
        $dados = [
            'nome' => 'Produto Web Test',
            'descricao' => 'Desc',
            'preco' => '50,00',
            'quantidade_estoque' => 20,
        ];

        $response = $this->actingAs($user)->post(route('produtos.store'), $dados);

        // Debug validation errors if any
        if ($response->status() === 302 && $response->headers->get('Location') !== route('produtos.index')) {
             $errors = session('errors');
             if ($errors) {
                 dump($errors->all());
             }
        }

        $response->assertRedirect(route('produtos.index'));
        $this->assertDatabaseHas('produtos', ['nome' => 'Produto Web Test']);
    }

    public function test_usuario_pode_atualizar_produto(): void
    {
        $user = User::factory()->create();
        $produto = Produto::factory()->create();

        $dados = [
            'nome' => 'Produto Atualizado',
            'descricao' => 'Nova Desc',
            'preco' => 150.00,
            'quantidade_estoque' => 30,
        ];

        $response = $this->actingAs($user)->put(route('produtos.update', $produto), $dados);

        $response->assertRedirect(route('produtos.index'));
        $this->assertDatabaseHas('produtos', ['nome' => 'Produto Atualizado']);
    }

    public function test_usuario_pode_excluir_produto(): void
    {
        $user = User::factory()->create();
        $produto = Produto::factory()->create();

        $response = $this->actingAs($user)->delete(route('produtos.destroy', $produto));

        $response->assertRedirect(route('produtos.index'));
        $this->assertDatabaseMissing('produtos', ['id' => $produto->id]);
    }
}
