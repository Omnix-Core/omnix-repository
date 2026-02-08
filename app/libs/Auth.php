<?php

require_once __DIR__ . '/../models/UserRepository.php';

class Auth
{
    private static $user = null;

    public static function check()
    {
        return isset($_SESSION['user_id']);
    }

    public static function user()
    {
        if (self::$user === null && self::check()) {
            $userRepo = new UserRepository();
            self::$user = $userRepo->findById($_SESSION['user_id']);
        }
        return self::$user;
    }

    public static function isAdmin()
    {
        return self::check() && self::user() && self::user()->isAdmin();
    }

    public static function requireAuth()
    {
        if (!self::check()) {
            $_SESSION['error'] = 'Debes iniciar sesión';
            header('Location: /login');
            exit;
        }
    }

    public static function requireAdmin()
    {
        self::requireAuth();
        
        if (!self::isAdmin()) {
            $_SESSION['error'] = 'No tienes permisos de administrador';
            header('Location: /');
            exit;
        }
    }
}