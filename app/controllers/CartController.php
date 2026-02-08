<?php

require_once __DIR__ . '/../models/CartRepository.php';
require_once __DIR__ . '/../models/ProductRepository.php';
require_once __DIR__ . '/../libs/Auth.php';

class CartController
{
    private $cartRepo;
    private $productRepo;

    public function __construct()
    {
        $this->cartRepo = new CartRepository();
        $this->productRepo = new ProductRepository();
    }

    public function index()
    {
        if (!Auth::check()) {
            $_SESSION['error'] = 'Debes iniciar sesión para ver el carrito';
            header('Location: /auth/login');
            exit;
        }

        $userId = Auth::user()->id;
        $cartItems = $this->cartRepo->getCartByUserId($userId);
        $cartTotal = $this->cartRepo->getCartTotal($userId);
        $cartCount = $this->cartRepo->getCartCount($userId);

        $title = 'Mi Carrito - Omnix Core';
        
        extract([
            'cartItems' => $cartItems,
            'cartTotal' => $cartTotal,
            'cartCount' => $cartCount,
            'title' => $title
        ]);

        require_once __DIR__ . '/../views/cart/index.php';
    }

    public function add()
    {
        header('Content-Type: application/json');

        if (!Auth::check()) {
            echo json_encode(['success' => false, 'message' => 'Debes iniciar sesión']);
            exit;
        }

        $productId = $_POST['product_id'] ?? null;
        $quantity = intval($_POST['quantity'] ?? 1);

        if (!$productId || $quantity < 1) {
            echo json_encode(['success' => false, 'message' => 'Datos inválidos']);
            exit;
        }

        $userId = Auth::user()->id;
        $success = $this->cartRepo->addToCart($userId, $productId, $quantity);

        if ($success) {
            $count = $this->cartRepo->getCartCount($userId);
            echo json_encode(['success' => true, 'count' => $count, 'message' => 'Producto añadido']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error al añadir']);
        }
        exit;
    }

    public function update()
    {
        header('Content-Type: application/json');

        if (!Auth::check()) {
            echo json_encode(['success' => false, 'message' => 'No autorizado']);
            exit;
        }

        $cartId = intval($_POST['cart_id'] ?? 0);
        $quantity = intval($_POST['quantity'] ?? 0);

        if (!$cartId || $quantity < 0) {
            echo json_encode(['success' => false, 'message' => 'Datos inválidos']);
            exit;
        }

        $success = $this->cartRepo->updateQuantity($cartId, $quantity);

        if ($success) {
            $userId = Auth::user()->id;
            $total = $this->cartRepo->getCartTotal($userId);
            $count = $this->cartRepo->getCartCount($userId);

            echo json_encode([
                'success' => true,
                'cartTotal' => number_format($total, 2),
                'cartCount' => $count
            ]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error al actualizar']);
        }
        exit;
    }

    public function remove()
    {
        header('Content-Type: application/json');

        if (!Auth::check()) {
            echo json_encode(['success' => false, 'message' => 'No autorizado']);
            exit;
        }

        $cartId = intval($_POST['cart_id'] ?? 0);

        if (!$cartId) {
            echo json_encode(['success' => false, 'message' => 'ID no proporcionado']);
            exit;
        }

        $success = $this->cartRepo->removeItem($cartId);

        if ($success) {
            $userId = Auth::user()->id;
            $total = $this->cartRepo->getCartTotal($userId);
            $count = $this->cartRepo->getCartCount($userId);

            echo json_encode([
                'success' => true,
                'cartTotal' => number_format($total, 2),
                'cartCount' => $count
            ]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error al eliminar']);
        }
        exit;
    }

    public function clear()
    {
        header('Content-Type: application/json');

        if (!Auth::check()) {
            echo json_encode(['success' => false, 'message' => 'No autorizado']);
            exit;
        }

        $userId = Auth::user()->id;
        $success = $this->cartRepo->clearCart($userId);

        echo json_encode([
            'success' => $success,
            'message' => $success ? 'Carrito vaciado' : 'Error al vaciar'
        ]);
        exit;
    }

    public function count()
    {
        header('Content-Type: application/json');

        if (!Auth::check()) {
            echo json_encode(['count' => 0]);
            exit;
        }

        $userId = Auth::user()->id;
        $count = $this->cartRepo->getCartCount($userId);

        echo json_encode(['count' => $count]);
        exit;
    }
}