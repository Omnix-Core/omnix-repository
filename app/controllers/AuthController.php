<?php

require_once __DIR__ . '/../models/UserRepository.php';
require_once __DIR__ . '/../libs/Auth.php';
require_once __DIR__ . '/../libs/Helpers.php';

class AuthController
{
    private $userRepo;

    public function __construct()
    {
        $this->userRepo = new UserRepository();
    }

    public function login()
    {
        if (Auth::check()) {
            Helpers::redirect('home/index');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';

            if (empty($email) || empty($password)) {
                $_SESSION['error'] = 'Por favor, completa todos los campos';
            } else {
                $user = $this->userRepo->findByEmail($email);

                if ($user && password_verify($password, $user->password)) {
                    $_SESSION['user_id'] = $user->id;
                    $_SESSION['success'] = '¡Bienvenido ' . $user->username . '!';
                    Helpers::redirect('home/index');
                } else {
                    $_SESSION['error'] = 'Credenciales incorrectas';
                }
            }
        }

        require_once __DIR__ . '/../views/auth/login.php';
    }

    public function register()
    {
        if (Auth::check()) {
            Helpers::redirect('home/index');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            $password_confirm = $_POST['password_confirm'] ?? '';

            if (empty($username) || empty($email) || empty($password)) {
                $_SESSION['error'] = 'Por favor, completa todos los campos';
            } elseif ($password !== $password_confirm) {
                $_SESSION['error'] = 'Las contraseñas no coinciden';
            } elseif (strlen($password) < 3) {
                $_SESSION['error'] = 'La contraseña debe tener al menos 3 caracteres';
            } else {
                $existing = $this->userRepo->findByEmail($email);
                if ($existing) {
                    $_SESSION['error'] = 'El email ya está registrado';
                } else {
                    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
                    $success = $this->userRepo->create($username, $email, $hashedPassword);

                    if ($success) {
                        $_SESSION['success'] = 'Registro exitoso. Ya puedes iniciar sesión';
                        Helpers::redirect('auth/login');
                    } else {
                        $_SESSION['error'] = 'Error al registrar usuario';
                    }
                }
            }
        }

        require_once __DIR__ . '/../views/auth/register.php';
    }

    public function logout()
    {
        session_destroy();
        Helpers::redirect('home/index');
    }
}