<?php

namespace App\Repositories;

use App\Interfaces\ProdutoRepositoryInterface;
use App\Models\Produto;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;

class ProdutoRepository implements ProdutoRepositoryInterface
{
    public function getAll(array $filters = [], int $perPage = 10): LengthAwarePaginator
    {
        $query = Produto::query();

        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function (Builder $q) use ($search) {
                $q->where('nome', 'like', "%{$search}%")
                  ->orWhere('descricao', 'like', "%{$search}%");
            });
        }

        if (!empty($filters['min_price'])) {
            // Trata possível formato de string da entrada se não tiver sido limpo antes
            $minPrice = $filters['min_price'];
            if (is_string($minPrice)) {
                $minPrice = str_replace(['.', ','], ['', '.'], $minPrice);
            }
            $query->where('preco', '>=', $minPrice);
        }

        if (!empty($filters['max_price'])) {
             $maxPrice = $filters['max_price'];
             if (is_string($maxPrice)) {
                 $maxPrice = str_replace(['.', ','], ['', '.'], $maxPrice);
             }
            $query->where('preco', '<=', $maxPrice);
        }

        if (!empty($filters['min_stock'])) {
            $query->where('quantidade_estoque', '>=', $filters['min_stock']);
        }

        $sort = $filters['sort'] ?? 'created_at';
        $direction = $filters['direction'] ?? 'desc';
        $allowedSorts = ['nome', 'preco', 'quantidade_estoque', 'created_at'];

        if (in_array($sort, $allowedSorts)) {
            $query->orderBy($sort, strtolower($direction) === 'asc' ? 'asc' : 'desc');
        }

        return $query->paginate($perPage)->withQueryString();
    }

    public function getById(int $id): ?Produto
    {
        return Produto::find($id);
    }

    public function create(array $data): Produto
    {
        return Produto::create($data);
    }

    public function update(Produto $produto, array $data): Produto
    {
        $produto->update($data);
        return $produto;
    }

    public function delete(Produto $produto): void
    {
        $produto->delete();
    }
}
