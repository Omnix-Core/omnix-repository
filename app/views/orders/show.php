<?php $title = 'Pedido Confirmado - Omnix Core'; ?>
<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto text-center">
        <!-- Mensaje de éxito -->
        <div class="mb-8">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-32 w-32 mx-auto text-success mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <h1 class="text-5xl font-bold mb-4">¡Muchas gracias por tu compra!</h1>
            <p class="text-2xl text-gray-600">Vuelve pronto 😊</p>
        </div>

        <!-- Detalles del pedido -->
        <div class="card bg-base-100 shadow-xl">
            <div class="card-body">
                <h2 class="text-2xl font-bold mb-4">Pedido #<?= $order->id ?></h2>
                
                <div class="divider"></div>

                <div class="text-left space-y-4">
                    <div>
                        <p class="font-bold">Estado:</p>
                        <span class="badge badge-success badge-lg"><?= $order->getStatusLabel() ?></span>
                    </div>

                    <div>
                        <p class="font-bold">Fecha:</p>
                        <p><?= date('d/m/Y H:i', strtotime($order->created_at)) ?></p>
                    </div>

                    <div>
                        <p class="font-bold">Dirección de envío:</p>
                        <p><?= nl2br(htmlspecialchars($order->shipping_address)) ?></p>
                    </div>

                    <div>
                        <p class="font-bold">Método de pago:</p>
                        <p class="capitalize"><?= htmlspecialchars($order->payment_method) ?></p>
                    </div>
                </div>

                <div class="divider"></div>

                <div class="text-left">
                    <p class="font-bold mb-2">Productos:</p>
                    <?php foreach ($order->items as $item): ?>
                        <div class="flex justify-between py-2 border-b">
                            <span><?= htmlspecialchars($item->product_name) ?> (x<?= $item->quantity ?>)</span>
                            <span class="font-bold">€<?= number_format($item->getSubtotal(), 2) ?></span>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="divider"></div>

                <div class="text-3xl font-bold text-primary">
                    Total: €<?= number_format($order->total, 2) ?>
                </div>

                <div class="card-actions justify-center mt-6 gap-4">
                    <a href="/order/index" class="btn btn-outline">Ver Mis Pedidos</a>
                    <a href="/product/index" class="btn btn-primary">Seguir Comprando</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>