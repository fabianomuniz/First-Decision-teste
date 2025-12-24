<?php

use App\Http\Controllers\Api\ProdutoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

Route::post('/login', function (Request $request) {
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    $user = User::where('email', $request->email)->first();

    if (! $user || ! Hash::check($request->password, $user->password)) {
        throw ValidationException::withMessages([
            'email' => ['As credenciais fornecidas estão incorretas.'],
        ]);
    }

    return response()->json([
        'data' => [
            'token' => $user->createToken('api-token')->plainTextToken,
            'type' => 'Bearer',
            'user' => $user
        ],
        'message' => 'Login realizado com sucesso.',
        'errors' => null,
    ]);
});

Route::get('/user', function (Request $request) {
    return response()->json([
        'data' => $request->user(),
        'message' => 'Usuário recuperado com sucesso.',
        'errors' => null,
    ]);
})->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('produtos', ProdutoController::class)->names('api.produtos');
});
