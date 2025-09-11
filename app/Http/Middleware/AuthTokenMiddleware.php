<?php
/**
 * AuthTokenMiddleware
 *
 * Middleware de autenticação por Bearer Token com verificação de permissões
 * por rota. Os tokens e suas permissões estão definidas localmente para fins
 * de avaliação do teste técnico.
 */

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

/**
 * Middleware de autenticação por token.
 * Valida o Bearer Token e as permissões necessárias para cada rota.
 */
class AuthTokenMiddleware
{
    // Tokens e permissões disponíveis para cada usuário/teste
    private $tokens = [
        '4b5f8f32c96a9aa152e0c6615d4e632f' => ['001', '002', '003', '004', '005', '006'],
        '117ae721e424e7f819893edb2c0c5fd6' => ['002', '003', '004'],
        '3b7d6e2cb06ba79a9c9744f8e256a39e' => ['005', '006'],
    ];

    public function handle(Request $request, Closure $next, $permission = null)
    {
        $token = $request->bearerToken();

        // Verifica se o token é válido
        if (!$token || !isset($this->tokens[$token])) {
            return response()->json(['error' => 'Não autorizado'], 401);
        }

        // Se a rota exigir permissão, verifica se o token possui
        if ($permission && !in_array($permission, $this->tokens[$token])) {
            return response()->json(['error' => 'Proibido'], 403);
        }

        return $next($request);
    }
}
