<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProdutoRequest;
use App\Models\Produto;
use App\Services\ProdutoService;
use Illuminate\Http\Request;

class ProdutoController extends Controller
{
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
        
        // Clean mask from price inputs
        if (isset($filters['min_price'])) {
            $filters['min_price'] = str_replace(['.', ','], ['', '.'], $filters['min_price']);
        }
        if (isset($filters['max_price'])) {
            $filters['max_price'] = str_replace(['.', ','], ['', '.'], $filters['max_price']);
        }

        $produtos = $this->produtoService->list($filters, $perPage);

        return view('produtos.index', compact('produtos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('produtos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProdutoRequest $request)
    {
        $this->produtoService->create($request->validated());

        return redirect()->route('produtos.index')
                         ->with('success', 'Produto criado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Produto $produto)
    {
        return view('produtos.show', compact('produto'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Produto $produto)
    {
        return view('produtos.edit', compact('produto'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProdutoRequest $request, Produto $produto)
    {
        $this->produtoService->update($produto, $request->validated());

        return redirect()->route('produtos.index')
                         ->with('success', 'Produto atualizado com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Produto $produto)
    {
        $this->produtoService->delete($produto);

        return redirect()->route('produtos.index')
                         ->with('success', 'Produto excluído com sucesso.');
    }
}
