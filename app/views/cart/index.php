<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-8">Mi Carrito de Compras</h1>

    <?php if (empty($cartItems)): ?>
        <div class="card bg-base-100 shadow-xl">
            <div class="card-body text-center py-12">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24 mx-auto text-gray-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                <h2 class="text-2xl font-bold mb-2">Tu carrito está vacío</h2>
                <p class="text-gray-600 mb-6">Añade algunos productos para empezar a comprar</p>
                <a href="<?= Helpers::url('product/index') ?>" class="btn btn-primary">Ver Productos</a>
            </div>
        </div>
    <?php else: ?>
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2">
                <div class="card bg-base-100 shadow-xl">
                    <div class="card-body">
                        <div class="flex justify-between items-center mb-4">
                            <h2 class="card-title">Productos (<?= $cartCount ?>)</h2>
                            <button onclick="clearCart()" class="btn btn-error btn-sm">Vaciar Carrito</button>
                        </div>
                        
                        <div class="divide-y">
                            <?php foreach ($cartItems as $item): ?>
                                <div class="py-4 flex gap-4" id="cart-item-<?= $item->id ?>">
                                    <img src="<?= Helpers::url('assets/images/products/' . htmlspecialchars($item->product_image)) ?>" 
                                         alt="<?= htmlspecialchars($item->product_name) ?>"
                                         class="w-24 h-24 object-cover rounded"
                                         onerror="this.src='<?= Helpers::url('assets/images/products/default.svg') ?>'">
                                    
                                    <div class="flex-1">
                                        <h3 class="font-bold text-lg">
                                            <a href="<?= Helpers::url('product/show/' . $item->product_id) ?>" class="hover:text-primary">
                                                <?= htmlspecialchars($item->product_name) ?>
                                            </a>
                                        </h3>
                                        <p class="text-sm text-gray-600 mt-1"><?= htmlspecialchars($item->product_description) ?></p>
                                        <p class="text-primary font-bold mt-2">€<?= number_format($item->product_price, 2) ?></p>
                                    </div>
                                    
                                    <div class="flex flex-col items-end justify-between">
                                        <button onclick="removeFromCart(<?= $item->id ?>)" class="btn btn-ghost btn-sm btn-circle">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                        
                                        <div class="flex items-center gap-2">
                                            <button onclick="updateQuantity(<?= $item->id ?>, <?= $item->quantity - 1 ?>)" class="btn btn-sm btn-circle">-</button>
                                            <input type="number" value="<?= $item->quantity ?>" min="1" 
                                                   class="input input-bordered input-sm w-16 text-center"
                                                   onchange="updateQuantity(<?= $item->id ?>, this.value)">
                                            <button onclick="updateQuantity(<?= $item->id ?>, <?= $item->quantity + 1 ?>)" class="btn btn-sm btn-circle">+</button>
                                        </div>
                                        
                                        <p class="font-bold text-lg">€<?= number_format($item->quantity * $item->product_price, 2) ?></p>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
            
            <div>
                <div class="card bg-base-100 shadow-xl sticky top-4">
                    <div class="card-body">
                        <h2 class="card-title">Resumen del Pedido</h2>
                        <div class="divider"></div>
                        
                        <div class="space-y-2">
                            <div class="flex justify-between">
                                <span>Subtotal</span>
                                <span id="cart-subtotal">€<?= number_format($cartTotal, 2) ?></span>
                            </div>
                            <div class="flex justify-between">
                                <span>Envío</span>
                                <span class="text-success">GRATIS</span>
                            </div>
                        </div>
                        
                        <div class="divider"></div>
                        
                        <div class="flex justify-between text-2xl font-bold">
                            <span>Total</span>
                            <span class="text-primary" id="cart-total">€<?= number_format($cartTotal, 2) ?></span>
                        </div>
                        
                        <a href="<?= Helpers::url('order/checkout') ?>" class="btn btn-primary w-full mt-4">Proceder al Pago</a>
                        
                        <div class="alert alert-info mt-4">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="stroke-current shrink-0 w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span>Envío gratis en todos los pedidos</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<script>
const BASE_URL = '<?= Helpers::url('') ?>';

function updateQuantity(cartId, newQuantity) {
    if (newQuantity < 1) {
        removeFromCart(cartId);
        return;
    }
    
    fetch(BASE_URL + 'cart/update', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: `cart_id=${cartId}&quantity=${newQuantity}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            document.getElementById('cart-subtotal').textContent = '€' + data.cartTotal;
            document.getElementById('cart-total').textContent = '€' + data.cartTotal;
            document.getElementById('cart-count').textContent = data.cartCount;
            location.reload();
        } else {
            alert(data.message || 'Error al actualizar');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error al actualizar la cantidad');
    });
}

function removeFromCart(cartId) {
    if (!confirm('¿Eliminar este producto del carrito?')) return;
    
    fetch(BASE_URL + 'cart/remove', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: `cart_id=${cartId}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const item = document.getElementById('cart-item-' + cartId);
            if (item) item.remove();
            
            document.getElementById('cart-subtotal').textContent = '€' + data.cartTotal;
            document.getElementById('cart-total').textContent = '€' + data.cartTotal;
            document.getElementById('cart-count').textContent = data.cartCount;
            
            if (data.cartCount == 0) {
                location.reload();
            }
        } else {
            alert(data.message || 'Error al eliminar');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error al eliminar el producto');
    });
}

function clearCart() {
    if (!confirm('¿Vaciar todo el carrito?')) return;
    
    fetch(BASE_URL + 'cart/clear', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'}
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert(data.message || 'Error al vaciar el carrito');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error al vaciar el carrito');
    });
}
</script>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>