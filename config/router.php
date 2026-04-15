<?php declare(strict_types=1);

use App\Infrastructure\Http\Controller\Empleo\EmpleoController;

/**
 * Simple front-controller router.
 * Maps [METHOD, path] → [controller, action].
 */
function route(string $uri, string $method, array $container): void {
    /** @var EmpleoController $empleoController */
    $empleoController = $container['empleoController'];

    $routes = [
        ['GET',  '/empleos',            [$empleoController, 'index']],
        ['GET',  '/empleos/crear',      [$empleoController, 'create']],
        ['POST', '/empleos/guardar',    [$empleoController, 'store']],
        ['GET',  '/empleos/editar',     [$empleoController, 'edit']],
        ['POST', '/empleos/actualizar', [$empleoController, 'update']],
        ['GET',  '/empleos/ver',        [$empleoController, 'show']],
        ['POST', '/empleos/eliminar',   [$empleoController, 'delete']],

        // Root → redirect
        ['GET',  '/',                   fn() => header('Location: /empleos')],
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
