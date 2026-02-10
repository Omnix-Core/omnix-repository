</main>

<footer class="footer footer-center p-10 bg-base-300 text-base-content mt-16">
    <div class="grid grid-flow-col gap-4">
        <a href="/" class="link link-hover">Inicio</a> 
        <a href="/product/index" class="link link-hover">Productos</a> 
    </div> 
    <div>
        <p>© 2026 Omnix Core - Proyecto TFG DAW</p>
    </div>
</footer>

<script>
// Actualizar contador del carrito al cargar
document.addEventListener('DOMContentLoaded', function() {
    <?php if (Auth::check()): ?>
        fetch('/cart/count')
            .then(response => response.json())
            .then(data => {
                const badge = document.getElementById('cart-count');
                if (badge && data.count !== undefined) {
                    badge.textContent = data.count;
                }
            })
            .catch(error => console.error('Error:', error));
    <?php endif; ?>
});
</script>
</body>
</html>