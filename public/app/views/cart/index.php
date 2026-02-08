<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Carrito</title>
</head>
<body>

<h1>Carrito de la compra</h1>

<?php if (empty($cart)): ?>
    <p>El carrito está vacío</p>
<?php else: ?>
    <ul>
        <?php foreach ($cart as $id => $cantidad): ?>
            <li>
                Producto <?= $id ?> — Cantidad: <?= $cantidad ?>
                <form method="POST" action="/cart/remove">
                    <input type="hidden" name="id" value="<?= $id ?>">
                    <button type="submit">Eliminar</button>
                </form>
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<a href="/">Volver a la tienda</a>

</body>
</html>
