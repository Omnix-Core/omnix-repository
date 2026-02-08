<?php

require_once __DIR__ . '/../libs/Database.php';
require_once __DIR__ . '/Cart.php';

class CartRepository
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getPDO();
    }

    public function getCartByUserId($userId)
    {
        $sql = "SELECT c.*, 
                       p.name as product_name, 
                       p.price as product_price, 
                       p.image as product_image,
                       p.description as product_description
                FROM cart c
                INNER JOIN products p ON c.product_id = p.id
                WHERE c.user_id = :user_id
                ORDER BY c.added_at DESC";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':user_id' => $userId]);
        
        $items = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $items[] = new Cart($row);
        }
        
        return $items;
    }

    public function addToCart($userId, $productId, $quantity = 1)
    {
        $existing = $this->getCartItem($userId, $productId);
        
        if ($existing) {
            return $this->updateQuantity($existing->id, $existing->quantity + $quantity);
        } else {
            $sql = "INSERT INTO cart (user_id, product_id, quantity) 
                    VALUES (:user_id, :product_id, :quantity)";
            
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([
                ':user_id' => $userId,
                ':product_id' => $productId,
                ':quantity' => $quantity
            ]);
        }
    }

    public function getCartItem($userId, $productId)
    {
        $sql = "SELECT * FROM cart 
                WHERE user_id = :user_id AND product_id = :product_id";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':user_id' => $userId,
            ':product_id' => $productId
        ]);
        
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $row ? new Cart($row) : null;
    }

    public function updateQuantity($cartId, $quantity)
    {
        if ($quantity <= 0) {
            return $this->removeItem($cartId);
        }
        
        $sql = "UPDATE cart SET quantity = :quantity WHERE id = :id";
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':quantity' => $quantity,
            ':id' => $cartId
        ]);
    }

    public function removeItem($cartId)
    {
        $sql = "DELETE FROM cart WHERE id = :id";
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':id' => $cartId]);
    }

    public function clearCart($userId)
    {
        $sql = "DELETE FROM cart WHERE user_id = :user_id";
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':user_id' => $userId]);
    }

    public function getCartCount($userId)
    {
        $sql = "SELECT SUM(quantity) as total FROM cart WHERE user_id = :user_id";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':user_id' => $userId]);
        
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $result['total'] ?? 0;
    }

    public function getCartTotal($userId)
    {
        $sql = "SELECT SUM(c.quantity * p.price) as total
                FROM cart c
                INNER JOIN products p ON c.product_id = p.id
                WHERE c.user_id = :user_id";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':user_id' => $userId]);
        
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $result['total'] ?? 0;
    }
}