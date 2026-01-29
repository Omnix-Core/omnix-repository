<?php

require_once __DIR__ . '/../app/models/ProductRepository.php';

$productoRepo = new ProductRepository();
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

    <!-- Estilos SOLO para desarrollo -->
    <style>
        .products {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 1rem;
        }
    </style>
</head>
<body>

<main class="container">
    <h1>Tienda Tecnológica</h1>
    <p>Vista provisional de productos (modo desarrollo)</p>

    <?php if (empty($productos)): ?>
        <p>No hay productos disponibles.</p>
    <?php else: ?>
        <section class="products">
            <?php foreach ($productos as $producto): ?>
                <article>
                    <h3><?= htmlspecialchars($producto->getNombre()) ?></h3>

                    <p><?= htmlspecialchars($producto->getDescripcion()) ?></p>

                    <p>
                        <strong><?= $producto->getPrecioBaseFormateado() ?></strong><br>
                        <small><?= htmlspecialchars($producto->getCategoriaNombre()) ?></small>
                    </p>

                    <p><?= $producto->getStockTexto() ?></p>
                </article>
            <?php endforeach; ?>
        </section>
    <?php endif; ?>
</main>

</body>
</html>
