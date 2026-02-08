<?php

class Helpers
{
    /**
     * Genera una URL correcta basada en la configuración del proyecto
     */
    public static function url($path = '')
    {
        // Eliminar barras al inicio y final
        $path = trim($path, '/');
        
        // Obtener el directorio base desde donde se ejecuta la aplicación
        $scriptName = $_SERVER['SCRIPT_NAME']; // e.g., /public/index.php
        $baseDir = dirname($scriptName); // e.g., /public
        
        // Si el directorio base es la raíz, no añadir nada
        if ($baseDir === '/' || $baseDir === '\\') {
            $baseDir = '';
        }
        
        // Construir la URL completa
        if (empty($path)) {
            return $baseDir . '/';
        }
        
        return $baseDir . '/' . $path;
    }
    
    /**
     * Redirecciona a una URL
     */
    public static function redirect($path = '')
    {
        header('Location: ' . self::url($path));
        exit;
    }
}
