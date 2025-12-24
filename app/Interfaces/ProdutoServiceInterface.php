<?php

namespace App\Interfaces;

use App\Models\Produto;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface ProdutoServiceInterface
{
    public function list(array $filters = [], int $perPage = 10): LengthAwarePaginator;
    public function create(array $data): Produto;
    public function update(Produto $produto, array $data): Produto;
    public function delete(Produto $produto): void;
}
