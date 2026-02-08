<?php

class Router
{
    public function run()
    {
        // Obtener URL, por defecto 'home/index'
        $url = $_GET['url'] ?? 'home/index';
        
        // Limpiar la URL
        $url = trim($url, '/');
        
        // Si la URL está vacía, usar home/index
        if (empty($url)) {
            $url = 'home/index';
        }
        
        $url = explode('/', $url);

        // Extraer controlador, método y parámetros
        $controllerName = ucfirst($url[0]) . 'Controller';
        $method = $url[1] ?? 'index';
        $params = array_slice($url, 2);

        $controllerFile = __DIR__ . "/../controllers/$controllerName.php";

        // Verificar que el archivo del controlador existe
        if (!file_exists($controllerFile)) {
            $this->show404();
            return;
        }

        require_once $controllerFile;

        // Verificar que la clase existe
        if (!class_exists($controllerName)) {
            $this->show404();
            return;
        }

        $controller = new $controllerName();

        // Verificar que el método existe
        if (!method_exists($controller, $method)) {
            $this->show404();
            return;
        }

        // Llamar al método del controlador
        call_user_func_array([$controller, $method], $params);
    }
    
    private function show404()
    {
        http_response_code(404);
        require_once __DIR__ . '/../views/errors/404.php';
        exit;
    }
}