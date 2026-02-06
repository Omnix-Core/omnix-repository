<?php

require_once __DIR__ . '/../models/ProductRepository.php';
require_once __DIR__ . '/../models/CategoryRepository.php';
require_once __DIR__ . '/../models/OrderRepository.php';
require_once __DIR__ . '/../models/Product.php';
require_once __DIR__ . '/../libs/Auth.php';

class AdminController
{
    private $productRepo;
    private $categoryRepo;
    private $orderRepo;

    public function __construct()
    {
        Auth::requireAdmin();
        
        $this->productRepo = new ProductRepository();
        $this->categoryRepo = new CategoryRepository();
        $this->orderRepo = new OrderRepository();
    }

    public function index()
    {
        $stats = $this->orderRepo->obtenerEstadisticas();
        $recentOrders = $this->orderRepo->obtenerTodosPedidos(10, 0);
        
        extract([
            'stats' => $stats,
            'recentOrders' => $recentOrders
        ]);
        
        require_once __DIR__ . '/../views/admin/dashboard.php';
    }

    public function products()
    {
        $products = $this->productRepo->findAll();
        $categories = $this->categoryRepo->findAll();
        
        extract([
            'products' => $products,
            'categories' => $categories
        ]);
        
        require_once __DIR__ . '/../views/admin/products.php';
    }

    public function categories()
    {
        $categories = $this->categoryRepo->findAll();
        
        extract(['categories' => $categories]);
        
        require_once __DIR__ . '/../views/admin/categories.php';
    }

    public function orders()
    {
        $orders = $this->orderRepo->obtenerTodosPedidos(50, 0);
        
        extract(['orders' => $orders]);
        
        require_once __DIR__ . '/../views/admin/orders.php';
    }

    // CRUD PRODUCTOS
    public function createProduct()
    {
        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['success' => false, 'message' => 'Método no permitido']);
            exit;
        }

        $name = trim($_POST['name'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $price = $_POST['price'] ?? 0;
        $stock = $_POST['stock'] ?? 0;
        $category_id = $_POST['category_id'] ?? null;
        $image = trim($_POST['image'] ?? 'default.jpg');

        if (empty($name) || $price <= 0 || !$category_id) {
            echo json_encode(['success' => false, 'message' => 'Datos inválidos']);
            exit;
        }

        $producto = new Producto();
        $producto->name = $name;
        $producto->description = $description;
        $producto->price = $price;
        $producto->stock = $stock;
        $producto->image = $image;
        $producto->category_id = $category_id;

        $success = $this->productRepo->create($producto);

        echo json_encode([
            'success' => $success,
            'message' => $success ? 'Producto creado' : 'Error al crear producto'
        ]);
        exit;
    }

    public function updateProduct()
    {
        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['success' => false, 'message' => 'Método no permitido']);
            exit;
        }

        $id = $_POST['id'] ?? null;
        $name = trim($_POST['name'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $price = $_POST['price'] ?? 0;
        $stock = $_POST['stock'] ?? 0;
        $category_id = $_POST['category_id'] ?? null;
        $image = trim($_POST['image'] ?? '');

        if (!$id || empty($name) || $price <= 0 || !$category_id) {
            echo json_encode(['success' => false, 'message' => 'Datos inválidos']);
            exit;
        }

        $producto = new Producto();
        $producto->id = $id;
        $producto->name = $name;
        $producto->description = $description;
        $producto->price = $price;
        $producto->stock = $stock;
        $producto->image = $image ?: 'default.jpg';
        $producto->category_id = $category_id;

        $success = $this->productRepo->update($producto);

        echo json_encode([
            'success' => $success,
            'message' => $success ? 'Producto actualizado' : 'Error al actualizar'
        ]);
        exit;
    }

    public function deleteProduct()
    {
        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['success' => false, 'message' => 'Método no permitido']);
            exit;
        }

        $id = $_POST['id'] ?? null;

        if (!$id) {
            echo json_encode(['success' => false, 'message' => 'ID no proporcionado']);
            exit;
        }

        $success = $this->productRepo->delete($id);

        echo json_encode([
            'success' => $success,
            'message' => $success ? 'Producto eliminado' : 'Error al eliminar'
        ]);
        exit;
    }

    // CRUD CATEGORÍAS - Usando CategoryRepository que ahora tiene los métodos
    public function createCategory()
    {
        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['success' => false, 'message' => 'Método no permitido']);
            exit;
        }

        $name = trim($_POST['name'] ?? '');

        if (empty($name)) {
            echo json_encode(['success' => false, 'message' => 'Nombre requerido']);
            exit;
        }

        $success = $this->categoryRepo->create($name);

        echo json_encode([
            'success' => $success,
            'message' => $success ? 'Categoría creada' : 'Error al crear categoría'
        ]);
        exit;
    }

    public function updateCategory()
    {
        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['success' => false, 'message' => 'Método no permitido']);
            exit;
        }

        $id = $_POST['id'] ?? null;
        $name = trim($_POST['name'] ?? '');

        if (!$id || empty($name)) {
            echo json_encode(['success' => false, 'message' => 'Datos inválidos']);
            exit;
        }

        $success = $this->categoryRepo->update($id, $name);

        echo json_encode([
            'success' => $success,
            'message' => $success ? 'Categoría actualizada' : 'Error al actualizar'
        ]);
        exit;
    }

    public function deleteCategory()
    {
        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['success' => false, 'message' => 'Método no permitido']);
            exit;
        }

        $id = $_POST['id'] ?? null;

        if (!$id) {
            echo json_encode(['success' => false, 'message' => 'ID no proporcionado']);
            exit;
        }

        $success = $this->categoryRepo->delete($id);

        echo json_encode([
            'success' => $success,
            'message' => $success ? 'Categoría eliminada' : 'Error al eliminar'
        ]);
        exit;
    }
}