<?php

namespace App\Services;

use App\Interfaces\ProdutoRepositoryInterface;
use App\Interfaces\ProdutoServiceInterface;
use App\Models\Produto;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ProdutoService implements ProdutoServiceInterface
{
    protected $produtoRepository;

    public function __construct(ProdutoRepositoryInterface $produtoRepository)
    {
        $this->produtoRepository = $produtoRepository;
    }

    public function list(array $filters = [], int $perPage = 10): LengthAwarePaginator
    {
        return $this->produtoRepository->getAll($filters, $perPage);
    }

    public function create(array $data): Produto
    {
        return $this->produtoRepository->create($data);
    }

    public function update(Produto $produto, array $data): Produto
    {
        return $this->produtoRepository->update($produto, $data);
    }

    public function delete(Produto $produto): void
    {
        $this->produtoRepository->delete($produto);
    }
}
