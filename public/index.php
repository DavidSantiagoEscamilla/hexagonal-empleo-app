<?php declare(strict_types=1);

// ─── Bootstrap ────────────────────────────────────────────────────────────────
define('ROOT_PATH', dirname(__DIR__));

require ROOT_PATH . '/vendor/autoload.php';

// Load .env-style config from environment or fallback file
if (file_exists(ROOT_PATH . '/.env')) {
    foreach (file(ROOT_PATH . '/.env', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
        if (str_starts_with(trim($line), '#') || !str_contains($line, '=')) continue;
        [$key, $value] = explode('=', $line, 2);
        $_ENV[trim($key)] = trim($value);
    }
}

// ─── Session ──────────────────────────────────────────────────────────────────
session_start();

// ─── Error handling (dev mode) ────────────────────────────────────────────────
ini_set('display_errors', '1');
error_reporting(E_ALL);

// ─── DI Container ─────────────────────────────────────────────────────────────
$container = require ROOT_PATH . '/config/container.php';

// ─── Router ───────────────────────────────────────────────────────────────────
require ROOT_PATH . '/config/router.php';

$uri    = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

// Normalise trailing slash
$uri = rtrim($uri, '/') ?: '/';

route($uri, $method, $container);
