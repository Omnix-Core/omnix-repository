<?php

    class CartController{
        
        public function index(){
            if (!isset($_SESSION['cart'])) {
                $_SESSION['cart'] = [];
            }

            $cart = $_SESSION['cart'];

            require_once __DIR__ . '/../views/cart/index.php';
        }

        public function add(){
            $id = $_POST['id'] ?? null;

            if ($id) {
                $_SESSION['cart'][$id] = ($_SESSION['cart'][$id] ?? 0) + 1;
            }

            header('Location: /cart');
            exit;
        }

        public function remove(){
            $id = $_POST['id'] ?? null;

            if ($id && isset($_SESSION['cart'][$id])) {
                unset($_SESSION['cart'][$id]);
            }

            header('Location: /cart');
            exit;
        }
    }
?>
