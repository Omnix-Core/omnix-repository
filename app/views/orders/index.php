<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-8">Mis Pedidos</h1>

    <?php if (empty($orders)): ?>
        <div class="card bg-base-100 shadow-xl">
            <div class="card-body text-center py-12">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24 mx-auto text-gray-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                </svg>
                <h2 class="text-2xl font-bold mb-2">Aún no tienes pedidos</h2>
                <p class="text-gray-600 mb-6">Empieza a comprar para ver tus pedidos aquí</p>
                <a href="<?= Helpers::url('product/index') ?>" class="btn btn-primary">Ver Productos</a>
            </div>
        </div>
    <?php else: ?>
        <div class="space-y-4">
            <?php foreach ($orders as $order): ?>
                <div class="card bg-base-100 shadow-xl">
                    <div class="card-body">
                        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                            <div>
                                <h2 class="card-title">Pedido #<?= $order->id ?></h2>
                                <p class="text-sm text-gray-600">
                                    <span class="font-semibold">Fecha:</span> <?= date('d/m/Y H:i', strtotime($order->created_at)) ?>
                                </p>
                                <p class="text-sm text-gray-600">
                                    <span class="font-semibold">Dirección de envío:</span> <?= htmlspecialchars($order->shipping_address) ?>
                                </p>
                                <p class="text-sm text-gray-600">
                                    <span class="font-semibold">Método de pago:</span> <?= htmlspecialchars($order->payment_method) ?>
                                </p>
                            </div>
                            
                            <div class="text-right">
                                <div class="badge badge-lg <?php
                                    switch($order->status) {
                                        case 'pending':
                                            echo 'badge-warning';
                                            break;
                                        case 'processing':
                                            echo 'badge-info';
                                            break;
                                        case 'shipped':
                                            echo 'badge-primary';
                                            break;
                                        case 'delivered':
                                            echo 'badge-success';
                                            break;
                                        case 'cancelled':
                                            echo 'badge-error';
                                            break;
                                        default:
                                            echo 'badge-ghost';
                                    }
                                ?> mb-2">
                                    <?php
                                        $statusText = [
                                            'pending' => 'Pendiente',
                                            'processing' => 'Procesando',
                                            'shipped' => 'Enviado',
                                            'delivered' => 'Entregado',
                                            'cancelled' => 'Cancelado'
                                        ];
                                        echo $statusText[$order->status] ?? $order->status;
                                    ?>
                                </div>
                                <p class="text-2xl font-bold text-primary">€<?= number_format($order->total, 2) ?></p>
                            </div>
                        </div>
                        
                        <div class="divider"></div>
                        
                        <div class="text-sm">
                            <p class="font-semibold mb-2">Productos:</p>
                            <div class="space-y-2">
                                <?php foreach ($order->items as $item): ?>
                                    <div class="flex justify-between items-center">
                                        <span>
                                            <?= htmlspecialchars($item->product_name) ?> 
                                            <span class="text-gray-500">(x<?= $item->quantity ?>)</span>
                                        </span>
                                        <span class="font-semibold">€<?= number_format($item->getSubtotal(), 2) ?></span>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        
                        <div class="card-actions justify-end mt-4">
                            <a href="<?= Helpers::url('order/show/' . $order->id) ?>" class="btn btn-primary btn-sm">Ver Detalles</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>