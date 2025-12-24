<?php

namespace Tests\Unit;

use App\Models\Produto;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProdutoTest extends TestCase
{
    use RefreshDatabase;

    public function test_produto_pode_ser_criado_com_atributos_validos(): void
    {
        $dados = [
            'nome' => 'Produto Teste',
            'descricao' => 'Descrição do produto teste',
            'preco' => 99.90,
            'quantidade_estoque' => 10,
        ];

        $produto = Produto::create($dados);

        $this->assertInstanceOf(Produto::class, $produto);
        $this->assertEquals($dados['nome'], $produto->nome);
        $this->assertEquals($dados['preco'], $produto->preco);
    }

    public function test_nome_produto_deve_ser_unico(): void
    {
        $dados = [
            'nome' => 'Produto Duplicado',
            'preco' => 10.00,
            'quantidade_estoque' => 5,
        ];

        Produto::create($dados);

        $this->expectException(\Illuminate\Database\QueryException::class);

        Produto::create($dados);
    }
}
