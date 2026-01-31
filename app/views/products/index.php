<?php foreach ($productos as $producto): ?>
    <article>
        <h3><?= htmlspecialchars($producto->getNombre()) ?></h3>

        <p><?= htmlspecialchars($producto->getDescripcion()) ?></p>

        <p>
            <strong><?= $producto->getPrecioBaseFormateado() ?></strong><br>
            <small><?= htmlspecialchars($producto->getCategoriaNombre()) ?></small>
        </p>

        <p><?= $producto->getStockTexto() ?></p>

        <button type="submit" class="add-to-cart" data-id="<?= $producto->getId() ?>">Añadir al carrito</button>
    </article>
<?php endforeach; ?>
