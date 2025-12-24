<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Detalhes do Produto') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 font-bold">Nome:</label>
                        <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $produto->nome }}</p>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 font-bold">Descrição:</label>
                        <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $produto->descricao }}</p>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 font-bold">Preço:</label>
                        <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">R$ {{ number_format($produto->preco, 2, ',', '.') }}</p>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 font-bold">Quantidade em Estoque:</label>
                        <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $produto->quantidade_estoque }}</p>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('produtos.index') }}" class="btn btn-secondary">Voltar</a>
                        <a href="{{ route('produtos.edit', $produto) }}" class="btn btn-warning text-white">Editar</a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
