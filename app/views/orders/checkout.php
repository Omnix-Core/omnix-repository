<?php $title = 'Finalizar Compra - Omnix Core'; ?>
<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-8">Finalizar Compra</h1>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Formulario de envío -->
        <div class="lg:col-span-2">
            <div class="card bg-base-100 shadow-xl">
                <div class="card-body">
                    <h2 class="card-title">Datos de Envío</h2>
                    <div class="divider"></div>
                    
                    <form method="POST" action="/order/process" id="checkout-form">
                        <div class="form-control mb-4">
                            <label class="label">
                                <span class="label-text font-bold">Dirección de Envío</span>
                            </label>
                            <textarea name="shipping_address" 
                                      class="textarea textarea-bordered h-24" 
                                      placeholder="Calle, número, piso&#10;Código postal, ciudad&#10;Provincia, país"
                                      required></textarea>
                        </div>

                        <div class="form-control mb-4">
                            <label class="label">
                                <span class="label-text font-bold">Método de Pago</span>
                            </label>
                            <select name="payment_method" class="select select-bordered" required>
                                <option value="">Selecciona un método</option>
                                <option value="tarjeta">Tarjeta de Crédito/Débito</option>
                                <option value="paypal">PayPal</option>
                                <option value="transferencia">Transferencia Bancaria</option>
                                <option value="contrareembolso">Contrareembolso</option>
                            </select>
                        </div>

                        <div class="alert alert-info">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="stroke-current shrink-0 w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span>Tu pedido será procesado inmediatamente tras confirmar la compra</span>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Resumen de productos -->
            <div class="card bg-base-100 shadow-xl mt-6">
                <div class="card-body">
                    <h2 class="card-title">Productos del Pedido (<?= count($cartItems) ?>)</h2>
                    <div class="divider"></div>
                    
                    <div class="space-y-4">
                        <?php foreach ($cartItems as $item): ?>
                            <div class="flex gap-4">
                                <img src="/assets/images/products/<?= htmlspecialchars($item->product_image) ?>" 
                                     alt="<?= htmlspecialchars($item->product_name) ?>"
                                     class="w-16 h-16 object-cover rounded"
                                     onerror="this.src='/assets/images/products/default.jpg'">
                                <div class="flex-1">
                                    <h3 class="font-bold"><?= htmlspecialchars($item->product_name) ?></h3>
                                    <p class="text-sm text-gray-600">Cantidad: <?= $item->quantity ?></p>
                                </div>
                                <div class="text-right">
                                    <p class="font-bold">€<?= number_format($item->quantity * $item->product_price, 2) ?></p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Resumen del pedido -->
        <div>
            <div class="card bg-base-100 shadow-xl sticky top-4">
                <div class="card-body">
                    <h2 class="card-title">Resumen del Pedido</h2>
                    <div class="divider"></div>
                    
                    <div class="space-y-2">
                        <div class="flex justify-between">
                            <span>Subtotal</span>
                            <span>€<?= number_format($cartTotal, 2) ?></span>
                        </div>
                        <div class="flex justify-between">
                            <span>Envío</span>
                            <span class="text-success">GRATIS</span>
                        </div>
                    </div>
                    
                    <div class="divider"></div>
                    
                    <div class="flex justify-between text-2xl font-bold mb-4">
                        <span>Total</span>
                        <span class="text-primary">€<?= number_format($cartTotal, 2) ?></span>
                    </div>

                    <button type="submit" form="checkout-form" class="btn btn-primary w-full">
                        Confirmar Pedido
                    </button>

                    <a href="/cart" class="btn btn-outline w-full mt-2">
                        Volver al Carrito
                    </a>

                    <div class="alert alert-warning mt-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                        <span class="text-sm">Al confirmar, aceptas nuestros términos y condiciones</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>