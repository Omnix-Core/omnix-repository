<?php

class Router{
    public function run(){
        $url = $_GET['url'] ?? 'home/index';
        $url = explode('/', trim($url, '/'));

        $controllerName = ucfirst($url[0]) . 'Controller';
        $method = $url[1] ?? 'index';

        $controllerFile = "../app/controllers/$controllerName.php";

        if (!file_exists($controllerFile)) {
            die("Controlador no encontrado");
        }

        require_once $controllerFile;

        $controller = new $controllerName();

        if (!method_exists($controller, $method)) {
            die("Método no encontrado");
        }

        $controller->$method();
    }
}
