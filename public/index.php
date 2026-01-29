<?php

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../app/models/ProductoRepository.php';

// Creamos el repositorio
$productoRepo = new ProductoRepository();

// Obtenemos todos los productos
$productos = $productoRepo->findAll();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Tienda Tecnológica - DEV</title>

    <!-- Pico.css -->
    <link
        rel="stylesheet"
        href="https://unpkg.com/@picocss/pico@latest/css/pico.min.css"
    >
</head>
<body>

<main class="container">
    <h1>Tienda Tecnológica</h1>
    <p>Vista provisional de productos (modo desarrollo)</p>

    <section class="grid">
        <?php if (empty($productos)): ?>
            <p>No hay productos disponibles.</p>
        <?php else: ?>
            <?php foreach ($productos as $producto): ?>
                <article>
                    <h3><?= htmlspecialchars($producto->getNombre()) ?></h3>

                    <p><?= htmlspecialchars($producto->getDescripcion()) ?></p>

                    <p>
                        <strong><?= $producto->getPrecioBaseFormateado() ?></strong><br>
                        <small><?= $producto->getCategoriaNombre() ?></small>
                    </p>

                    <p><?= $producto->getStockTexto() ?></p>
                </article>
            <?php endforeach; ?>
        <?php endif; ?>
    </section>
</main>

</body>
</html>
