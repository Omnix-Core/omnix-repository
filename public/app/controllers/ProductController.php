<?php

require_once __DIR__ . '/../models/ProductRepository.php';

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
        
        extract(['productos' => $productos]);
        
        require_once __DIR__ . '/../views/products/index.php';
    }

    public function show($id)
    {
        $producto = $this->productRepo->findById((int)$id);
        
        if (!$producto) {
            $_SESSION['error'] = 'Producto no encontrado';
            header('Location: /products');
            exit;
        }
        
        extract(['producto' => $producto]);
        
        require_once __DIR__ . '/../views/products/show.php';
    }
}