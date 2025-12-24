<?php

namespace App\Providers;

use App\Interfaces\ProdutoRepositoryInterface;
use App\Repositories\ProdutoRepository;
use App\Interfaces\ProdutoServiceInterface;
use App\Services\ProdutoService;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(ProdutoRepositoryInterface::class, ProdutoRepository::class);
        $this->app->bind(ProdutoServiceInterface::class, ProdutoService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrapFive();
    }
}
