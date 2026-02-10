<?php $title = 'Finalizar Compra - Omnix Core'; ?>
<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="container mx-auto px-4 py-8 max-w-4xl">
    <div class="text-center mb-8">
        <h1 class="text-4xl font-bold mb-4">Estás a punto de finalizar la compra</h1>
        <p class="text-lg text-gray-600">Rellena los datos y confirma tu pedido</p>
    </div>

    <div class="card bg-base-100 shadow-xl">
        <div class="card-body">
            <form method="POST" action="/order/process">
                <!-- Dirección -->
                <div class="form-control mb-4">
                    <label class="label">
                        <span class="label-text text-lg font-bold">¿Dónde quieres que te lo enviemos?</span>
                    </label>
                    <textarea name="shipping_address" 
                              class="textarea textarea-bordered h-24" 
                              placeholder="Escribe tu dirección completa aquí..."
                              required></textarea>
                </div>

                <!-- Método de pago -->
                <div class="form-control mb-6">
                    <label class="label">
                        <span class="label-text text-lg font-bold">¿Cómo vas a pagar?</span>
                    </label>
                    <select name="payment_method" class="select select-bordered" required>
                        <option value="">Elige una opción</option>
                        <option value="tarjeta">Tarjeta</option>
                        <option value="paypal">PayPal</option>
                        <option value="transferencia">Transferencia</option>
                        <option value="contrareembolso">Contrareembolso</option>
                    </select>
                </div>

                <!-- Resumen -->
                <div class="bg-base-200 p-4 rounded-lg mb-6">
                    <h3 class="font-bold text-xl mb-2">Resumen:</h3>
                    <p class="text-lg"><?= count($cartItems) ?> productos</p>
                    <p class="text-3xl font-bold text-primary mt-2">Total: €<?= number_format($cartTotal, 2) ?></p>
                </div>

                <!-- Botones -->
                <div class="flex gap-4">
                    <a href="/cart" class="btn btn-outline flex-1">Volver al Carrito</a>
                    <button type="submit" class="btn btn-primary flex-1">Confirmar Pedido</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>