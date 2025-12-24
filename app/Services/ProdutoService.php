<?php

namespace App\Services;

use App\Models\Produto;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;

class ProdutoService
{
    public function list(array $filters = [], int $perPage = 10): LengthAwarePaginator
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
            $query->where('preco', '>=', $filters['min_price']);
        }

        if (!empty($filters['max_price'])) {
            $query->where('preco', '<=', $filters['max_price']);
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
