<?php

require_once __DIR__ . '/../libs/Database.php';
require_once __DIR__ . '/Order.php';
require_once __DIR__ . '/OrderItem.php';

class OrderRepository
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getPDO();
    }

    /**
     * Crea un nuevo pedido a partir del carrito del usuario
     */
public function crearPedidoDesdeCarrito($userId, $itemsCarrito, $direccionEnvio, $metodoPago)
{
    try {
        $this->db->beginTransaction();
        
        // Calcular total
        $total = 0;
        foreach ($itemsCarrito as $item) {
            $total += ($item->quantity * $item->product_price);
        }
        
        // Insertar pedido
        $sql = "INSERT INTO orders (user_id, total, shipping_address, payment_method) 
                VALUES (:user_id, :total, :shipping_address, :payment_method)";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':user_id' => $userId,
            ':total' => $total,
            ':shipping_address' => $direccionEnvio,
            ':payment_method' => $metodoPago
        ]);
        
        $pedidoId = $this->db->lastInsertId();
        
        // Insertar items del pedido y restar stock
        $sqlItem = "INSERT INTO order_items (order_id, product_id, quantity, price) 
                    VALUES (:order_id, :product_id, :quantity, :price)";
        
        $sqlStock = "UPDATE products SET stock = stock - :quantity WHERE id = :product_id";
        
        $stmtItem = $this->db->prepare($sqlItem);
        $stmtStock = $this->db->prepare($sqlStock);
        
        foreach ($itemsCarrito as $item) {
            // Insertar item del pedido
            $stmtItem->execute([
                ':order_id' => $pedidoId,
                ':product_id' => $item->product_id,
                ':quantity' => $item->quantity,
                ':price' => $item->product_price
            ]);
            
            // Restar stock
            $stmtStock->execute([
                ':quantity' => $item->quantity,
                ':product_id' => $item->product_id
            ]);
        }
        
        $this->db->commit();
        
        return $pedidoId;
        
    } catch (Exception $e) {
        $this->db->rollBack();
        error_log("Error creando pedido: " . $e->getMessage());
        return false;
    }
}

    /**
     * Obtiene todos los pedidos de un usuario
     */
    public function obtenerPedidosPorUsuario($userId)
    {
        $sql = "SELECT * FROM orders 
                WHERE user_id = :user_id 
                ORDER BY created_at DESC";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':user_id' => $userId]);
        
        $pedidos = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $pedidos[] = new Order($row);
        }
        
        return $pedidos;
    }

    /**
     * Obtiene un pedido por su ID
     */
    public function obtenerPedidoPorId($pedidoId)
    {
        $sql = "SELECT o.*, u.email as user_email, u.username as user_username 
                FROM orders o
                LEFT JOIN users u ON o.user_id = u.id
                WHERE o.id = :id";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $pedidoId]);
        
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($row) {
            $pedido = new Order($row);
            $pedido->items = $this->obtenerItemsPedido($pedidoId);
            return $pedido;
        }
        
        return null;
    }

    /**
     * Obtiene los items/productos de un pedido
     */
    public function obtenerItemsPedido($pedidoId)
    {
        $sql = "SELECT oi.*, 
                       p.name as product_name, 
                       p.image as product_image,
                       p.description as product_description
                FROM order_items oi
                LEFT JOIN products p ON oi.product_id = p.id
                WHERE oi.order_id = :order_id";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':order_id' => $pedidoId]);
        
        $items = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $items[] = new OrderItem($row);
        }
        
        return $items;
    }

    /**
     * Actualiza el estado de un pedido
     */
    public function actualizarEstadoPedido($pedidoId, $estado)
    {
        $estadosValidos = ['pending', 'processing', 'shipped', 'delivered', 'cancelled'];
        
        if (!in_array($estado, $estadosValidos)) {
            return false;
        }
        
        $sql = "UPDATE orders SET status = :status WHERE id = :id";
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':status' => $estado,
            ':id' => $pedidoId
        ]);
    }

    /**
     * Obtiene todos los pedidos (para panel de administración)
     */
    public function obtenerTodosPedidos($limite = 100, $offset = 0)
    {
        $sql = "SELECT o.*, 
                       u.email as user_email, 
                       u.username as user_username 
                FROM orders o
                LEFT JOIN users u ON o.user_id = u.id
                ORDER BY o.created_at DESC 
                LIMIT :limit OFFSET :offset";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':limit', $limite, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        
        $pedidos = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $pedidos[] = new Order($row);
        }
        
        return $pedidos;
    }

    /**
     * Cuenta el total de pedidos en el sistema
     */
    public function contarPedidos()
    {
        $sql = "SELECT COUNT(*) as total FROM orders";
        $stmt = $this->db->query($sql);
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $resultado['total'] ?? 0;
    }

    /**
     * Obtiene estadísticas generales de los pedidos
     */
    public function obtenerEstadisticas()
    {
        $sql = "SELECT 
                    COUNT(*) as total_orders,
                    SUM(total) as total_revenue,
                    AVG(total) as average_order,
                    COUNT(CASE WHEN status = 'pending' THEN 1 END) as pending_orders,
                    COUNT(CASE WHEN status = 'processing' THEN 1 END) as processing_orders,
                    COUNT(CASE WHEN status = 'delivered' THEN 1 END) as delivered_orders
                FROM orders";
        
        $stmt = $this->db->query($sql);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}