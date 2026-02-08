<?php

require_once __DIR__ . '/../libs/Database.php';
require_once __DIR__ . '/../models/ProductRepository.php';

class HomeController{
    public function index(){
        try {
            $db = Database::getInstance();
            $pdo = $db->getPDO();

            $productRepo = new ProductRepository();
            
            $productos = $productRepo->findAll();

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
