<?php declare(strict_types=1);
namespace App\Infrastructure\Http\Controller\Auth;

use App\Infrastructure\Http\Controller\BaseController;
use App\Infrastructure\Persistence\MySQL\DatabaseConnection;

final class AuthController extends BaseController {

    public function showLogin(): void {
        if (!empty($_SESSION['user_id'])) {
            $this->redirect('/empleos');
        }
        $this->render('auth/login', ['title' => 'Iniciar sesión']);
    }

    public function login(): void {
        $email    = trim($this->post('email'));
        $password = $this->post('password');

        $db   = DatabaseConnection::getInstance();
        $stmt = $db->prepare('SELECT id, nombre, password FROM users WHERE email = :email LIMIT 1');
        $stmt->execute([':email' => $email]);
        $user = $stmt->fetch();

        if (!$user || !password_verify($password, $user['password'])) {
            $_SESSION['flash'] = ['type' => 'error', 'message' => 'Correo o contraseña incorrectos.'];
            $this->redirect('/login');
        }

        session_regenerate_id(true);
        $_SESSION['user_id']   = $user['id'];
        $_SESSION['user_name'] = $user['nombre'];

        $this->redirect('/empleos');
    }

    public function logout(): void {
        session_destroy();
        $this->redirect('/login');
    }
}
