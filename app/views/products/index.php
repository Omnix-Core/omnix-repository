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
                        <h2 class="card-title"><?= htmlspecialchars($producto->getNombre()) ?></h2>
                        <p class="text-sm text-gray-600 line-clamp-2"><?= htmlspecialchars($producto->getDescripcion()) ?></p>
                        <div class="flex items-center justify-between mt-2">
                            <span class="text-2xl font-bold text-primary">€<?= number_format($producto->getPrecio(), 2) ?></span>
                            <span class="badge <?= $producto->hayStock() ? 'badge-success' : 'badge-error' ?>">
                                <?= $producto->getStockTexto() ?>
                            </span>
                        </div>
                        <div class="card-actions justify-end mt-2">
                            <a href="/products/<?= $producto->getId() ?>" class="btn btn-primary btn-sm w-full">Ver Detalles</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>