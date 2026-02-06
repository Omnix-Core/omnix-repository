<?php

require_once __DIR__ . '/../models/OrderRepository.php';
require_once __DIR__ . '/../models/CartRepository.php';
require_once __DIR__ . '/../libs/Auth.php';

class OrderController
{
    private $orderRepo;
    private $cartRepo;

    public function __construct()
    {
        $this->orderRepo = new OrderRepository();
        $this->cartRepo = new CartRepository();
    }

    public function checkout()
    {
        if (!Auth::check()) {
            header('Location: /login');
            exit;
        }

        $userId = Auth::user()->id;
        $cartItems = $this->cartRepo->getCartByUserId($userId);
        
        if (empty($cartItems)) {
            $_SESSION['error'] = 'El carrito está vacío';
            header('Location: /cart');
            exit;
        }
        
        $cartTotal = $this->cartRepo->getCartTotal($userId);

        extract([
            'cartItems' => $cartItems,
            'cartTotal' => $cartTotal
        ]);
        
        require_once __DIR__ . '/../views/orders/checkout.php';
    }

    public function process()
    {
        if (!Auth::check()) {
            header('Location: /login');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /cart');
            exit;
        }

        $userId = Auth::user()->id;
        $cartItems = $this->cartRepo->getCartByUserId($userId);
        
        if (empty($cartItems)) {
            $_SESSION['error'] = 'El carrito está vacío';
            header('Location: /cart');
            exit;
        }

        $shippingAddress = trim($_POST['shipping_address'] ?? '');
        $paymentMethod = $_POST['payment_method'] ?? '';

        if (empty($shippingAddress) || empty($paymentMethod)) {
            $_SESSION['error'] = 'Por favor, completa todos los campos';
            header('Location: /checkout');
            exit;
        }

        $orderId = $this->orderRepo->crearPedidoDesdeCarrito(
            $userId,
            $cartItems,
            $shippingAddress,
            $paymentMethod
        );

        if ($orderId) {
            $this->cartRepo->clearCart($userId);
            
            $_SESSION['success'] = 'Pedido realizado correctamente';
            header('Location: /orders/' . $orderId);
            exit;
        } else {
            $_SESSION['error'] = 'Error al procesar el pedido';
            header('Location: /checkout');
            exit;
        }
    }

    public function index()
    {
        if (!Auth::check()) {
            header('Location: /login');
            exit;
        }

        $userId = Auth::user()->id;
        $orders = $this->orderRepo->obtenerPedidosPorUsuario($userId);

        extract(['orders' => $orders]);
        require_once __DIR__ . '/../views/orders/index.php';
    }

    public function show($id)
    {
        if (!Auth::check()) {
            header('Location: /login');
            exit;
        }

        $order = $this->orderRepo->obtenerPedidoPorId($id);

        if (!$order) {
            $_SESSION['error'] = 'Pedido no encontrado';
            header('Location: /orders');
            exit;
        }

        if ($order->user_id != Auth::user()->id && !Auth::isAdmin()) {
            $_SESSION['error'] = 'No tienes permiso para ver este pedido';
            header('Location: /orders');
            exit;
        }

        extract(['order' => $order]);
        require_once __DIR__ . '/../views/orders/show.php';
    }

    public function updateStatus()
    {
        header('Content-Type: application/json');

        if (!Auth::isAdmin()) {
            echo json_encode(['success' => false, 'message' => 'No autorizado']);
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['success' => false, 'message' => 'Método no permitido']);
            exit;
        }

        $orderId = $_POST['order_id'] ?? null;
        $status = $_POST['status'] ?? null;

        if (!$orderId || !$status) {
            echo json_encode(['success' => false, 'message' => 'Datos inválidos']);
            exit;
        }

        $success = $this->orderRepo->actualizarEstadoPedido($orderId, $status);

        echo json_encode([
            'success' => $success,
            'message' => $success ? 'Estado actualizado' : 'Error al actualizar'
        ]);
        exit;
    }
}