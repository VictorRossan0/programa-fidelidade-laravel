<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AuthTokenMiddleware
{
    private $tokens = [
        '4b5f8f32c96a9aa152e0c6615d4e632f' => ['001', '002', '003', '004', '005', '006'],
        '117ae721e424e7f819893edb2c0c5fd6' => ['002', '003', '004'],
        '3b7d6e2cb06ba79a9c9744f8e256a39e' => ['005', '006'],
    ];

    public function handle(Request $request, Closure $next, $permission)
    {
        $token = $request->bearerToken();

        if (!$token || !isset($this->tokens[$token])) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        if (!in_array($permission, $this->tokens[$token])) {
            return response()->json(['error' => 'Forbidden'], 403);
        }

        return $next($request);
    }
}
