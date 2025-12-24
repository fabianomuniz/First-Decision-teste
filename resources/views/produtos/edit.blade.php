<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Editar Produto') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    
                    <form action="{{ route('produtos.update', $produto) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label for="nome" class="form-label text-gray-700 dark:text-gray-300">Nome</label>
                            <input type="text" name="nome" id="nome" value="{{ old('nome', $produto->nome) }}" class="form-control" required maxlength="255">
                            @error('nome')
                                <p class="text-danger small mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="descricao" class="form-label text-gray-700 dark:text-gray-300">Descrição</label>
                            <textarea name="descricao" id="descricao" class="form-control" maxlength="5000" rows="5" style="resize: none; overflow-y: auto;">{{ old('descricao', $produto->descricao) }}</textarea>
                            @error('descricao')
                                <p class="text-danger small mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="preco" class="form-label text-gray-700 dark:text-gray-300">Preço</label>
                                <div class="input-group">
                                    <span class="input-group-text">R$</span>
                                    <input type="text" name="preco" id="preco" value="{{ old('preco', number_format($produto->preco, 2, ',', '.')) }}" class="form-control money" placeholder="0,00" required>
                                </div>
                                @error('preco')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="quantidade_estoque" class="form-label text-gray-700 dark:text-gray-300">Quantidade em Estoque</label>
                                <input type="number" name="quantidade_estoque" id="quantidade_estoque" value="{{ old('quantidade_estoque', $produto->quantidade_estoque) }}" min="0" step="1" class="form-control" required>
                                @error('quantidade_estoque')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('produtos.index') }}" class="btn btn-secondary">Cancelar</a>
                            <button type="submit" class="btn btn-primary">Atualizar</button>
                        </div>
                    </form>

                    <script>
                        $(document).ready(function(){
                            $('.money').mask('000.000.000.000.000,00', {reverse: true});
                        });
                    </script>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
