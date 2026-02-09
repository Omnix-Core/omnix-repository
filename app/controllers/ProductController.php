<?php

require_once __DIR__ . '/../models/ProductRepository.php';
require_once __DIR__ . '/../models/CategoryRepository.php';
require_once __DIR__ . '/../libs/Auth.php';

class ProductController
{
    private $productRepo;
    private $categoryRepo;

    public function __construct()
    {
        $this->productRepo = new ProductRepository();
        $this->categoryRepo = new CategoryRepository();
    }

    public function index()
    {
        // Obtener parámetros de búsqueda y filtros con validación estricta
        $search = isset($_GET['search']) && $_GET['search'] !== '' ? trim($_GET['search']) : '';
        $categoryId = isset($_GET['category']) && $_GET['category'] !== '' ? (int)$_GET['category'] : 0;
        
        // Validar precios
        $minPrice = null;
        if (isset($_GET['min_price']) && $_GET['min_price'] !== '') {
            $minPrice = (float)$_GET['min_price'];
            if ($minPrice < 0) $minPrice = null;
        }
        
        $maxPrice = null;
        if (isset($_GET['max_price']) && $_GET['max_price'] !== '') {
            $maxPrice = (float)$_GET['max_price'];
            if ($maxPrice < 0) $maxPrice = null;
        }
        
        $inStock = isset($_GET['in_stock']) && $_GET['in_stock'] == '1' ? true : false;
        $sortBy = isset($_GET['sort']) && $_GET['sort'] !== '' ? $_GET['sort'] : 'newest';

        // Aplicar filtros
        $productos = $this->productRepo->findWithFilters([
            'search' => $search,
            'category_id' => $categoryId,
            'min_price' => $minPrice,
            'max_price' => $maxPrice,
            'in_stock' => $inStock,
            'sort_by' => $sortBy
        ]);

        // Obtener todas las categorías para el filtro
        $categorias = $this->categoryRepo->findAll();
        
        $title = 'Productos - Omnix Core';
        
        // Pasar variables a la vista
        $filters = [
            'search' => $search,
            'category' => $categoryId,
            'min_price' => $minPrice,
            'max_price' => $maxPrice,
            'in_stock' => $inStock,
            'sort' => $sortBy
        ];
        
        extract([
            'productos' => $productos, 
            'categorias' => $categorias,
            'filters' => $filters,
            'title' => $title
        ]);
        
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