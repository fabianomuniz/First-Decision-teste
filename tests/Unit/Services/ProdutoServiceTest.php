<?php

namespace Tests\Unit\Services;

use App\Models\Produto;
use App\Services\ProdutoService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProdutoServiceTest extends TestCase
{
    use RefreshDatabase;

    protected $produtoService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->produtoService = new ProdutoService();
    }

    public function test_create_produto()
    {
        $data = [
            'nome' => 'Produto Teste',
            'descricao' => 'Descrição Teste',
            'preco' => 100.50,
            'quantidade_estoque' => 10,
        ];

        $produto = $this->produtoService->create($data);

        $this->assertInstanceOf(Produto::class, $produto);
        $this->assertDatabaseHas('produtos', $data);
    }

    public function test_update_produto()
    {
        $produto = Produto::factory()->create();
        $data = ['nome' => 'Nome Atualizado'];

        $updatedProduto = $this->produtoService->update($produto, $data);

        $this->assertEquals('Nome Atualizado', $updatedProduto->nome);
        $this->assertDatabaseHas('produtos', ['id' => $produto->id, 'nome' => 'Nome Atualizado']);
    }

    public function test_delete_produto()
    {
        $produto = Produto::factory()->create();

        $this->produtoService->delete($produto);

        $this->assertDatabaseMissing('produtos', ['id' => $produto->id]);
    }

    public function test_list_produtos_with_search_filter()
    {
        Produto::factory()->create(['nome' => 'Produto A']);
        Produto::factory()->create(['nome' => 'Produto B']);

        $result = $this->produtoService->list(['search' => 'Produto A']);

        $this->assertCount(1, $result);
        $this->assertEquals('Produto A', $result->first()->nome);
    }

    public function test_list_produtos_with_price_filter()
    {
        Produto::factory()->create(['preco' => 10]);
        Produto::factory()->create(['preco' => 20]);
        Produto::factory()->create(['preco' => 30]);

        $result = $this->produtoService->list(['min_price' => 15, 'max_price' => 25]);

        $this->assertCount(1, $result);
        $this->assertEquals(20, $result->first()->preco);
    }
}
