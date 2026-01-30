<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

$app = Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();

if (isset($_ENV['VERCEL'])) {
    $app->useStoragePath('/tmp/storage');
    
    // Ensure storage structure exists in /tmp
    if (!is_dir('/tmp/storage/framework/views')) {
        mkdir('/tmp/storage/framework/views', 0777, true);
    }
    if (!is_dir('/tmp/storage/framework/cache')) {
        mkdir('/tmp/storage/framework/cache', 0777, true);
    }
    if (!is_dir('/tmp/storage/framework/sessions')) {
        mkdir('/tmp/storage/framework/sessions', 0777, true);
    }
    if (!is_dir('/tmp/storage/logs')) {
        mkdir('/tmp/storage/logs', 0777, true);
    }

    // Force logs to stderr
    $_ENV['LOG_CHANNEL'] = 'stderr';
    $_SERVER['LOG_CHANNEL'] = 'stderr';
}

return $app;
