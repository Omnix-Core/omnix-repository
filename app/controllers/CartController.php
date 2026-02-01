<?php

require_once __DIR__ . '/../models/CartRepository.php';
require_once __DIR__ . '/../libs/Auth.php';

class CartController
{
    private $cartRepo;

    public function __construct()
    {
        $this->cartRepo = new CartRepository();
    }

    /**
     * Muestra el carrito del usuario
     */
    public function index()
    {
        // Verificar que el usuario esté autenticado
        if (!Auth::check()) {
            header('Location: /login');
            exit;
        }

        $userId = Auth::user()->id;
        $cartItems = $this->cartRepo->getCartByUserId($userId);
        $cartTotal = $this->cartRepo->getCartTotal($userId);
        $cartCount = $this->cartRepo->getCartCount($userId);

        // Cargar la vista
        extract([
            'cartItems' => $cartItems,
            'cartTotal' => $cartTotal,
            'cartCount' => $cartCount
        ]);
        
        require_once __DIR__ . '/../views/cart/index.php';
    }

    /**
     * Añade un producto al carrito (AJAX)
     */
    public function add()
    {
        header('Content-Type: application/json');

        if (!Auth::check()) {
            echo json_encode([
                'success' => false,
                'message' => 'Debes iniciar sesión para añadir productos al carrito'
            ]);
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode([
                'success' => false,
                'message' => 'Método no permitido'
            ]);
            exit;
        }

        $productId = $_POST['product_id'] ?? null;
        $quantity = $_POST['quantity'] ?? 1;

        if (!$productId || !is_numeric($productId) || $quantity < 1) {
            echo json_encode([
                'success' => false,
                'message' => 'Datos inválidos'
            ]);
            exit;
        }

        $userId = Auth::user()->id;
        $success = $this->cartRepo->addToCart($userId, $productId, $quantity);

        if ($success) {
            $cartCount = $this->cartRepo->getCartCount($userId);
            echo json_encode([
                'success' => true,
                'message' => 'Producto añadido al carrito',
                'cartCount' => $cartCount
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Error al añadir el producto'
            ]);
        }
        exit;
    }

    /**
     * Actualiza la cantidad de un item del carrito (AJAX)
     */
    public function update()
    {
        header('Content-Type: application/json');

        if (!Auth::check()) {
            echo json_encode([
                'success' => false,
                'message' => 'No autenticado'
            ]);
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode([
                'success' => false,
                'message' => 'Método no permitido'
            ]);
            exit;
        }

        $cartId = $_POST['cart_id'] ?? null;
        $quantity = $_POST['quantity'] ?? null;

        if (!$cartId || !is_numeric($quantity) || $quantity < 0) {
            echo json_encode([
                'success' => false,
                'message' => 'Datos inválidos'
            ]);
            exit;
        }

        $success = $this->cartRepo->updateQuantity($cartId, $quantity);

        if ($success) {
            $userId = Auth::user()->id;
            $cartTotal = $this->cartRepo->getCartTotal($userId);
            $cartCount = $this->cartRepo->getCartCount($userId);

            echo json_encode([
                'success' => true,
                'message' => 'Cantidad actualizada',
                'cartTotal' => number_format($cartTotal, 2),
                'cartCount' => $cartCount
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Error al actualizar'
            ]);
        }
        exit;
    }

    /**
     * Elimina un item del carrito (AJAX)
     */
    public function remove()
    {
        header('Content-Type: application/json');

        if (!Auth::check()) {
            echo json_encode([
                'success' => false,
                'message' => 'No autenticado'
            ]);
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode([
                'success' => false,
                'message' => 'Método no permitido'
            ]);
            exit;
        }

        $cartId = $_POST['cart_id'] ?? null;

        if (!$cartId) {
            echo json_encode([
                'success' => false,
                'message' => 'ID de carrito no proporcionado'
            ]);
            exit;
        }

        $success = $this->cartRepo->removeItem($cartId);

        if ($success) {
            $userId = Auth::user()->id;
            $cartTotal = $this->cartRepo->getCartTotal($userId);
            $cartCount = $this->cartRepo->getCartCount($userId);

            echo json_encode([
                'success' => true,
                'message' => 'Producto eliminado del carrito',
                'cartTotal' => number_format($cartTotal, 2),
                'cartCount' => $cartCount
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Error al eliminar el producto'
            ]);
        }
        exit;
    }

    /**
     * Vacía todo el carrito (AJAX)
     */
    public function clear()
    {
        header('Content-Type: application/json');

        if (!Auth::check()) {
            echo json_encode([
                'success' => false,
                'message' => 'No autenticado'
            ]);
            exit;
        }

        $userId = Auth::user()->id;
        $success = $this->cartRepo->clearCart($userId);

        if ($success) {
            echo json_encode([
                'success' => true,
                'message' => 'Carrito vaciado',
                'cartCount' => 0,
                'cartTotal' => '0.00'
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Error al vaciar el carrito'
            ]);
        }
        exit;
    }

    /**
     * Obtiene el número de items en el carrito (AJAX)
     */
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
