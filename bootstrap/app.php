<?php
  
  use App\Http\Middleware\JwtMiddleware;
  use App\Http\Middleware\LogMiddleware;
  use App\Http\Middleware\RoleMiddleware;
  use Illuminate\Console\Scheduling\Schedule;
  use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
  
  return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // register middlewares
        $middleware->alias([
          'jwt' => JwtMiddleware::class,
          'role' => RoleMiddleware::class,
          'log' => LogMiddleware::class,
        ]);
    })
    ->withSchedule(function (Schedule $schedule) {
        // register scheduled tasks
        $schedule->command('inventory:check-low-stock')->at("00:00")->timezone('Asia/Baghdad')->daily();
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
