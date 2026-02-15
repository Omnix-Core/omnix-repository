<?php $title = 'Pedido Confirmado - Omnix Core'; ?>
<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto text-center">
        <div class="mb-8">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-32 w-32 mx-auto text-success mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <h1 class="text-5xl font-bold mb-4">¡Muchas gracias por tu compra!</h1>
            <p class="text-2xl text-gray-600">Vuelve pronto 😊</p>
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
                    <a href="<?= Helpers::url('product/index') ?>" class="btn btn-primary">Seguir Comprando</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>