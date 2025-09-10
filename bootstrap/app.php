<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

// Arquivo de bootstrap do Laravel. Configura rotas, middlewares e exceções.
return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php', // Rotas web
        api: __DIR__.'/../routes/api.php', // Rotas API
        commands: __DIR__.'/../routes/console.php', // Comandos Artisan
        health: '/up', // Rota de health check
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Alias para o middleware de autenticação por token
        $middleware->alias([
            'token' => \App\Http\Middleware\AuthTokenMiddleware::class,
        ]);

        // Adiciona o middleware de autenticação nas rotas da API
        $middleware->api(append: [
            \App\Http\Middleware\AuthTokenMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // Configuração de tratamento de exceções
    })->create();
