<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProdutoRequest;
use App\Models\Produto;
use App\Services\ProdutoService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class ProdutoController extends Controller
{
    use ApiResponse;

    protected $produtoService;

    public function __construct(ProdutoService $produtoService)
    {
        $this->produtoService = $produtoService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $filters = $request->only(['search', 'min_price', 'max_price', 'min_stock', 'sort', 'direction']);
        $produtos = $this->produtoService->list($filters, $perPage);

        return $this->success($produtos, 'Produtos recuperados com sucesso.');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProdutoRequest $request)
    {
        $produto = $this->produtoService->create($request->validated());

        return $this->success($produto, 'Produto criado com sucesso.', 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Produto $produto)
    {
        return $this->success($produto, 'Produto recuperado com sucesso.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProdutoRequest $request, Produto $produto)
    {
        $produto = $this->produtoService->update($produto, $request->validated());

        return $this->success($produto, 'Produto atualizado com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Produto $produto)
    {
        $this->produtoService->delete($produto);

        return $this->success(null, 'Produto excluído com sucesso.');
    }
}
