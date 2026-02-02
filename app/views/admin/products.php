<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="container mx-auto px-4 py-8">
    <div class="max-w-7xl mx-auto">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold">Gestión de Productos</h1>
            <button onclick="openCreateModal()" class="btn btn-primary">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Nuevo Producto
            </button>
        </div>

        <div class="card bg-base-100 shadow-xl">
            <div class="card-body">
                <div class="overflow-x-auto">
                    <table class="table w-full">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Imagen</th>
                                <th>Nombre</th>
                                <th>Categoría</th>
                                <th>Precio</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($products as $product): ?>
                                <tr>
                                    <td><?= $product->id ?></td>
                                    <td>
                                        <div class="avatar">
                                            <div class="w-12 rounded">
                                                <img src="/assets/images/products/<?= htmlspecialchars($product->image) ?>" 
                                                     alt="<?= htmlspecialchars($product->name) ?>"
                                                     onerror="this.src='/assets/images/products/default.jpg'" />
                                            </div>
                                        </div>
                                    </td>
                                    <td><?= htmlspecialchars($product->name) ?></td>
                                    <td>
                                        <span class="badge badge-primary">
                                            <?= htmlspecialchars($product->category_name ?? 'Sin categoría') ?>
                                        </span>
                                    </td>
                                    <td class="font-bold">€<?= number_format($product->price, 2) ?></td>
                                    <td>
                                        <div class="flex gap-2">
                                            <button onclick='editProduct(<?= json_encode($product) ?>)' class="btn btn-sm btn-info">
                                                Editar
                                            </button>
                                            <button onclick="deleteProduct(<?= $product->id ?>)" class="btn btn-sm btn-error">
                                                Eliminar
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<dialog id="product_modal" class="modal">
    <div class="modal-box w-11/12 max-w-2xl">
        <h3 class="font-bold text-lg mb-4" id="modal_title">Nuevo Producto</h3>
        <form id="product_form" class="space-y-4">
            <input type="hidden" id="product_id" name="id">
            
            <div class="form-control">
                <label class="label"><span class="label-text">Nombre *</span></label>
                <input type="text" id="product_name" name="name" class="input input-bordered" required />
            </div>

            <div class="form-control">
                <label class="label"><span class="label-text">Descripción</span></label>
                <textarea id="product_description" name="description" class="textarea textarea-bordered" rows="3"></textarea>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div class="form-control">
                    <label class="label"><span class="label-text">Precio * (€)</span></label>
                    <input type="number" id="product_price" name="price" step="0.01" min="0" class="input input-bordered" required />
                </div>

                <div class="form-control">
                    <label class="label"><span class="label-text">Categoría *</span></label>
                    <select id="product_category" name="category_id" class="select select-bordered" required>
                        <option value="">Selecciona...</option>
                        <?php foreach ($categories as $cat): ?>
                            <option value="<?= $cat->id ?>"><?= htmlspecialchars($cat->name) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="form-control">
                <label class="label"><span class="label-text">Imagen (nombre del archivo)</span></label>
                <input type="text" id="product_image" name="image" placeholder="producto.jpg" class="input input-bordered" />
            </div>

            <div class="modal-action">
                <button type="button" onclick="closeModal()" class="btn">Cancelar</button>
                <button type="submit" class="btn btn-primary">Guardar</button>
            </div>
        </form>
    </div>
</dialog>

<script>
let isEditing = false;

function openCreateModal() {
    isEditing = false;
    document.getElementById('modal_title').textContent = 'Nuevo Producto';
    document.getElementById('product_form').reset();
    document.getElementById('product_modal').showModal();
}

function editProduct(product) {
    isEditing = true;
    document.getElementById('modal_title').textContent = 'Editar Producto';
    document.getElementById('product_id').value = product.id;
    document.getElementById('product_name').value = product.name;
    document.getElementById('product_description').value = product.description || '';
    document.getElementById('product_price').value = product.price;
    document.getElementById('product_category').value = product.category_id;
    document.getElementById('product_image').value = product.image || '';
    document.getElementById('product_modal').showModal();
}

function closeModal() {
    document.getElementById('product_modal').close();
}

document.getElementById('product_form').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const url = isEditing ? '/admin/updateProduct' : '/admin/createProduct';
    
    fetch(url, {
        method: 'POST',
        body: new URLSearchParams(formData)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(data.message);
            location.reload();
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error al guardar el producto');
    });
});

function deleteProduct(id) {
    if (!confirm('¿Estás seguro de eliminar este producto?')) return;
    
    fetch('/admin/deleteProduct', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: `id=${id}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(data.message);
            location.reload();
        } else {
            alert('Error: ' + data.message);
        }
    });
}
</script>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>