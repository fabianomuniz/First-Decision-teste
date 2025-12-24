<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\ApiResponse;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    use ApiResponse;

    /**
     * Cria uma nova instância de AuthController.
     *
     * @return void
     */
    public function __construct()
    {
        // No Laravel 11/12, o middleware é frequentemente definido nas rotas ou bootstrap,
        // mas o middleware de controller ainda funciona.
        // Definiremos as rotas com middleware posteriormente, mas manter aqui também é aceitável
        // se usarmos a definição de middleware baseada em classe, mas a string 'auth:api' pode precisar
        // garantir que o alias exista.
    }

    /**
     * Obtém um JWT através das credenciais fornecidas.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $credentials = request(['email', 'password']);

        if (! $token = auth('api')->attempt($credentials)) {
            return $this->error(null, 'Unauthorized', 401);
        }

        return $this->respondWithToken($token);
    }

    /**
     * Obtém o usuário autenticado.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return $this->success(auth('api')->user());
    }

    /**
     * Faz logout do usuário (Invalida o token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth('api')->logout();

        return $this->success(null, 'Successfully logged out');
    }

    /**
     * Atualiza um token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth('api')->refresh());
    }

    /**
     * Obtém a estrutura do array de token.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return $this->success([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ]);
    }
}
