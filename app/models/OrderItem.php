<?php

class OrderItem
{
    public $id;
    public $order_id;
    public $product_id;
    public $quantity;
    public $price;
    
    // Propiedades adicionales del producto
    public $product_name;
    public $product_image;
    public $product_description;
    
    public function __construct($data = [])
    {
        if (!empty($data)) {
            $this->id = $data['id'] ?? null;
            $this->order_id = $data['order_id'] ?? null;
            $this->product_id = $data['product_id'] ?? null;
            $this->quantity = $data['quantity'] ?? 1;
            $this->price = $data['price'] ?? 0;
            
            // Datos del producto si vienen del join
            $this->product_name = $data['product_name'] ?? $data['name'] ?? null;
            $this->product_image = $data['product_image'] ?? $data['image'] ?? null;
            $this->product_description = $data['product_description'] ?? $data['description'] ?? null;
        }
    }
    
    /**
     * Calcula el subtotal del item
     */
    public function getSubtotal()
    {
        return $this->quantity * $this->price;
    }
}