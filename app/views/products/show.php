<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="container mx-auto px-4 py-8">
    <div class="max-w-6xl mx-auto">
        <!-- Breadcrumb -->
        <div class="text-sm breadcrumbs mb-6">
            <ul>
                <li><a href="<?= Helpers::url('home/index') ?>">Inicio</a></li>
                <li><a href="<?= Helpers::url('product/index') ?>">Productos</a></li>
                <li><?= htmlspecialchars($producto->getNombre()) ?></li>
            </ul>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Imagen del producto -->
            <div>
                <div class="card bg-base-100 shadow-xl">
                    <figure class="px-8 pt-8">
                        <img src="<?= Helpers::url('assets/images/products/' . htmlspecialchars($producto->getImagen())) ?>" 
                             alt="<?= htmlspecialchars($producto->getNombre()) ?>"
                             class="rounded-xl w-full"
                             onerror="this.src='<?= Helpers::url('assets/images/products/default.svg') ?>'">
                    </figure>
                </div>
            </div>
            
            <!-- Información del producto -->
            <div>
                <div class="card bg-base-100 shadow-xl">
                    <div class="card-body">
                        <span class="badge badge-primary badge-lg mb-2"><?= htmlspecialchars($producto->getCategoriaNombre()) ?></span>
                        
                        <h1 class="text-4xl font-bold mb-4"><?= htmlspecialchars($producto->getNombre()) ?></h1>
                        
                        <div class="text-5xl font-bold text-primary mb-6">
                            €<?= number_format($producto->getPrecio(), 2) ?>
                        </div>
                        
                        <div class="divider"></div>
                        
                        <h3 class="text-xl font-bold mb-2">Descripción</h3>
                        <p class="text-gray-700 mb-6 leading-relaxed"><?= nl2br(htmlspecialchars($producto->getDescripcion())) ?></p>
                        
                        <div class="divider"></div>
                        
                        <div class="stats shadow mb-6">
                            <div class="stat">
                                <div class="stat-title">Disponibilidad</div>
                                <div class="stat-value text-lg">
                                    <span class="badge <?= $producto->hayStock() ? 'badge-success' : 'badge-error' ?> badge-lg">
                                        <?= $producto->getStockTexto() ?>
                                    </span>
                                </div>
                                <div class="stat-desc"><?= $producto->getStock() ?> unidades disponibles</div>
                            </div>
                        </div>
                        
                        <?php if ($producto->hayStock()): ?>
                            <?php if (Auth::check()): ?>
                                <div class="flex gap-4 mb-4">
                                    <div class="form-control w-32">
                                        <label class="label">
                                            <span class="label-text">Cantidad</span>
                                        </label>
                                        <input type="number" id="quantity-<?= $producto->getId() ?>" value="1" min="1" max="<?= $producto->getStock() ?>" 
                                               class="input input-bordered w-full">
                                    </div>
                                    <div class="form-control flex-1">
                                        <label class="label">
                                            <span class="label-text">&nbsp;</span>
                                        </label>
                                        <button onclick="addToCart(<?= $producto->getId() ?>)" class="btn btn-primary w-full">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                            </svg>
                                            Añadir al Carrito
                                        </button>
                                    </div>
                                </div>
                            <?php else: ?>
                                <a href="<?= Helpers::url('auth/login') ?>" class="btn btn-primary w-full mb-4">
                                    Iniciar Sesión para Comprar
                                </a>
                            <?php endif; ?>
                        <?php else: ?>
                            <button class="btn btn-disabled w-full mb-4">Producto Agotado</button>
                        <?php endif; ?>
                        
                        <div class="flex gap-2">
                            <a href="<?= Helpers::url('product/index') ?>" class="btn btn-outline flex-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                                </svg>
                                Volver a Productos
                            </a>
                            <a href="<?= Helpers::url('home/index') ?>" class="btn btn-ghost flex-1">Ir al Inicio</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Características adicionales -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-8">
            <div class="card bg-base-100 shadow-xl">
                <div class="card-body items-center text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-primary mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                    </svg>
                    <h3 class="card-title text-lg">Envío Gratis</h3>
                    <p class="text-sm">En todos los pedidos</p>
                </div>
            </div>

            <div class="card bg-base-100 shadow-xl">
                <div class="card-body items-center text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-primary mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                    <h3 class="card-title text-lg">Garantía</h3>
                    <p class="text-sm">2 años de garantía oficial</p>
                </div>
            </div>

            <div class="card bg-base-100 shadow-xl">
                <div class="card-body items-center text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-primary mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                    </svg>
                    <h3 class="card-title text-lg">Pago Seguro</h3>
                    <p class="text-sm">Transacciones 100% seguras</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
const BASE_URL = '<?= Helpers::url('') ?>';

function addToCart(productId) {
    const quantity = document.getElementById('quantity-' + productId).value;
    
    fetch(BASE_URL + 'cart/add', {
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
            
            // Mostrar notificación
            const notification = document.createElement('div');
            notification.className = 'toast toast-top toast-end';
            notification.innerHTML = `
                <div class="alert alert-success">
                    <span>${data.message}</span>
                </div>
            `;
            document.body.appendChild(notification);
            
            setTimeout(() => {
                notification.remove();
            }, 3000);
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