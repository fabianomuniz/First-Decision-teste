<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProdutoRequest;
use App\Models\Produto;
use App\Interfaces\ProdutoServiceInterface;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class ProdutoController extends Controller
{
    use ApiResponse;

    protected $produtoService;

    public function __construct(ProdutoServiceInterface $produtoService)
    {
        $this->produtoService = $produtoService;
    }

    /**
     * Exibe uma lista do recurso.
     */
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $filters = $request->only(['search', 'min_price', 'max_price', 'min_stock', 'sort', 'direction']);
        $produtos = $this->produtoService->list($filters, $perPage);

        return $this->success($produtos, 'Produtos recuperados com sucesso.');
    }

    /**
     * Armazena um recurso recém-criado no armazenamento.
     */
    public function store(ProdutoRequest $request)
    {
        $produto = $this->produtoService->create($request->validated());

        return $this->success($produto, 'Produto criado com sucesso.', 201);
    }

    /**
     * Exibe o recurso especificado.
     */
    public function show(Produto $produto)
    {
        return $this->success($produto, 'Produto recuperado com sucesso.');
    }

    /**
     * Atualiza o recurso especificado no armazenamento.
     */
    public function update(ProdutoRequest $request, Produto $produto)
    {
        $produto = $this->produtoService->update($produto, $request->validated());

        return $this->success($produto, 'Produto atualizado com sucesso.');
    }

    /**
     * Remove o recurso especificado do armazenamento.
     */
    public function destroy(Produto $produto)
    {
        $this->produtoService->delete($produto);

        return $this->success(null, 'Produto excluído com sucesso.');
    }
}
