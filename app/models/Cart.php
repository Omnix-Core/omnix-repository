<?php

class Cart
{
    public $id;
    public $user_id;
    public $product_id;
    public $quantity;
    public $added_at;
    
    // Datos del JOIN con products
    public $product_name;
    public $product_price;
    public $product_image;
    public $product_description;

    public function __construct($data = [])
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }

    public function getSubtotal()
    {
        return $this->quantity * $this->product_price;
    }
}