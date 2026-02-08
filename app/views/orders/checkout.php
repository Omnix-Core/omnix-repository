<?php $title = 'Checkout - Omnix Core'; ?>
<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="hero min-h-screen bg-base-200">
    <div class="hero-content text-center">
        <div class="max-w-md">
            <!-- Icono de construcción -->
            <h1 class="text-5xl font-bold mb-4">Página en Construcción</h1>
            
            <p class="text-lg mb-8">
                La funcionalidad de pago y checkout está actualmente en desarrollo.
                <br>
                <span class="text-gray-600">Pronto estará disponible para procesar tus pedidos.</span>
            </p>
            
            
            <div class="flex flex-col gap-4">
                <a href="<?= Helpers::url('home/index') ?>" class="btn btn-primary btn-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    Volver al Inicio
                </a>
                
                <a href="<?= Helpers::url('product/index') ?>" class="btn btn-outline btn-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    Seguir Comprando
                </a>
            </div>
            
            <div class="alert alert-info mt-8">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="stroke-current shrink-0 w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span class="text-left">
                    <strong>Nota:</strong> Tu carrito se mantendrá guardado. 
                    Puedes volver más tarde cuando esta funcionalidad esté disponible.
                </span>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>