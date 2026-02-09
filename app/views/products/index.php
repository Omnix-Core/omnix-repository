<?php $title = 'Productos - Omnix Core'; ?>
<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-8">Catálogo de Productos</h1>

    <!-- Formulario de Búsqueda y Filtros -->
    <div class="card bg-base-100 shadow-xl mb-8">
        <div class="card-body">
            <form method="GET" action="<?= Helpers::url('product/index') ?>" id="filterForm">
                <!-- Barra de Búsqueda -->
                <div class="form-control mb-4">
                    <div class="input-group">
                        <input type="text" 
                               name="search" 
                               placeholder="Buscar productos..." 
                               class="input input-bordered w-full"
                               value="<?= htmlspecialchars($filters['search']) ?>">
                        <button type="submit" class="btn btn-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Filtros Avanzados -->
                <div class="collapse collapse-arrow bg-base-200">
                    <input type="checkbox" id="toggleFilters" <?= (!empty($filters['category']) || !empty($filters['min_price']) || !empty($filters['max_price']) || !empty($filters['in_stock'])) ? 'checked' : '' ?>> 
                    <div class="collapse-title text-lg font-medium">
                        Filtros Avanzados
                    </div>
                    <div class="collapse-content">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mt-4">
                            <!-- Filtro por Categoría -->
                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text">Categoría</span>
                                </label>
                                <select name="category" class="select select-bordered w-full">
                                    <option value="">Todas las categorías</option>
                                    <?php foreach ($categorias as $categoria): ?>
                                        <option value="<?= $categoria->getId() ?>" 
                                                <?= $filters['category'] == $categoria->getId() ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($categoria->getName()) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <!-- Filtro por Precio Mínimo -->
                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text">Precio Mínimo (€)</span>
                                </label>
                                <input type="number" 
                                       name="min_price" 
                                       placeholder="0" 
                                       step="0.01"
                                       min="0"
                                       class="input input-bordered w-full"
                                       value="<?= htmlspecialchars($filters['min_price'] ?? '') ?>">
                            </div>

                            <!-- Filtro por Precio Máximo -->
                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text">Precio Máximo (€)</span>
                                </label>
                                <input type="number" 
                                       name="max_price" 
                                       placeholder="1000" 
                                       step="0.01"
                                       min="0"
                                       class="input input-bordered w-full"
                                       value="<?= htmlspecialchars($filters['max_price'] ?? '') ?>">
                            </div>

                            <!-- Filtro por Stock -->
                            <div class="form-control">
                                <label class="label cursor-pointer">
                                    <span class="label-text">Solo en stock</span>
                                    <input type="checkbox" 
                                           name="in_stock" 
                                           value="1"
                                           class="checkbox checkbox-primary"
                                           <?= $filters['in_stock'] ? 'checked' : '' ?>>
                                </label>
                            </div>
                        </div>

                        <div class="flex gap-2 mt-4">
                            <button type="submit" class="btn btn-primary">Aplicar Filtros</button>
                            <a href="<?= Helpers::url('product/index') ?>" class="btn btn-ghost">Limpiar Filtros</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Ordenamiento y Resultados -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
        <div class="text-sm text-gray-600">
            Mostrando <strong><?= count($productos) ?></strong> productos
            <?php if (!empty($filters['search'])): ?>
                para "<strong><?= htmlspecialchars($filters['search']) ?></strong>"
            <?php endif; ?>
        </div>
        
        <form method="GET" action="<?= Helpers::url('product/index') ?>" class="form-control">
            <?php if (!empty($filters['search'])): ?>
                <input type="hidden" name="search" value="<?= htmlspecialchars($filters['search']) ?>">
            <?php endif; ?>
            <?php if (!empty($filters['category'])): ?>
                <input type="hidden" name="category" value="<?= htmlspecialchars($filters['category']) ?>">
            <?php endif; ?>
            <?php if (!empty($filters['min_price'])): ?>
                <input type="hidden" name="min_price" value="<?= htmlspecialchars($filters['min_price']) ?>">
            <?php endif; ?>
            <?php if (!empty($filters['max_price'])): ?>
                <input type="hidden" name="max_price" value="<?= htmlspecialchars($filters['max_price']) ?>">
            <?php endif; ?>
            <?php if (!empty($filters['in_stock'])): ?>
                <input type="hidden" name="in_stock" value="1">
            <?php endif; ?>
            
            <select name="sort" class="select select-bordered select-sm" onchange="this.form.submit()">
                <option value="newest" <?= $filters['sort'] == 'newest' ? 'selected' : '' ?>>Más recientes</option>
                <option value="price_asc" <?= $filters['sort'] == 'price_asc' ? 'selected' : '' ?>>Precio: menor a mayor</option>
                <option value="price_desc" <?= $filters['sort'] == 'price_desc' ? 'selected' : '' ?>>Precio: mayor a menor</option>
                <option value="name_asc" <?= $filters['sort'] == 'name_asc' ? 'selected' : '' ?>>Nombre: A-Z</option>
                <option value="name_desc" <?= $filters['sort'] == 'name_desc' ? 'selected' : '' ?>>Nombre: Z-A</option>
            </select>
        </form>
    </div>

    <!-- Grid de Productos -->
    <?php if (empty($productos)): ?>
        <div class="card bg-base-100 shadow-xl">
            <div class="card-body text-center py-12">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <p class="text-xl text-gray-600 mb-2">No se encontraron productos</p>
                <p class="text-gray-500 mb-4">Intenta ajustar los filtros de búsqueda</p>
                <a href="<?= Helpers::url('product/index') ?>" class="btn btn-primary">Ver Todos los Productos</a>
            </div>
        </div>
    <?php else: ?>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            <?php foreach ($productos as $producto): ?>
                <div class="card bg-base-100 shadow-xl hover:shadow-2xl transition-shadow">
                    <figure class="px-4 pt-4">
                        <img src="<?= Helpers::url('assets/images/products/' . htmlspecialchars($producto->getImagen())) ?>" 
                             alt="<?= htmlspecialchars($producto->getNombre()) ?>"
                             class="rounded-xl h-48 w-full object-cover"
                             onerror="this.src='<?= Helpers::url('assets/images/products/default.jpg') ?>'">
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
                        <div class="card-actions justify-end mt-2">
                            <a href="<?= Helpers::url('product/show/' . $producto->getId()) ?>" class="btn btn-primary btn-sm w-full">Ver Detalles</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>