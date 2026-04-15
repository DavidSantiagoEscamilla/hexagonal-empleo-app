<?php declare(strict_types=1);

use App\Infrastructure\Http\Controller\Auth\AuthController;
use App\Infrastructure\Http\Controller\Empleo\EmpleoController;

function route(string $uri, string $method, array $container): void {
    $empleoController = $container['empleoController'];
    $authController   = $container['authController'];

    $routes = [
        ['GET',  '/login',              [$authController,  'showLogin']],
        ['POST', '/login',              [$authController,  'login']],
        ['GET',  '/logout',             [$authController,  'logout']],
        ['GET',  '/empleos',            [$empleoController, 'index']],
        ['GET',  '/empleos/crear',      [$empleoController, 'create']],
        ['POST', '/empleos/guardar',    [$empleoController, 'store']],
        ['GET',  '/empleos/editar',     [$empleoController, 'edit']],
        ['POST', '/empleos/actualizar', [$empleoController, 'update']],
        ['GET',  '/empleos/ver',        [$empleoController, 'show']],
        ['POST', '/empleos/eliminar',   [$empleoController, 'delete']],
        ['GET',  '/',                   fn() => header('Location: /login')],
    ];

    foreach ($routes as [$routeMethod, $routePath, $handler]) {
        if ($method === $routeMethod && $uri === $routePath) {
            call_user_func($handler);
            return;
        }
    }

    http_response_code(404);
    echo '<h1>404 — Página no encontrada</h1>';
}
