<?php

class Order
{
    public $id;
    public $user_id;
    public $total;
    public $status;
    public $shipping_address;
    public $payment_method;
    public $created_at;
    public $updated_at;
    
    public $items = [];
    public $user_email;
    public $user_username;
    
    public function __construct($data = [])
    {
        if (!empty($data)) {
            $this->id = $data['id'] ?? null;
            $this->user_id = $data['user_id'] ?? null;
            $this->total = $data['total'] ?? 0;
            $this->status = $data['status'] ?? 'pending';
            $this->shipping_address = $data['shipping_address'] ?? '';
            $this->payment_method = $data['payment_method'] ?? '';
            $this->created_at = $data['created_at'] ?? null;
            $this->updated_at = $data['updated_at'] ?? null;
            
            $this->user_email = $data['user_email'] ?? $data['email'] ?? null;
            $this->user_username = $data['user_username'] ?? $data['username'] ?? null;
        }
    }
    
    /**
     * Estado formateado en español
     */
    public function getStatusLabel()
    {
        $labels = [
            'pending' => 'Pendiente',
            'processing' => 'En proceso',
            'shipped' => 'Enviado',
            'delivered' => 'Entregado',
            'cancelled' => 'Cancelado'
        ];
        
        return $labels[$this->status] ?? $this->status;
    }
    
    /**
     * Estados para el CSS 
     */
    public function getStatusClass()
    {
        $classes = [
            'pending' => 'badge-warning',
            'processing' => 'badge-info',
            'shipped' => 'badge-primary',
            'delivered' => 'badge-success',
            'cancelled' => 'badge-error'
        ];
        
        return $classes[$this->status] ?? 'badge-neutral';
    }
}