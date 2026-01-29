<?php

require_once __DIR__ . '/../core/Database.php';

class HomeController{
    public function index(){
        try {
            $db = Database::getInstance();
            $pdo = $db->getConnection();

            $datos = [
                'titulo' => 'Bienvenido a Omnix',
                'texto'  => 'Los mejores precios en tecnología.'
            ];

            require_once __DIR__ . '/../views/home/index.php';

        } catch (Throwable $e) {

            error_log('Error en HomeController: ' . $e->getMessage());

            require_once __DIR__ . '/../views/errors/500.php';
        }
    }
}
