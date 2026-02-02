<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="container mx-auto px-4 py-8">
    <div class="max-w-6xl mx-auto">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="bg-base-100 rounded-lg shadow-lg p-6">
                <img 
                    src="/assets/images/products/<?= htmlspecialchars($product->image) ?>" 
                    alt="<?= htmlspecialchars($product->name) ?>"
                    class="w-full h-auto rounded-lg object-cover"
                    onerror="this.src='/assets/images/products/default.jpg'"
                />
            </div>

            <div class="space-y-6">
                <div>
                    <h1 class="text-4xl font-bold mb-2"><?= htmlspecialchars($product->name) ?></h1>
                    <div class="badge badge-primary"><?= htmlspecialchars($product->category_name ?? 'Sin categoría') ?></div>
                </div>

                <div class="text-4xl font-bold text-primary">
                    €<?= number_format($product->price, 2) ?>
                </div>

                <div class="prose max-w-none">
                    <p class="text-base-content/80">
                        <?= nl2br(htmlspecialchars($product->description)) ?>
                    </p>
                </div>

                <div class="divider"></div>

                <div class="space-y-4">
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Cantidad</span>
                        </label>
                        <input 
                            type="number" 
                            id="quantity" 
                            min="1" 
                            value="1" 
                            class="input input-bordered w-32"
                        />
                    </div>

                    <?php if (Auth::check()): ?>
                        <button 
                            onclick="addToCart(<?= $product->id ?>)" 
                            class="btn btn-primary btn-lg w-full md:w-auto"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            Añadir al carrito
                        </button>
                    <?php else: ?>
                        <a href="/login" class="btn btn-primary btn-lg w-full md:w-auto">
                            Inicia sesión para comprar
                        </a>
                    <?php endif; ?>

                    <a href="/products" class="btn btn-outline w-full md:w-auto">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Volver al catálogo
                    </a>
                </div>

                <div class="bg-base-200 rounded-lg p-4">
                    <h3 class="font-bold mb-2">Características:</h3>
                    <ul class="space-y-1 text-sm">
                        <li>✓ Envío gratis en pedidos superiores a 50€</li>
                        <li>✓ Garantía de 2 años</li>
                        <li>✓ Devolución gratuita en 30 días</li>
                        <li>✓ Pago seguro</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="/assets/js/cart.js"></script>

<script>
function addToCart(productId) {
    const quantity = document.getElementById('quantity').value;
    
    fetch('/cart/add', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `product_id=${productId}&quantity=${quantity}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Producto añadido al carrito');
            const cartBadge = document.getElementById('cart-count');
            if (cartBadge) {
                cartBadge.textContent = data.cartCount;
            }
        } else {
            alert(data.message || 'Error al añadir el producto');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error al añadir el producto al carrito');
    });
}
</script>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>