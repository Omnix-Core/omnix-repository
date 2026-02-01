<?php

class Auth
{
    /**
     * Verifica si hay un usuario autenticado
     */
    public static function check()
    {
        return isset($_SESSION['user']) && !empty($_SESSION['user']);
    }

    /**
     * Obtiene el usuario autenticado
     */
    public static function user()
    {
        return $_SESSION['user'] ?? null;
    }

    /**
     * Obtiene el ID del usuario autenticado
     */
    public static function id()
    {
        return self::user()->id ?? null;
    }

    /**
     * Verifica si el usuario es administrador
     */
    public static function isAdmin()
    {
        $user = self::user();
        return $user && isset($user->role) && $user->role === 'admin';
    }

    /**
     * Requiere autenticación - redirige si no está autenticado
     */
    public static function require()
    {
        if (!self::check()) {
            $_SESSION['intended_url'] = $_SERVER['REQUEST_URI'] ?? '/';
            header('Location: /login');
            exit;
        }
    }

    /**
     * Requiere rol de administrador
     */
    public static function requireAdmin()
    {
        self::require();
        
        if (!self::isAdmin()) {
            $_SESSION['error'] = 'No tienes permisos para acceder a esta sección';
            header('Location: /');
            exit;
        }
    }

    /**
     * Cierra la sesión
     */
    public static function logout()
    {
        unset($_SESSION['user']);
    }

    /**
     * Guarda el usuario en la sesión
     */
    public static function login($user)
    {
        $_SESSION['user'] = $user;
    }

    /**
     * Obtiene la URL a la que se intentó acceder antes de login
     */
    public static function intended()
    {
        $intended = $_SESSION['intended_url'] ?? '/';
        unset($_SESSION['intended_url']);
        return $intended;
    }
}