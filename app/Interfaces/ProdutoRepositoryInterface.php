<?php

namespace App\Interfaces;

use App\Models\Produto;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface ProdutoRepositoryInterface
{
    public function getAll(array $filters = [], int $perPage = 10): LengthAwarePaginator;
    public function getById(int $id): ?Produto;
    public function create(array $data): Produto;
    public function update(Produto $produto, array $data): Produto;
    public function delete(Produto $produto): void;
}
