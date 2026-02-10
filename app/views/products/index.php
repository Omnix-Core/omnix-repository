<?php $title = 'Productos - Omnix Core'; ?>
<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-8">Catálogo de Productos</h1>

    <?php if (empty($productos)): ?>
        <div class="card bg-base-100 shadow-xl">
            <div class="card-body text-center py-12">
                <p class="text-gray-500">No hay productos disponibles</p>
                <a href="/" class="btn btn-primary mt-4">Volver al Inicio</a>
            </div>
        </div>
    <?php else: ?>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            <?php foreach ($productos as $producto): ?>
                <div class="card bg-base-100 shadow-xl hover:shadow-2xl transition-shadow">
                    <figure class="px-4 pt-4">
                        <img src="/assets/images/products/<?= htmlspecialchars($producto->getImagen()) ?>" 
                             alt="<?= htmlspecialchars($producto->getNombre()) ?>"
                             class="rounded-xl h-48 w-full object-cover"
                             onerror="this.src='/assets/images/products/default.jpg'">
                    </figure>
                    <div class="card-body">
                        <span class="badge badge-primary badge-sm"><?= htmlspecialchars($producto->getCategoriaNombre()) ?></span>
                        <h2 class="card-title text-base"><?= htmlspecialchars($producto->getNombre()) ?></h2>
                        <p class="text-sm text-gray-600 line-clamp-2"><?= htmlspecialchars($producto->getDescripcion()) ?></p>
                        <div class="flex items-center justify-between mt-2">
                            <span class="text-xl font-bold text-primary">€<?= number_format($producto->getPrecio(), 2) ?></span>
                            <span class="badge <?= $producto->hayStock() ? 'badge-success' : 'badge-error' ?> badge-sm">
                                <?= $producto->getStockTexto() ?>
                            </span>
                        </div>
                        
                        <div class="card-actions flex-col gap-2 mt-2">
                            <?php if ($producto->hayStock() && Auth::check()): ?>
                                <button onclick="quickAddToCart(<?= $producto->getId() ?>)" class="btn btn-primary btn-sm w-full">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                    Añadir al Carrito
                                </button>
                            <?php elseif (!Auth::check()): ?>
                                <a href="/auth/login" class="btn btn-primary btn-sm w-full">Iniciar Sesión</a>
                            <?php endif; ?>
                            <a href="/product/show/<?= $producto->getId() ?>" class="btn btn-secondary btn-sm w-full">Ver Detalles</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<script>
function quickAddToCart(productId) {
    fetch('/cart/add', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: `product_id=${productId}&quantity=1`
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const badge = document.getElementById('cart-count');
            if (badge) badge.textContent = data.count;
            
            // Notificación
            const toast = document.createElement('div');
            toast.className = 'toast toast-top toast-end';
            toast.innerHTML = `<div class="alert alert-success"><span>Producto añadido al carrito</span></div>`;
            document.body.appendChild(toast);
            setTimeout(() => toast.remove(), 3000);
        } else {
            alert(data.message || 'Error al añadir');
        }
    })
    .catch(error => console.error('Error:', error));
}
</script>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>