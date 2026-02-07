<?php $title = htmlspecialchars($producto->getNombre()) . ' - Omnix Core'; ?>
<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="container mx-auto px-4 py-8">
    <div class="max-w-6xl mx-auto">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <div>
                <img src="/assets/images/products/<?= htmlspecialchars($producto->getImagen()) ?>" 
                     alt="<?= htmlspecialchars($producto->getNombre()) ?>"
                     class="w-full rounded-lg shadow-xl"
                     onerror="this.src='/assets/images/products/default.jpg'">
            </div>
            
            <div>
                <span class="badge badge-primary"><?= htmlspecialchars($producto->getCategoriaNombre()) ?></span>
                <h1 class="text-4xl font-bold mt-2 mb-4"><?= htmlspecialchars($producto->getNombre()) ?></h1>
                
                <div class="text-4xl font-bold text-primary mb-4">
                    €<?= number_format($producto->getPrecio(), 2) ?>
                </div>
                
                <p class="text-gray-700 mb-6"><?= nl2br(htmlspecialchars($producto->getDescripcion())) ?></p>
                
                <div class="mb-6">
                    <span class="badge <?= $producto->hayStock() ? 'badge-success' : 'badge-error' ?> badge-lg">
                        <?= $producto->getStockTexto() ?>
                    </span>
                </div>
                
                <?php if ($producto->hayStock()): ?>
                    <?php if (Auth::check()): ?>
                        <div class="flex gap-4">
                            <input type="number" id="quantity" value="1" min="1" max="<?= $producto->getStock() ?>" 
                                   class="input input-bordered w-24">
                            <button onclick="addToCart(<?= $producto->getId() ?>)" class="btn btn-primary flex-1">
                                Añadir al Carrito
                            </button>
                        </div>
                    <?php else: ?>
                        <a href="/login" class="btn btn-primary w-full">Iniciar Sesión para Comprar</a>
                    <?php endif; ?>
                <?php else: ?>
                    <button class="btn btn-disabled w-full">Producto Agotado</button>
                <?php endif; ?>
                
                <div class="mt-8">
                    <a href="/products" class="btn btn-outline">Volver a Productos</a>
                </div>
            </div>
        </div>
    </div>
</div>

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
            const badge = document.getElementById('cart-count');
            if (badge) badge.textContent = data.count;
            alert('Producto añadido al carrito');
        } else {
            alert(data.message || 'Error al añadir al carrito');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error al añadir al carrito');
    });
}
</script>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>