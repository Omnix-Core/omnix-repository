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
        $productRepository = new ProductRepository();
        $productos = $productRepository->findAll();

        require __DIR__ . '/../views/layouts/header.php';
        require __DIR__ . '/../views/products/index.php';
        require __DIR__ . '/../views/layouts/footer.php';
    }

    public function show($id)
    {
        $product = $this->productRepo->findById($id);
        require __DIR__ . '/../views/products/show.php';
    }
}
