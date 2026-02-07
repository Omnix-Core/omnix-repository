<?php

require_once __DIR__ . '/../models/ProductRepository.php';

class HomeController
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
        
        require_once __DIR__ . '/../views/home/index.php';
    }
}