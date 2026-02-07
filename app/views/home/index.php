<?php $title = 'Inicio - Omnix Core'; ?>
<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="hero min-h-96 bg-base-200">
    <div class="hero-content text-center">
        <div class="max-w-md">
            <h1 class="text-5xl font-bold">Bienvenido a Omnix Core</h1>
            <p class="py-6">Tu tienda online de productos tecnológicos</p>
            <a href="/products" class="btn btn-primary">Ver Productos</a>
        </div>
    </div>
</div>

<div class="container mx-auto px-4 py-12">
    <h2 class="text-3xl font-bold text-center mb-8">Productos Destacados</h2>
    
    <?php if (empty($productos)): ?>
        <div class="text-center py-12">
            <p class="text-gray-500">No hay productos disponibles</p>
        </div>
    <?php else: ?>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <?php $count = 0; ?>
            <?php foreach ($productos as $producto): ?>
                <?php if ($count >= 8) break; ?>
                <div class="card bg-base-100 shadow-xl hover:shadow-2xl transition-shadow">
                    <figure class="px-4 pt-4">
                        <img src="/assets/images/products/<?= htmlspecialchars($producto->getImagen()) ?>" 
                             alt="<?= htmlspecialchars($producto->getNombre()) ?>"
                             class="rounded-xl h-48 w-full object-cover"
                             onerror="this.src='/assets/images/products/default.jpg'">
                    </figure>
                    <div class="card-body">
                        <span class="badge badge-primary badge-sm"><?= htmlspecialchars($producto->getCategoriaNombre()) ?></span>
                        <h3 class="card-title text-lg"><?= htmlspecialchars($producto->getNombre()) ?></h3>
                        <p class="text-sm text-gray-600 line-clamp-2"><?= htmlspecialchars($producto->getDescripcion()) ?></p>
                        <div class="text-2xl font-bold text-primary">€<?= number_format($producto->getPrecio(), 2) ?></div>
                        <div class="card-actions justify-end">
                            <a href="/products/<?= $producto->getId() ?>" class="btn btn-primary btn-sm">Ver Detalles</a>
                        </div>
                    </div>
                </div>
                <?php $count++; ?>
            <?php endforeach; ?>
        </div>
        
        <div class="text-center mt-8">
            <a href="/products" class="btn btn-outline">Ver Todos los Productos</a>
        </div>
    <?php endif; ?>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>