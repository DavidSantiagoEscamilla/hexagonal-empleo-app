<?php declare(strict_types=1);
namespace App\Infrastructure\Http\Controller;

abstract class BaseController {
    protected function render(string $template, array $data = []): void {
        extract($data, EXTR_SKIP);
        $templatePath = __DIR__ . '/../../View/templates/' . $template . '.php';
        if (!file_exists($templatePath)) {
            http_response_code(500);
            die("Template '{$template}' no encontrado.");
        }
        require $templatePath;
    }

    protected function redirect(string $url): void {
        header('Location: ' . $url);
        exit;
    }

    protected function json(mixed $data, int $code = 200): void {
        http_response_code($code);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        exit;
    }

    protected function isPost(): bool {
        return $_SERVER['REQUEST_METHOD'] === 'POST';
    }

    protected function isGet(): bool {
        return $_SERVER['REQUEST_METHOD'] === 'GET';
    }

    protected function post(string $key, mixed $default = ''): mixed {
        return $_POST[$key] ?? $default;
    }

    protected function get(string $key, mixed $default = ''): mixed {
        return $_GET[$key] ?? $default;
    }

    protected function flashSuccess(string $message): void {
        $_SESSION['flash'] = ['type' => 'success', 'message' => $message];
    }

    protected function flashError(string $message): void {
        $_SESSION['flash'] = ['type' => 'error', 'message' => $message];
    }

    protected function requireAuth(): void {
        if (empty($_SESSION['user_id'])) {
            $this->redirect('/login');
        }
    }
}
