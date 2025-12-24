<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProdutoRequest;
use App\Models\Produto;
use App\Interfaces\ProdutoServiceInterface;
use Illuminate\Http\Request;

class ProdutoController extends Controller
{
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

        return view('produtos.index', compact('produtos'));
    }

    /**
     * Mostra o formulário para criar um novo recurso.
     */
    public function create()
    {
        return view('produtos.create');
    }

    /**
     * Armazena um recurso recém-criado no armazenamento.
     */
    public function store(ProdutoRequest $request)
    {
        $this->produtoService->create($request->validated());

        return redirect()->route('produtos.index')
                         ->with('success', 'Produto criado com sucesso!');
    }

    /**
     * Exibe o recurso especificado.
     */
    public function show(Produto $produto)
    {
        return view('produtos.show', compact('produto'));
    }

    /**
     * Mostra o formulário para editar o recurso especificado.
     */
    public function edit(Produto $produto)
    {
        return view('produtos.edit', compact('produto'));
    }

    /**
     * Atualiza o recurso especificado no armazenamento.
     */
    public function update(ProdutoRequest $request, Produto $produto)
    {
        $this->produtoService->update($produto, $request->validated());

        return redirect()->route('produtos.index')
                         ->with('success', 'Produto atualizado com sucesso.');
    }

    /**
     * Remove o recurso especificado do armazenamento.
     */
    public function destroy(Produto $produto)
    {
        $this->produtoService->delete($produto);

        return redirect()->route('produtos.index')
                         ->with('success', 'Produto excluído com sucesso.');
    }
}
