<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="container mx-auto px-4 py-8">
    <div class="max-w-7xl mx-auto">
        <h1 class="text-3xl font-bold mb-8">Panel de Administración</h1>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8 place-content-center">
            <div class="stats shadow">
                <div class="stat">
                    <div class="stat-figure text-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="inline-block w-8 h-8 stroke-current">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                        </svg>
                    </div>
                    <div class="stat-title">Total Pedidos</div>
                    <div class="stat-value text-primary"><?= $stats['total_orders'] ?? 0 ?></div>
                    <div class="stat-desc">Todos los tiempos</div>
                </div>
            </div>

            <div class="stats shadow">
                <div class="stat">
                    <div class="stat-figure text-success">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="inline-block w-8 h-8 stroke-current">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="stat-title">Ingresos Totales</div>
                    <div class="stat-value text-success">€<?= number_format($stats['total_revenue'] ?? 0, 2) ?></div>
                    <div class="stat-desc">Ventas acumuladas</div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <a href="/admin/products" class="card bg-base-100 shadow-xl hover:shadow-2xl transition-shadow">
                <div class="card-body items-center text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-primary mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                    <h2 class="card-title">Gestionar Productos</h2>
                    <p class="text-base-content/70">CRUD de productos</p>
                </div>
            </a>

            <a href="/admin/categories" class="card bg-base-100 shadow-xl hover:shadow-2xl transition-shadow">
                <div class="card-body items-center text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-secondary mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                    </svg>
                    <h2 class="card-title">Gestionar Categorías</h2>
                    <p class="text-base-content/70">CRUD de categorías</p>
                </div>
            </a>
        </div>

        <div class="card bg-base-100 shadow-xl">
            <div class="card-body">
                <h2 class="card-title mb-4">Pedidos Recientes</h2>
                
                <?php if (empty($recentOrders)): ?>
                    <p class="text-base-content/60">No hay pedidos recientes</p>
                <?php else: ?>
                    <div class="overflow-x-auto">
                        <table class="table w-full">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Usuario</th>
                                    <th>Fecha</th>
                                    <th>Total</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($recentOrders as $order): ?>
                                    <tr>
                                        <td>#<?= str_pad($order->id, 6, '0', STR_PAD_LEFT) ?></td>
                                        <td><?= htmlspecialchars($order->user_username ?? $order->user_email) ?></td>
                                        <td><?= date('d/m/Y', strtotime($order->created_at)) ?></td>
                                        <td class="font-bold">€<?= number_format($order->total, 2) ?></td>
                                        <td>
                                            <span class="badge <?= $order->getStatusClass() ?>">
                                                <?= $order->getStatusLabel() ?>
                                            </span>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>