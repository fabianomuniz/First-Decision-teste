<?php

namespace Tests\Unit\Models;

use App\Models\Produto;
use PHPUnit\Framework\TestCase;

class ProdutoTest extends TestCase
{
    public function test_produto_has_correct_fillables()
    {
        $produto = new Produto();
        $expectedFillables = ['nome', 'descricao', 'preco', 'quantidade_estoque'];

        $this->assertEquals($expectedFillables, $produto->getFillable());
    }
}
