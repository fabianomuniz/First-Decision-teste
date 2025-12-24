<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProdutoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function prepareForValidation()
    {
        if ($this->has('preco')) {
            $this->merge([
                'preco' => str_replace(',', '.', str_replace('.', '', $this->preco)),
            ]);
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $produtoId = $this->route('produto') ? $this->route('produto')->id : null;

        return [
            'nome' => 'required|string|max:255|unique:produtos,nome,' . $produtoId,
            'descricao' => 'nullable|string|max:5000',
            'preco' => 'required|numeric|decimal:0,2|min:0|max:99999999.99',
            'quantidade_estoque' => 'required|integer|min:0',
        ];
    }
}
