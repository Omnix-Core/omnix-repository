<?php

require_once __DIR__ . '/../models/OrderRepository.php';
require_once __DIR__ . '/../models/CartRepository.php';
require_once __DIR__ . '/../libs/Auth.php';
require_once __DIR__ . '/../libs/Helpers.php';

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
            Helpers::redirect('auth/login');
        }

        $userId = Auth::user()->id;
        $cartItems = $this->cartRepo->getCartByUserId($userId);
        
        if (empty($cartItems)) {
            $_SESSION['error'] = 'El carrito está vacío';
            Helpers::redirect('cart/index');
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
            Helpers::redirect('auth/login');
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            Helpers::redirect('cart/index');
        }

        $userId = Auth::user()->id;
        $cartItems = $this->cartRepo->getCartByUserId($userId);
        
        if (empty($cartItems)) {
            $_SESSION['error'] = 'El carrito está vacío';
            Helpers::redirect('cart/index');
        }

        $shippingAddress = trim($_POST['shipping_address'] ?? '');
        $paymentMethod = $_POST['payment_method'] ?? '';

        if (empty($shippingAddress) || empty($paymentMethod)) {
            $_SESSION['error'] = 'Por favor, completa todos los campos';
            Helpers::redirect('order/checkout');
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
            Helpers::redirect('order/show/' . $orderId);
        } else {
            $_SESSION['error'] = 'Error al procesar el pedido';
            Helpers::redirect('order/checkout');
        }
    }

    public function index()
    {
        if (!Auth::check()) {
            Helpers::redirect('auth/login');
        }

        $userId = Auth::user()->id;
        $orders = $this->orderRepo->obtenerPedidosPorUsuario($userId);

        extract(['orders' => $orders]);
        require_once __DIR__ . '/../views/orders/index.php';
    }

    public function show($id)
    {
        if (!Auth::check()) {
            Helpers::redirect('auth/login');
        }

        $order = $this->orderRepo->obtenerPedidoPorId($id);

        if (!$order) {
            $_SESSION['error'] = 'Pedido no encontrado';
            Helpers::redirect('order/index');
        }

        if ($order->user_id != Auth::user()->id && !Auth::isAdmin()) {
            $_SESSION['error'] = 'No tienes permiso para ver este pedido';
            Helpers::redirect('order/index');
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