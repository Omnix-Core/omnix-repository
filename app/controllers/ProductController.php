<?php

require_once __DIR__ . '/../models/ProductRepository.php';
require_once __DIR__ . '/../libs/Auth.php';

class ProductController
{
    private $productRepo;

    public function __construct()
    {
        $this->productRepo = new ProductRepository();
    }

    public function index()
    {
        $productos = $this->productRepo->findAll();
        $title = 'Productos - Omnix Core';
        
        extract(['productos' => $productos, 'title' => $title]);
        
        require_once __DIR__ . '/../views/products/index.php';
    }

    public function show($id)
    {
        if (!$id) {
            $_SESSION['error'] = 'ID de producto no válido';
            header('Location: /products');
            exit;
        }

        $producto = $this->productRepo->findById((int)$id);
        
        if (!$producto) {
            $_SESSION['error'] = 'Producto no encontrado';
            header('Location: /products');
            exit;
        }
        
        $title = htmlspecialchars($producto->getNombre()) . ' - Omnix Core';
        
        extract(['producto' => $producto, 'title' => $title]);
        
        require_once __DIR__ . '/../views/products/show.php';
    }
}