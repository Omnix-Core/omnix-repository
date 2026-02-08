<?php

class Cart
{
    public $id;
    public $user_id;
    public $product_id;
    public $quantity;
    public $added_at;
    
    public $product_name;
    public $product_price;
    public $product_image;
    public $product_description;
    
    public function __construct($data = [])
    {
        if (!empty($data)) {
            $this->id = $data['id'] ?? null;
            $this->user_id = $data['user_id'] ?? null;
            $this->product_id = $data['product_id'] ?? null;
            $this->quantity = $data['quantity'] ?? 1;
            $this->added_at = $data['added_at'] ?? null;
            
            $this->product_name = $data['product_name'] ?? $data['name'] ?? null;
            $this->product_price = $data['product_price'] ?? $data['price'] ?? null;
            $this->product_image = $data['product_image'] ?? $data['image'] ?? null;
            $this->product_description = $data['product_description'] ?? $data['description'] ?? null;
        }
    }
    
    public function getSubtotal()
    {
        return $this->quantity * $this->product_price;
    }
}